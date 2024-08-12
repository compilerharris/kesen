<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateJobCard extends Command
{
    protected $signature = 'migrate:table-data';
    protected $description = 'Migrate Kesen old job cards to new Kesen job register as a no estimate job card.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch data from source table
        $oldJobRegister = DB::connection('source_db')->table('jobregister')->whereBetween('id',[23104,23105])->get();

        /** Creating no estimate */
        
    }
}