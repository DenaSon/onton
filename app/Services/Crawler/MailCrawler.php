<?php

namespace App\Services\Crawler;

use Illuminate\Support\Carbon;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Message;
use Webklex\PHPIMAP\Support\MessageCollection;

/**
 * Class MailCrawler
 *
 * Service for crawling emails using IMAP and the Webklex package.
 * Provides functionality to fetch emails, filter, parse, mark as read, and save attachments.
 *
 * @package App\Services\Crawler
 */
class MailCrawler
{
    /**
     * Collection of raw messages or an array of parsed messages.
     *
     * Before calling parse(), this is a MessageCollection.
     * After parse(), it becomes an array of processed message data.
     *
     * @var MessageCollection|array
     */
    protected MessageCollection|array $messages = [];

    /**
     * Flag indicating whether to mark messages as read.
     * Currently used for internal state only.
     *
     * @var bool
     */
    protected bool $markAsRead = false;

    /**
     * Establish an IMAP connection for the given account.
     *
     * @param string $account IMAP account name configured in Webklex config
     * @return \Webklex\PHPIMAP\Client
     *
     * @throws \RuntimeException If connection to the IMAP server fails
     */
    protected function imapConnection(string $account = 'default'): \Webklex\PHPIMAP\Client
    {
        try {
            $client = Client::account($account);
            $client->connect();

            if (!$client->isConnected()) {
                throw new \RuntimeException("IMAP connection failed for account: {$account}");
            }

            $client->checkConnection();

            return $client;

        } catch (\Throwable $e) {
            \Log::error("IMAP connection exception for account {$account}: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            throw new \RuntimeException("Failed to connect to IMAP account '{$account}'", 0, $e);
        }
    }


    /**
     * Crawls emails from a specified folder and account, optionally applying a query callback.
     *
     * If no callback is provided, it fetches unseen emails from the last 7 days,
     * in descending order, limiting to 10 messages.
     *
     * @param string $account IMAP account name
     * @param string $folder Folder name (e.g., 'INBOX')
     * @param \Closure|null $queryCallback Optional callback to customize the query, receives and returns QueryBuilder
     * @return $this
     *
     * @throws \RuntimeException If connection or fetching emails fails
     */
    public function crawl(string $account = 'default', string $folder = 'INBOX', \Closure $queryCallback = null): self
    {
        $client = $this->imapConnection($account);
        try {


            $folder = $client->getFolderByName($folder);
            if (!$folder) {
                throw new \RuntimeException("IMAP folder '{$folder}' not found.");
            }

            $query = $folder->query();

            $query = $queryCallback
                ? $queryCallback($query)
                : $query->fetchOrderDesc()
                    ->softFail()
                    ->unseen()
                    ->since(Carbon::now()->subDays(7))
                    ->limit(10);

            $this->messages = $query->get();
            $errors = $query->errors();
            if (!empty($errors)) {
                \Log::warning('IMAP query returned with soft errors', [
                    'errors' => $errors,
                ]);
            }


        } catch (\Throwable $e) {
            \Log::error("Mail crawling failed for account {$account}, folder {$folder}: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);


            throw new \RuntimeException("Mail crawling failed.", 0, $e->getMessage());
        } finally {

            try {

                $client->disconnect();

                // If no messages crawled, log warning
                if (empty($this->messages) || (is_object($this->messages) && method_exists($this->messages, 'isEmpty') && $this->messages->isEmpty())) {
                    \Log::warning('IMAP query returned without messages');
                }

            } catch (\Throwable $e) {
                \Log::warning("IMAP disconnect failed: " . $e->getMessage());
            }

        }

        return $this;
    }


    /**
     * Parses raw email messages into an array format with extracted data.
     *
     * After parsing, messages are arrays with keys such as:
     * 'subject', 'from', 'date', 'text', 'html', and 'attachments'.
     * Attachments themselves are arrays with 'name', 'size', and 'type'.
     *
     * @return $this
     */
    public function parse(): self
    {
        $this->messages = collect($this->messages)->map(function (Message $message) {
            return [
                '__raw' => $message,
                'subject' => $message->getSubject()?->get() ?? 'No subject',
                'from' => optional($message->getFrom())[0]->mail ?? 'unknown',
                'date' => optional($message->getDate()),
                'text' => $message->getTextBody(),
                'html' => $message->getHTMLBody(),
                'attachments' => collect($message->getAttachments())->map(function ($attachment) {
                    return [
                        'name' => $attachment->getName(),
                        'size' => $attachment->getSize(),
                        'type' => $attachment->getMimeType(),
                    ];
                })->toArray(),
            ];
        })->toArray();

        return $this;
    }

    /**
     * Filters parsed messages by a keyword found in the subject or text body.
     *
     * Case-insensitive search.
     *
     * @param string $keyword Keyword to search for
     * @return $this
     */
    public function filterByKeyword(string $keyword): self
    {
        $this->messages = collect($this->messages)->filter(function ($message) use ($keyword) {
            return str_contains(strtolower($message['subject']), strtolower($keyword)) ||
                str_contains(strtolower($message['text']), strtolower($keyword));
        })->values()->toArray();

        return $this;
    }

    /**
     * Filters parsed messages by a whitelist of sender email addresses.
     *
     * @param string[] $whiteListEmails Array of allowed sender email addresses
     * @return $this
     */
    public function filterByWhitelistFrom(array $whiteListEmails): self
    {
        $whiteListEmails = array_map('strtolower', $whiteListEmails);

        $this->messages = collect($this->messages)->filter(function ($message) use ($whiteListEmails) {
            return in_array(strtolower($message['from']), $whiteListEmails);
        })->values()->toArray();

        return $this;
    }

    /**
     * Saves attachments from the parsed messages to the specified path.
     *
     * Note: This method currently only returns the attachment names as placeholders.
     * Real implementation should save the files physically using $attachment->save($path).
     *
     * @param string|null $basePath
     * @return MailCrawler List of saved attachment file names
     */
    public function saveAttachments(?string $basePath = null): self
    {
        $basePath = $basePath ?? storage_path('app/attachments/' . date('Ymd'));
        $baseUrl = str_replace(storage_path('app'), '/storage', $basePath);

        foreach ($this->messages as &$message) {
            if (isset($message['__raw']) && $message['__raw'] instanceof Message) {
                $rawMessage = $message['__raw'];

                if ($rawMessage->hasAttachments()) {
                    $attachments = [];

                    foreach ($rawMessage->getAttachments() as $attachment) {
                        try {
                            $filename = $attachment->getName();
                            $attachment->save($basePath);

                            $attachments[] = [
                                'name' => $filename,
                                'path' => $basePath . DIRECTORY_SEPARATOR . $filename,
                                'url' => $baseUrl . '/' . $filename,
                                'size' => $attachment->getSize(),
                                'type' => $attachment->getMimeType(),
                            ];
                        } catch (\Throwable $e) {
                            report($e);
                        }
                    }

                    $message['attachments'] = $attachments;
                }
            }
        }

        return $this;
    }


    /**
     * Marks all fetched raw messages as read (sets the 'Seen' flag).
     *
     * This only works when $this->messages is a MessageCollection,
     * so it should be called before parse().
     * Any errors are caught and reported.
     *
     * @return $this
     */
    public function markAsRead(): self
    {
        if (!empty($this->messages) && $this->messages instanceof MessageCollection) {
            foreach ($this->messages as $message) {
                try {
                    $message->setFlag(['Seen', 'Flagged']);
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }

        return $this;
    }

    /**
     * Returns the current set of messages.
     * Could be raw MessageCollection or parsed array depending on the state.
     *
     * @return array
     */
    public function get(): array
    {
        return $this->messages;
    }
}
