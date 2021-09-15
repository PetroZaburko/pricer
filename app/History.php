<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class History extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function historyAdverts()
    {
        return$this->hasMany(AdvertsHistory::class);
    }

    public function category()
    {
        return$this->belongsTo(Category::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }


    public static function add($fields)
    {
        $history = new static;
        $history->fill($fields);
        $history->user_id = Auth::id();
        $history->company_id = Auth::user()->company_id;
        $history->save();
        return $history;
    }

    public function getFormattedAction()
    {
        return ($this->asc_desc==0 ? '+' : '-' ).$this->value.($this->perc_rate==0 ? ' %' : ' грн.');
    }



}
