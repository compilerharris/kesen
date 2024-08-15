<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\NoEstimates;

class MigrateClient extends Command
{
    protected $signature = 'migrate:client-and-contact-person';
    protected $description = 'Migrate Kesen old client to new Kesen client.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Start time
        $startTime = microtime(true);

        // Fetch data from client table
        $oldClient = DB::connection('source_db')->table('client')->get();

        /** creating client */
        foreach ($oldClient as $data) {

            // Insert data into client table
            $client = new Client();
            $client->srno=$data->id;
            $client->name=$data->name;
            $client->email=isset($data->email)&&!empty($data->email)?$data->email:null;
            $client->phone_no=isset($data->phone_no)&&!empty($data->phone_no)?$data->phone_no:null;
            $client->landline=isset($data->landline)&&!empty($data->landline)?$data->landline:null;
            $client->type=$data->type;
            $client->client_accountant_person_id=0;
            $client->metrix=null;
            $client->protocol_data=null;
            $client->address=$data->address;
            $client->save();
            $this->info("Client {$data->name} is added.");

            // Fetch data from contact person table
            $oldClientContacts = DB::connection('source_db')->table('clientcontacts')->where('client_id',$data->id)->get();

            /** Creating contact person */
            foreach ($oldClientContacts as $contact) {

                // Insert data into client contact person table
                $contact_person = new ContactPerson();
                $contact_person->srno=$contact->id;
                $contact_person->client_id=$client->id;
                $contact_person->name=$contact->name;
                $contact_person->email=isset($contact->email)&&!empty($contact->email)?$contact->email:null;
                $contact_person->phone_no=isset($contact->contactno)&&!empty($contact->contactno)?$contact->contactno:null;
                $contact_person->landline=isset($contact->landline)&&!empty($contact->landline)?$contact->landline:null;
                $contact_person->designation=isset($contact->designation)&&!empty($contact->designation)?$contact->designation:null;
                $contact_person->save();
                $this->info("Contact person {$contact->name} is added in Client {$data->name}.");
            }
        }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info('Migration of clients and their contact person has been completed successfully in ' . round($executionTime, 2) . ' seconds.');
    }
}