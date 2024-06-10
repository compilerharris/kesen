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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('job_card_srno')->autoIncrement();
            $table->string('t_writer_code')->nullable();
            $table->string('t_emp_code')->nullable();
            $table->string('t_two_way_emp_code')->nullable();
            $table->string('t_unit')->nullable();
            $table->string('t_pd')->nullable();
            $table->string('t_cr')->nullable();
            $table->string('t_cnc')->nullable();
            $table->string('t_dv')->nullable();
            $table->string('t_fqc')->nullable();
            $table->date('t_sentdate')->nullable();
            $table->string('bt_writer_code')->nullable();
            $table->string('bt_unit')->nullable();
            $table->string('bt_emp_code')->nullable();
            $table->string('bt_two_way_emp_code')->nullable();
            $table->string('bt_pd')->nullable();
            $table->string('bt_cr')->nullable();
            $table->string('bt_cnc')->nullable();
            $table->string('bt_dv')->nullable();
            $table->string('bt_fqc')->nullable();
            $table->date('bt_sentdate')->nullable();
            $table->string('job_no')->nullable();
            $table->uuid('estimate_detail_id')->nullable();
            $table->string('sync_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_cards');
    }
};
