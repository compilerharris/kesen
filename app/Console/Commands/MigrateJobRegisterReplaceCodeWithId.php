<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\WriterManagement\App\Models\Writer;

class MigrateJobRegisterReplaceCodeWithId extends Command
{
    protected $signature = 'migrate:job-register-replace-code-with-id';
    protected $description = 'Changes in migration replace job register code with id.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Start time
        $startTime = microtime(true);

        // Operation Count
        $count = 0;

        // Fetch data from client table
        $jobRegisters = JobRegister::orderBy('sr_no')->whereBetween('sr_no',[37000,40000])->get();

        /** creating client */
        // foreach ($jobRegisters as $data) {
        //     $this->info("Checking codes in Job register no {$data->sr_no}.");
        //     if((isset($data->t_writer_code) && !empty($data->t_writer_code)) || (isset($data->v_employee_code) && !empty($data->v_employee_code)) || (isset($data->bt_writer_code) && !empty($data->bt_writer_code)) || (isset($data->btv_employee_code) && !empty($data->btv_employee_code))){
        //         if(isset($data->t_writer_code) && !empty($data->t_writer_code)){
        //             $writer = Writer::where('code',$data->t_writer_code)->first();
        //             if($writer){
        //                 $data['t_writer_code'] = $writer->id;
        //             }
        //         }
        //         if(isset($data->v_employee_code) && !empty($data->v_employee_code)){
        //             $writer = Writer::where('code',$data->v_employee_code)->first();
        //             if($writer){
        //                 $data['v_employee_code'] = $writer->id;
        //             }else{
        //                 $user = User::where('code',$data->v_employee_code)->first();
        //                 if($user){
        //                     $data['v_employee_code'] = $user->id;
        //                 }
        //             }
        //         }
        //         if(isset($data->bt_writer_code) && !empty($data->bt_writer_code)){
        //             $writer = Writer::where('code',$data->bt_writer_code)->first();
        //             if($writer){
        //                 $data['bt_writer_code'] = $writer->id;
        //             }
        //         }
        //         if(isset($data->btv_employee_code) && !empty($data->btv_employee_code)){
        //             $writer = Writer::where('code',$data->btv_employee_code)->first();
        //             if($writer){
        //                 $data['btv_employee_code'] = $writer->id;
        //             }else{
        //                 $user = User::where('code',$data->btv_employee_code)->first();
        //                 if($user){
        //                     $data['btv_employee_code'] = $user->id;
        //                 }
        //             }
        //         }
        //         $data->save();
        //         $this->info("Job card no {$data->sr_no} updated.");
        //         $count++;
        //     }else{
        //         $this->info("No codes found to be updated in Job card no {$data->sr_no}.");
        //     }
        // }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info("Replacement of {$count} code with id has been completed successfully in " . round($executionTime, 2) . " seconds.");
    }
}