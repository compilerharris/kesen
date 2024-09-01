<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\LanguageManagement\App\Models\Language;
use Modules\WriterManagement\App\Models\Writer;
use Modules\WriterManagement\App\Models\WriterLanguageMap;
use Modules\WriterManagement\App\Models\WriterPayment;

class MigrateWriterPayment extends Command
{
    protected $signature = 'migrate:writer-payments';
    protected $description = 'Migrate Kesen old writer payments to new Kesen writer payments.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Start time
        $startTime = microtime(true);

        // Fetch data from payment period table
        $oldPayments = DB::connection('source_db')->table('writer_payment_period')->orderBy('writer_id')->get();

        /** creating writer payments */
        foreach ($oldPayments as $data) {

            // Insert data into writer table
            $payment = new WriterPayment();
            $payment->sr_no = $data->id;
            $payment->writer_id = Writer::where('sr_no',$data->writer_id)->first()->id;
            $payment->payment_method = $data->payment_meta1;
            $payment->metrix = '';
            $payment->apply_gst = $data->gst == 'on'?? false;
            $payment->apply_tds = $data->tds == 'on'?? false;
            $payment->period_from = $data->start_date;
            $payment->period_to = $data->end_date;
            $payment->performance_charge = $data->performance_charges??null;
            $payment->deductible = $data->deductable??null;
            $payment->created_by = User::where('srno',$data->created_by)->first()->id;
            $payment->created_at = $data->created_date;
            $payment->total_amount = $data->grandtotal;
            $payment->save();
            $this->info("Payment of Writer id {$data->writer_id} is added.");
        }

        // End time
        $endTime = microtime(true);

        // Calculate the time taken
        $executionTime = $endTime - $startTime;

        $this->info('Migration of writer payments has been completed successfully in ' . round($executionTime, 2) . ' seconds.');
    }
}