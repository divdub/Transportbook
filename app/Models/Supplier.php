<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplierid';
    protected $fillable = [
        'suppliername',
        'mobile',
        'email',
        'address',
        'stateid',
        'cityid',
        'gstno',
        'panno',
        'contactperson',
        'status',
    ];
}
