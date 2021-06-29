<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // relationship in models one to one
    public function profile() {
        return $this->hasOne('App\Models\Profile');
    }

    // User and Course have two relationships
    // Relashionship one to many
    public function courses_dictated() {
        return $this->hasMany('App\Models\Course'); // this method retrieves the listed courses
    }

    public function comments() {
        return $this->hasMany('App\Models\Comments'); 
    }

    public function reactions() {
        return $this->hasMany('App\Models\Reaction');
    }


    // Relationship to review one to many
    public function reviews(){
        return $this->hasMany('App\Models\Review');
    }


    // Relashionship many to many
    public function courses_enrolled() {
        return $this->belongsToMany('App\Models\Course');
    }

    public function lessons(){
        return $this->belongsToMany('App\Models\Lesson');
    }
    

}
