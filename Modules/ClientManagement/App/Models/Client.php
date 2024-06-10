<?php

namespace Modules\ClientManagement\App\Models;

use App\Models\Metrix;
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
   
}
