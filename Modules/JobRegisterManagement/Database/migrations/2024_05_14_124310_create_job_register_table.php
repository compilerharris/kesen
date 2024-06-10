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
        Schema::create('job_register', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('sr_no')->autoIncrement();
            $table->string('metrix');
            $table->string('estimate_id');
            $table->string('client_id');
            $table->string('client_contact_person_id')->nullable();
            $table->string('client_accountant_person_id')->nullable();
            $table->string('handled_by_id');
            $table->string('created_by_id');
            $table->text('other_details');
            $table->integer('category');
            $table->string('type');
            $table->string('protocol_data')->nullable();
            $table->string('language_id');
            $table->date('date')->default(now());
            $table->text('description')->nullable();
            $table->string('protocol_no')->nullable();
            $table->integer('status')->default(0);
            $table->string('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('');
    }
};
