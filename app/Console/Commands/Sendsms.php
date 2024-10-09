<?php

namespace App\Console\Commands;

use App\Models\Pending;
use Illuminate\Console\Command;

class Sendsms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendsms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (Pending::all() as $el) {
            $ok = sms($el->to, $el->text);
            if (!$ok) {
                $el->increment('retry');
            }
        }
        return Command::SUCCESS;
    }
}
