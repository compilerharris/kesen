<?php

namespace Modules\ClientManagement\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ClientManagement\Database\factories\ContactPersonFactory;

class ContactPerson extends Model
{
    use HasFactory,HasUuids,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    protected $table='contact_persons';
    
    
}
