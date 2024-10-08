<?php

namespace Modules\WriterManagement\App\Models;

use App\Models\Metrix;
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

  public function writer(){
      return $this->belongsTo(Writer::class,'writer_id','id');
  }
  public function payment_metric(){
    return $this->belongsTo(Metrix::class,'metrix','id');
  }
}
