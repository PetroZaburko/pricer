<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adverts extends Model
{
    protected $fillable = ['category_id', 'advert_id', 'company_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function addRelation($fields)
    {
        $adverts= new static;
        $adverts->fill($fields);
        $adverts->save();
        return $adverts;
    }
}
