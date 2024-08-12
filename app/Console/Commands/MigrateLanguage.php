<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\LanguageManagement\App\Models\Language;

class MigrateLanguage extends Command
{
    protected $signature = 'migrate:languages';
    protected $description = 'Migrate Kesen old languages to new Kesen languages.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Start time
        $startTime = microtime(true);

        // Fetch data from languages table
        $oldLanguages = DB::connection('source_db')->table('language')->get();

        /** creating languages */
        foreach ($oldLanguages as $data) {

            // Insert data into languages table
            $language = new Language();
            $language->name = $data->name;
            $language->code = '';
            $language->created_by='9c73b245-bb2a-48e3-81db-5eee86932412';
            $language->updated_by='9c73b245-bb2a-48e3-81db-5eee86932412';
            $language->save();
            $this->info("Language {$data->name} is added.");

        }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info('Migration of languages has been completed successfully in ' . round($executionTime, 2) . ' seconds.');
    }
}