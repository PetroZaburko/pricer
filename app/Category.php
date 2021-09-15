<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @method category find($id)
 */

class Category extends Model
{


    protected $fillable = ['title', 'company_id'];

    public function advert()
    {
        return $this->hasMany(Adverts::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function getLatestHistory($count)
    {
        $histories=[];
        foreach ($this->history()->orderBy('id', 'desc')->take($count)->get() as $history){
            $histories[]= $history->created_at->format('d-m-Y h:m:s').' '.$history->getFormattedAction();
        }
        return $histories;
    }
}
