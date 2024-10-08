<?php

namespace Modules\EstimateManagement\App\Models;

use App\Models\Metrix;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\Database\factories\EstimatesFactory;

class Estimates extends Model
{
   use HasFactory,HasUuids;

   protected $table="estimates";

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
   public function metrics(){   
      return $this->belongsTo(Metrix::class,'metrix','id');
   }
   public function employee(){   
      return $this->belongsTo(User::class,'created_by');
   }
   

}
