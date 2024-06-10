<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;
use Modules\LanguageManagement\App\Models\Language;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'plain_password',
        'phone_no',
        'landline',
        'address',
        'status',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function getPlainPasswordAttribute($value){
        return Crypt::decryptString($value);
    }

    public function setPlainPasswordAttribute($value){

        $this->attributes['plain_password'] = Crypt::encryptString($value);
    }

    public function getLanguageIdAttribute($value){
        return Language::where('id',$value)->first()->name;
    }
    
    protected function getCreatedByAttribute($value){
        return User::where('id',$value)->first()->name;
    }

    protected function getUpdatedByAttribute($value){
        return User::where('id',$value)->first()->name;
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
