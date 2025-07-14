<?php

namespace App\Services\Crawler;

use Closure;
use Illuminate\Support\Carbon;
use RuntimeException;
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
class MailCrawlerService
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

    public bool $emptyFolder = false;

    /**
     * Establish an IMAP connection for the given account.
     *
     * @param string $account IMAP account name configured in Webklex config
     * @return \Webklex\PHPIMAP\Client
     *
     * @throws RuntimeException If connection to the IMAP server fails
     */
    protected function imapConnection(string $account = 'default'): \Webklex\PHPIMAP\Client
    {
        try {
            \Log::info('[MailCrawlerService] About to connect IMAP');

            $client = Client::account($account);
            \Log::info('[MailCrawlerService] Connected IMAP successfully');

            if ($client->isConnected()) {
                \Log::info('[Restart connection');
                $client->disconnect();
            }

            $client->connect();
            \Log::info('[MailCrawlerService] Client connected successfully');


            if (!$client->isConnected()) {
                \Log::error("[MailCrawlerService] connection failed: client is not connected after connect() call", [
                    'account' => $account,
                ]);
                throw new RuntimeException("[MailCrawlerService] connection failed for account '{$account}'. Client not connected.");
            }

            \Log::info('[MailCrawlerService] Run checkConnection() method');
            $client->checkConnection();

            \Log::info('[MailCrawlerService] OK | All connections successfully');
            return $client;

        } catch (\Throwable $e) {
            \Log::error("[MailCrawlerService] IMAP connection exception on account '{$account}': " . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new RuntimeException("[MailCrawlerService] failed to connect to  account: '{$account}'", previous: $e);
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
     * @param Closure|null $queryCallback Optional callback to customize the query, receives and returns QueryBuilder
     * @return $this
     *
     * @throws RuntimeException If connection or fetching emails fails
     */
    public function crawl(string $account = 'default', string $folder = 'INBOX', Closure $queryCallback = null): self
    {
        $client = $this->imapConnection($account);

        try {
            // Defensive handling of folder parameter
            if ($folder instanceof \Webklex\PHPIMAP\Folder) {
                $folderObj = $folder;
                $folderName = $folder->name ?? 'unknown';
            } else {
                $folderObj = $client->getFolderByName($folder);
                $folderName = $folder; // keep original folder name for logging
            }

            if (!$folderObj) {
                throw new RuntimeException("IMAP folder '{$folderName}' not found.");
            }

            $query = $folderObj->query();

            $query = $queryCallback
                ? $queryCallback($query)
                : $query->fetchOrderDesc()
                    ->softFail()
                    ->unseen()
                    ->since(Carbon::now()->subDays(5))
                    ->limit(10);

            $this->messages = $query->get();
            $errors = $query->errors();

            if (!empty($errors)) {
                \Log::warning('[MailCrawlerService] query returned with soft errors [END]', [
                    'errors' => $errors,
                ]);
            }

            //$this->logAllFolders('default');


        } catch (\Throwable $e) {
            \Log::error("[MailCrawlerService] crawling failed for account '{$account}', folder '{$folderName}': " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            throw new RuntimeException("[MailCrawlerService ] Mail crawling failed.", 0, $e);
        } finally {
            // Always attempt to disconnect, but handle any errors gracefully
            try {
                $client->disconnect();
            } catch (\Throwable $e) {
                \Log::warning("[MailCrawlerService] disconnect failed for account '{$account}': {$e->getMessage()}", [
                    'exception' => get_class($e),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
            }

            if (empty($this->messages) || (is_object($this->messages) && $this->messages->isEmpty())) {
                \Log::notice("[MailCrawlerService] Crawling complete: No new messages found in folder '{$folderName}'. [END]");

                $this->emptyFolder = true;

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
                'date' => $message->getDate()?->first() ?? 'unknown',
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


        if (empty($whiteListEmails)) {
            \Log::warning('[MailCrawlerService] Whitelist is empty. Skipping whitelist filtering.');
            return $this;
        }

        if (empty($this->messages) || !is_array($this->messages)) {
            \Log::warning('[MailCrawlerService] No messages available to apply whitelist filtering.');
            return $this;
        }

        // Normalize whitelist emails
        $whiteListEmails = array_map(
            fn($email) => strtolower(trim($email)),
            array_filter($whiteListEmails, fn($email) => !empty($email))
        );

        $beforeCount = count($this->messages);

        $this->messages = collect($this->messages)->filter(function ($message) use ($whiteListEmails) {
            $from = strtolower(trim($message['from'] ?? ''));
            return $from && in_array($from, $whiteListEmails);
        })->values()->toArray();

        $afterCount = count($this->messages);

        \Log::info("[MailCrawlerService] Whitelist filtering applied. Remaining emails: {$afterCount} / {$beforeCount}");

        return $this;
    }




    /**
     * Saves attachments from the parsed messages to the specified path.
     *
     * Note: This method currently only returns the attachment names as placeholders.
     * Real implementation should save the files physically using $attachment->save($path).
     *
     * @param string|null $basePath
     * @return MailCrawlerService List of saved attachment file names
     */
    public function saveAttachments(?string $basePath = null): self
    {

        $basePath = $basePath ?? storage_path('app/attachments/' . date('Ymd'));
        $baseUrl = str_replace(storage_path('app'), '/storage', $basePath);

        $totalMessages = count($this->messages);
        $totalAttachments = 0;
        $savedCount = 0;
        $errorCount = 0;

        foreach ($this->messages as &$message) {
            if (!isset($message['__raw']) || !($message['__raw'] instanceof Message)) {
                continue;
            }

            $rawMessage = $message['__raw'];

            if (!$rawMessage->hasAttachments()) {
                continue;
            }

            $attachments = [];

            foreach ($rawMessage->getAttachments() as $attachment) {
                $totalAttachments++;

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

                    $savedCount++;
                } catch (\Throwable $e) {
                    $errorCount++;
                    \Log::error("[MailCrawlerService] Failed to save attachment '{$attachment->getName()}'", [
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $message['attachments'] = $attachments;
        }

        \Log::info("[MailCrawlerService] Attachments processing completed. Messages: {$totalMessages}, Attachments found: {$totalAttachments}, Saved: {$savedCount}, Failed: {$errorCount}");

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


        $total = $this->messages->count();
        $successCount = 0;
        $errorCount = 0;

        foreach ($this->messages as $message) {
            try {
                $message->setFlag(['Seen', 'Flagged']);
                $successCount++;
            } catch (\Throwable $e) {
                $errorCount++;
                \Log::error("[MailCrawlerService] Failed to mark message as read. UID: {$message->getUid()}", [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        \Log::info("[MailCrawlerService] MarkAsRead completed. Success: {$successCount}, Failures: {$errorCount}, Total: {$total}");

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

    public function folderIsEmpty(): bool
    {
        return $this->emptyFolder;
    }

    /**
     * Logs all available folders for the given IMAP account.
     *
     * Useful for discovering the correct folder names (e.g., [Gmail]/Spam).
     *
     * @param string $account
     * @return void
     */
    public function logAllFolders(string $account = 'default'): void
    {
        try {
            $client = $this->imapConnection($account);
            $folders = $client->getFolders(false); // false = non-recursive

            \Log::info("[MailCrawlerService] Folders found for account '{$account}':");

            foreach ($folders as $folder) {
                \Log::info(" - " . $folder->name);
            }

            $client->disconnect();
        } catch (\Throwable $e) {
            \Log::error("[MailCrawlerService] Failed to list folders: " . $e->getMessage(), [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }



}
