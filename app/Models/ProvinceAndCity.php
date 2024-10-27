<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinceAndCity extends Model
{
    protected $table = 'provinces_and_cities';
    protected $fillable = [
        'province_name', 
        'city_name', 
    ];

    public function registerForms()
    {
        return $this->hasMany(RegisterForm::class, 'provinces_and_cities_id');
    }
}
