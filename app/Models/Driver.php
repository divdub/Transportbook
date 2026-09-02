<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
  protected $primaryKey = 'driverid';
  protected $fillable = [
    'drivername',
    'mobile',
    'opening_balance',
    'balance_type',
];
}
