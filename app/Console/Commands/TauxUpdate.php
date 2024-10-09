<?php

namespace App\Console\Commands;

use App\Models\Taux;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TauxUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taux';

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
        $taux = Taux::first();
        $auto = $taux->auto;

        if ($auto) {
            remotetaux();
        }
        return Command::SUCCESS;
    }
}
