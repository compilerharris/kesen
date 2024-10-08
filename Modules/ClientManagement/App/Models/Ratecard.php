<?php

namespace Modules\ClientManagement\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ClientManagement\Database\factories\RatecardFactory;
use Modules\LanguageManagement\App\Models\Language;

class Ratecard extends Model
{
    use HasFactory,HasUuids,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];
    protected $table='ratecards';

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'id');
    }
    
}
