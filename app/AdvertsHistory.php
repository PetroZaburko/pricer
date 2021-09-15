<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdvertsHistory extends Model
{
//    protected $fillable = [
//        'history_id',
//        'advert_name',
//        'old_value',
//        'new_value'
//    ];

    protected $guarded = [];

    public function company() {
        return $this->belongsTo(Company::class);
    }


    public static function add($fields)
    {
        $advertHistory = new static;
        $advertHistory->fill($fields);
        $advertHistory->company_id = Auth::user()->company_id;
        $advertHistory->save();
        return $advertHistory;
    }
}
