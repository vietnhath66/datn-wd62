<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'name_en', 'full_name', 'full_name_en', 'code_name', 'administrative_unit_id', 'administrative_region_id',
    ];

    protected $table = 'provinces';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function districts(){
        return $this->hasMany(District::class, 'province_code', 'code');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'province_code', 'code');
    }
}
