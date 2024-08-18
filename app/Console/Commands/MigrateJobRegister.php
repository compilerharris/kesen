<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\EstimateManagement\App\Models\NoEstimates;
use Modules\JobRegisterManagement\App\Models\JobRegister;
use Modules\LanguageManagement\App\Models\Language;

class MigrateJobRegister extends Command
{
    protected $signature = 'migrate:job-register';
    protected $description = 'Migrate Kesen old job registers to new Kesen job register as a no estimate job card.';

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

        // Fetch data from job register table
        $oldJobRegister = DB::connection('source_db')->table('jobregister')->orderBy('id')->whereBetween('id',[39262,40000])->get();

        foreach ($oldJobRegister as $data) {

            /** Creating no estimate */
            $estimate = new NoEstimates();
            $newClientId = Client::where('srno',$data->client_id)->first()->id??'';
            $estimate->client_id = $newClientId;
            $estimate->client_contact_person_id = ContactPerson::where('client_id',$newClientId)->where('srno',$data->clientcontacts_id)->first()->id??'';
            $estimate->created_by = '9c73b245-bb2a-48e3-81db-5eee86932412';
            $estimate->updated_by = '9c73b245-bb2a-48e3-81db-5eee86932412';
            $estimate->save();
            $this->info("No Estimate of job register no {$data->id} is added.");
            
            /** Creating no estimate detail */
            $oldLanguageIds = DB::connection('source_db')->table('jobreglang')->where('jobregister_id',$data->id)->get();
            foreach($oldLanguageIds as $regLang){
                EstimatesDetails::updateOrCreate([
                    'estimate_id' => $estimate->id,
                    'document_name' => $data->headline,
                    'lang' => Language::where('sr_no',$regLang->language_id)->first()->id??'',
                ], [
                    'estimate_id' => $estimate->id,
                    'document_name' => $data->headline,
                    'estimate_type' => 'no_estimate',
                    'type' => "NA",
                    'unit' => "0",
                    'rate' => 0,
                    'verification' => null,
                    'verification_2' => null,
                    'back_translation' => null,
                    'layout_charges' => null,
                    'layout_charges_2' => null,
                    'lang' => Language::where('sr_no',$regLang->language_id)->first()->id??'',
                    'two_way_qc_t' => null,
                    'two_way_qc_bt' => null,
                ]);
                $this->info("No Estimate Details of job register no {$data->id} is added.");
            }

            /** Creating job register */
            $jobRegister = new JobRegister();
            $jobRegister->sr_no = $data->id;
            $jobRegister->client_id = $newClientId;
            $jobRegister->client_contact_person_id = ContactPerson::where('client_id',$newClientId)->where('srno',$data->clientcontacts_id)->first()->id??'';
            $jobRegister->estimate_id = $estimate->id;
            $jobRegister->handled_by_id = User::where('srno',$data->handledby)->first()->id??'';
            $jobRegister->created_by_id = '9c73b245-bb2a-48e3-81db-5eee86932412';
            $jobRegister->other_details = $data->otherdetails;
            $jobRegister->category = '';
            $jobRegister->estimate_document_id = $data->headline;
            $jobRegister->type = null;
            $jobRegister->old_job_no=$data->oldjobno;
            $jobRegister->client_accountant_person_id = User::where('srno',$data->accountant)->first()->id??'';
            $jobRegister->date = $data->deliverydate;
            $jobRegister->description = $data->headline;
            $jobRegister->protocol_no = $data->protocolno;
            $jobRegister->version_date = $data->versiondate;
            $jobRegister->version_no = $data->versionno;
            $jobRegister->status = $data->status;
            $jobRegister->cancel_reason = null;
            $jobRegister->remark = $data->remarks;
            $jobRegister->bill_no = $data->billno;
            $jobRegister->bill_date = $data->invoicedate;
            $jobRegister->invoice_date = null;
            $jobRegister->sent_date = $data->billsentdate;
            $jobRegister->informed_to = ContactPerson::where('client_id',$newClientId)->where('name',$data->informedto)->first()->id??(ContactPerson::where('client_id',$newClientId)->where('srno',$data->informedto)->first()->id??'');
            $jobRegister->operator = $data->checkedwithoperator;
            $jobRegister->created_at = $data->created_date;
            $jobRegister->updated_at = $data->modified_date;
            $jobRegister->save();
            $this->info("Job register no {$data->id} is added.");
            $count++;
        }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info('Migration of ' . $count . ' job register has been completed successfully in ' . round($executionTime, 2) . ' seconds.');
    }
}