<?php

namespace Modules\LanguageManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory,HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'languages';

    protected $gaurded=['id'];

    protected function getCreatedByAttribute($value){
        return User::where('id',$value)->first()->name;
    }
    
}
