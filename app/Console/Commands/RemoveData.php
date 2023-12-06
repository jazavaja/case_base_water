<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cbr:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('nozzle')->delete();
        DB::table('case_base')->delete();
        DB::statement('ALTER TABLE nozzle AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE case_base AUTO_INCREMENT = 1');

    }
}
