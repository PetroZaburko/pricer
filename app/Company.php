<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method category find($id)
 */

class Company extends Model
{
    use Encryptable;

    protected $guarded = ['status'];

    protected $encryptable = ['api_key', 'api_password'] ;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function adverts() {
        return $this->hasMany(Adverts::class);
    }

    public function adverts_history() {
        return $this->hasMany(AdvertsHistory::class);
    }

    public function categories() {
        return $this->hasMany(Category::class);
    }

    public function histories() {
        return $this->hasMany(History::class);
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

    public function getCompanyStatus()
    {
        return ($this->status) ? 'active' : 'not active';
    }
}
