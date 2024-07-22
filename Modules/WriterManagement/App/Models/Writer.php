<?php

namespace Modules\WriterManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\WriterManagement\Database\factories\WriterFactory;

class Writer extends Model
{
    use HasFactory,HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded=['id'];

    protected function getCreatedByAttribute($value){
        return User::where('id',$value)->first()->name;
    }

    public function writer_language_map(){
        return $this->hasMany(WriterLanguageMap::class);
    }
}
