<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * @method user find($id)
 */


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company_id'
    ];

    protected $guarded = ['is_admin'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function toggleStatus($status)
    {
        if($status == null){
            $this->status = 0;
            return $this->save();
        }
        else {
            $this->status = 1;
            return $this->save();
        }
    }

    public function changePermissions($permissions)
    {
        if ($permissions == null){
            $this->is_admin = 0;
            return$this->save();
        }
        else {
            $this->is_admin = 1;
            return $this->save();
        }

    }

    public function getUserStatus()
    {
        return ($this->status) ? 'active' : 'not active';
    }

    public function isUserAdmin()
    {
        return ($this->is_admin) ? 'Admin' : 'User';
    }
}
