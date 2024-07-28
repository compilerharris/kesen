<?php

namespace Modules\EstimateManagement\App\Models;

use App\Models\Metrix;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\Database\factories\EstimatesFactory;

class NoEstimates extends Model
{
   use HasFactory,HasUuids;

   protected $table="no_estimates";

   protected $guarded=['id'];


   public function client(){
      return $this->belongsTo(Client::class,'client_id');
   }

   public function client_person(){
      return $this->belongsTo(ContactPerson::class,'client_contact_person_id');
   }

   public function details(){
      return $this->hasMany(EstimatesDetails::class,'estimate_id');
   }

}
