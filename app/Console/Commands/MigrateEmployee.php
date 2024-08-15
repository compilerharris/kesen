<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\LanguageManagement\App\Models\Language;

class MigrateEmployee extends Command
{
    protected $signature = 'migrate:employees';
    protected $description = 'Migrate Kesen old employees to new Kesen users.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Start time
        $startTime = microtime(true);

        // Fetch data from employee table
        $oldEmployees = DB::connection('source_db')->table('employee')->where('code','!=','KEI')->get();

        /** creating employee */
        foreach ($oldEmployees as $data) {

            // Insert data into employee table
            $employee = new User();
            $employee->srno = $data->id;
            $employee->name = $data->name;
            $employee->email = $data->email;
            $employee->password = bcrypt('K0076');
            $employee->plain_password = 'K0076';
            $employee->phone = $data->contactno;
            $employee->address = isset($data->address)&&!empty($data->address)?$data->address:null;
            $employee->code = $data->code;
            $employee->landline = isset($data->landline)&&!empty($data->landline)?$data->landline:null;
            /** get language names */
            $languageIds = DB::connection('source_db')->table('employee_language_map')->where('employee_id',$data->id)->pluck('language_id')->toArray();
            $languages = DB::connection('source_db')->table('language')->whereIn('id',$languageIds)->pluck('name')->toArray();
            $newLanguages = Language::whereIn('name',$languages)->pluck('id')->toArray();
            $employee->language_id = implode(',',$newLanguages);
            $employee->created_by = '9c73b245-bb2a-48e3-81db-5eee86932412';
            $employee->updated_by = '9c73b245-bb2a-48e3-81db-5eee86932412';
            $employee->status = 1;
            $employee->save();
            $employee->assignRole($data->role==4?5:$data->role);
            $this->info("Employee {$data->name} is added.");

        }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info('Migration of employees and their languages has been completed successfully in ' . round($executionTime, 2) . ' seconds.');
    }
}