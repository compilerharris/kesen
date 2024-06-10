<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('job_register', function (Blueprint $table) {
            $table->string('estimate_document_id');
            $table->string('bill_date');  
            $table->string('bill_no');  
            $table->string('informed_to');   
            $table->string('invoice_date');  
            $table->string('sent_date');  
            $table->string('delivery_date');  
            $table->string('site_specific');  
            $table->string('site_specific_path');
            $table->string('old_job_no');
            $table->string('po_number');
            $table->string('payment_status');
            $table->string('payment_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_register', function (Blueprint $table) {
            $table->dropColumn('estimate_document_id');   
        });
    }
};
