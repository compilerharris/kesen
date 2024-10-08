<?php

namespace Modules\ClientManagement\App\Models;

use App\Models\Metrix;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ClientManagement\Database\factories\ClientFactory;

class Client extends Model
{
    use HasFactory,HasUuids,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $gaurded = ['id','sr_no'];
    public function client_metric(){
        return $this->belongsTo(Metrix::class,'metrix','id');
    }

    public function client_accountant(){
        return $this->belongsTo(User::class,'client_accountant_person_id','id');
    }

    public function contact_person(){
        return $this->hasMany(ContactPerson::class,'client_id','id');
    }

    public function ratecards(){
        return $this->hasMany(Ratecard::class,'client_id','id');
    }
   
}
