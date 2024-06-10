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
        Schema::create('writers', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->integer('sr_no')->autoIncrement();
            $table->string('writer_name')->nullable();
            $table->string('email')->unique();
            $table->text('address');
            $table->string('code')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('landline')->nullable();
            $table->boolean('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('writers');
    }
};
