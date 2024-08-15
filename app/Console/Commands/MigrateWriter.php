<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\LanguageManagement\App\Models\Language;
use Modules\WriterManagement\App\Models\Writer;
use Modules\WriterManagement\App\Models\WriterLanguageMap;

class MigrateWriter extends Command
{
    protected $signature = 'migrate:writers';
    protected $description = 'Migrate Kesen old writers to new Kesen writers.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Start time
        $startTime = microtime(true);

        // Fetch data from writer table
        $oldWriters = DB::connection('source_db')->table('writer')->orderBy('id')->get();

        /** creating writer */
        foreach ($oldWriters as $data) {

            // Insert data into writer table
            $writer = new Writer();
            $writer->sr_no=$data->id;
            $writer->writer_name = isset($data->name)&&!empty($data->name)?$data->name:'';
            $writer->email = isset($data->email)&&!empty($data->email)?$data->email:'';
            $writer->phone_no = isset($data->contactno)&&!empty($data->contactno)?$data->contactno:null;
            $writer->landline = isset($data->landline)&&!empty($data->landline)?$data->landline:null;
            $writer->address = isset($data->address)&&!empty($data->address)?$data->address:null;
            $writer->code = isset($data->code)&&!empty($data->code)?$data->code:'';
            $writer->status = $data->status;
            $writer->created_by = '9c73b245-bb2a-48e3-81db-5eee86932412';
            $writer->updated_by = '9c73b245-bb2a-48e3-81db-5eee86932412';
            $writer->save();
            $this->info("Writer {$data->name} is added.");

            // Fetch data from language map table
            $oldWriterLanguage = DB::connection('source_db')->table('writer_language_map')->where('writer_id',$data->id)->get();

            /** Creating language */
            foreach ($oldWriterLanguage as $language) {

                // Insert data into client language table
                $language_map = new WriterLanguageMap();
                $language_map->writer_id = $writer->id;
                $languageName = DB::connection('source_db')->table('language')->where('id',$language->language_id)->first()->name;
                $newLanguageId = Language::where('name',$languageName)->first()->id;
                $language_map->language_id = $newLanguageId;
                $language_map->per_unit_charges = $language->perunitcharges;
                $language_map->checking_charges = $language->checkingcharges;
                $language_map->bt_charges = $language->btcharges;
                $language_map->bt_checking_charges = $language->btcheckingcharges;
                $language_map->verification_2= $language->verification_2??0;
                $language_map->advertising_charges = $language->advertisingcharges;
                $language_map->save();
                $this->info("Language {$languageName} is added in Writer {$data->name}.");
            }
        }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info('Migration of writers and their languages has been completed successfully in ' . round($executionTime, 2) . ' seconds.');
    }
}