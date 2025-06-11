<?php

namespace App\Console\Commands;

use App\Jobs\CrawlEmailsJob;
use Illuminate\Console\Command;

class CrawlEmailsCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch the email crawler job to fetch unseen emails.';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        CrawlEmailsJob::dispatch()->onQueue('crawler');

        $this->info('CrawlEmailsJob dispatched successfully.');
    }
}
