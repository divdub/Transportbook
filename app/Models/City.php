<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'cityid';

    public $timestamps = false;

    protected $fillable = [
        'stateid',
        'cityname',
        'status',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'stateid', 'stateid');
    }
}
