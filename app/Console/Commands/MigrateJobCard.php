<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;

class MigrateJobCard extends Command
{
    protected $signature = 'migrate:job-cards';
    protected $description = 'Migrate Kesen old job cards to new Kesen job card.';

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

        // Fetch all job register
        $oldJobRegister = JobRegister::orderBy('sr_no')->whereBetween('sr_no',[39262,40000])->get()
        ;

        foreach ($oldJobRegister as $jobRegister){
            $carbon=Carbon::now()->getTimestampMs();

            // Fetch all Job Register languages
            $oldJobRegisterLanguages = DB::connection('source_db')->table('jobreglang')->where('jobregister_id',$jobRegister->sr_no)->orderBy('id')->get();

            foreach ($oldJobRegisterLanguages as $lang){
                // Fetch job card using job register no and lang 
                $oldJobCard = DB::connection('source_db')->table('jobcard')->orderBy('id')->where('jobregister_id',$jobRegister->sr_no)->where('language_id', $lang->language_id)->get();
                if(count($oldJobCard)>0){
                    $newJobCard = [];
                    foreach($oldJobCard as $data){
                        switch ($data->type) {
                            case 1:
                                $newJobCard['t_unit'] = $data->unit;
                                $newJobCard['t_writer_code'] = isset($data->writer_id) && !empty($data->writer_id) ? $data->writer_id : '';
                                $newJobCard['t_pd'] = $data->pd;
                                $newJobCard['t_cr'] = $data->cr;
                                $newJobCard['t_cnc'] = $data->cnc == 1 ? 'C' : 'NC';
                                $newJobCard['t_dv'] = $data->dv;
                                $newJobCard['t_fqc'] = $data->fqc;
                                $newJobCard['t_sentdate'] = $data->sentdate;
                                break;
                            case 2:
                                $newJobCard['v_unit'] = $data->unit;
                                $newJobCard['v_employee_code'] = isset($data->writer_id) && !empty($data->writer_id) ? $data->writer_id : $data->employeecode;
                                $newJobCard['v_pd'] = $data->pd;
                                $newJobCard['v_cr'] = $data->cr;
                                break;
                            case 3:
                                $newJobCard['bt_unit'] = $data->unit;
                                $newJobCard['bt_writer_code'] = $data->writer_id;
                                $newJobCard['bt_pd'] = $data->pd;
                                $newJobCard['bt_cr'] = $data->cr;
                                $newJobCard['bt_cnc'] = $data->cnc == 1 ? 'C' : 'NC';
                                $newJobCard['bt_dv'] = $data->dv;
                                $newJobCard['bt_fqc'] = $data->fqc;
                                $newJobCard['bt_sentdate'] = $data->sentdate;
                                break;
                            case 4:
                                $newJobCard['btv_unit'] = $data->unit;
                                $newJobCard['btv_employee_code'] = isset($data->writer_id) && !empty($data->writer_id) ? $data->writer_id : $data->employeecode;
                                $newJobCard['btv_pd'] = $data->pd;
                                $newJobCard['btv_cr'] = $data->cr;
                                break;
                            default:
                                break;
                        }
                    }
                    
                    $lang = Language::where('sr_no',$data->language_id)->first();
                    $estimateDetailId = EstimatesDetails::where('estimate_id',$jobRegister->estimate_id)->where('document_name',$jobRegister->estimate_document_id)->where('lang',$lang->id)->first()->id;
                    
                    $newJobCard['job_no'] = $jobRegister->sr_no;
                    $newJobCard['estimate_detail_id'] = $estimateDetailId;
                    $newJobCard['sync_no'] = $carbon;
                    JobCard::create($newJobCard);
                    $this->info("Job card no {$jobRegister->sr_no} with language {$lang->name} is added.");
                    $count++;
                }
            }
        }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info('Migration of ' . $count . ' job card has been completed successfully in ' . round($executionTime, 2) . ' seconds.');
    }
}