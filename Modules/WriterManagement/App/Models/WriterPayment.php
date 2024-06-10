<?php

namespace Modules\WriterManagement\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\WriterManagement\Database\factories\WriterPaymentFactory;

class WriterPayment extends Model
{
    use HasFactory,HasUuids;

    /**
     * The attributes that are mass assignable.
     */
   protected $guarded=['id'];

   protected $table="writer_payments";

}
