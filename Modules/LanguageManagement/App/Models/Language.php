<?php

namespace Modules\LanguageManagement\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Language extends Model
{
    use HasFactory,HasUuids;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('created_at', function (Builder $builder) {
            $builder->orderBy('created_at');
        });
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'languages';

    protected $gaurded=['id'];

    protected function getCreatedByAttribute($value){
        return User::where('id',$value)->first()->name;
    }
    
}
