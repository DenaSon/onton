<?php

namespace App\Console\Commands;

use App\Jobs\DispatchNewsletterForwardingJob;
use Illuminate\Console\Command;

class DispatchNewsletterForwardingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletters:dispatch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DispatchNewsletterForwardingJob::dispatch()->onQueue('forward-newsletters');

        $this->info('DispatchNewsletterForwardingJob dispatched successfully.');
    }
}
