<?php

namespace Modules\JobRegisterManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ClientManagement\App\Models\Client;
use Modules\ClientManagement\App\Models\ContactPerson;
use Modules\EstimateManagement\App\Models\Estimates;
use Modules\EstimateManagement\App\Models\EstimatesDetails;
use Modules\EstimateManagement\App\Models\NoEstimates;
use Modules\JobCardManagement\App\Models\JobCard;
use Modules\JobRegisterManagement\Database\factories\JobRegisterFactory;

class JobRegister extends Model
{
    use HasFactory,HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    protected $table='job_register';

    public function estimate(){
        return $this->belongsTo(Estimates::class,'estimate_id');
    }

    public function no_estimate(){
        return $this->belongsTo(NoEstimates::class,'estimate_id');
    }

    public function estimate_details(){
        return $this->hasMany(EstimatesDetails::class,'document_name', 'estimate_document_id');
    }
    public function estimateDetail()
    {
        return $this->hasOne(EstimatesDetails::class, 'document_name', 'estimate_document_id');
    }

    public function jobCard()
    {
        return $this->hasMany(JobCard::class, 'job_no','sr_no')->orderBy('estimate_detail_id', 'desc');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function handle_by(){
        return $this->belongsTo(User::class,'handled_by_id');
    }

    public function accountant(){
        return $this->belongsTo(User::class,'client_accountant_person_id');
    }

    public function setLanguageIdAttribute($value){
        $this->attributes['language_id'] = json_encode($value);
    }
    
    // Accessor for getting language_id
    public function getLanguageIdAttribute($value){
        return json_decode($value, true) ?? [];
    }

    public function client_person(){
        return $this->belongsTo(ContactPerson::class,'client_contact_person_id');
     }

    public function informedTo(){
        return $this->belongsTo(ContactPerson::class,'informed_to');
    }
}
