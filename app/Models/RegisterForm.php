<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterForm extends Model
{
    protected $table = 'register_forms';

    protected $fillable = [
        'user_id',
        'full_name',
        'ktp_address',
        'current_address',
        'kecamatan',
        'provinces_and_cities_id',
        'telephone_number',
        'phone_number',
        'email',
        'citizenship',
        'citizen_origin',
        'birth_date',
        'birth_place',
        'birth_provinces',
        'birth_cities',
        'gender',
        'marriage_status',
        'religion',
    ];

    public function provinceAndCity()
    {
        return $this->belongsTo(ProvinceAndCity::class, 'provinces_and_cities_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}