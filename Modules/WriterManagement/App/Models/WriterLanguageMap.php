<?php

namespace Modules\WriterManagement\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LanguageManagement\App\Models\Language;
use Modules\WriterManagement\Database\factories\WriterLanguageMapFactory;

class WriterLanguageMap extends Model
{
    use HasFactory,HasUuids;

    
    protected $guarded=['id'];

    protected function getLanguageIdAttribute($value){
        return Language::where('id',$value)->first()->name;
    }

}
