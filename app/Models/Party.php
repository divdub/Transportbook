<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $primaryKey = 'partyid';
  protected $fillable = [
    'partyname',
    'mobile',
    'companyname',
    'gstno',
    'panno',
    'addressline1',
    'addressline2',
    'stateid',
    'pincode',
    'opening_balance',
    'status',
];
}
