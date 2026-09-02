<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
     protected $primaryKey = 'truckid';
     protected $fillable = [ 'trucknumber', 'trucktype', 'ownership', 'supplierid', 'status', ];
}
