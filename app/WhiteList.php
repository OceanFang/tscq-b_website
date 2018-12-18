<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WhiteList extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\CompanyData', 'company_id', 'id');
    }
}
