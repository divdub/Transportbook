<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table = 'trips';

    protected $primaryKey = 'tripid';

    protected $fillable = [
        'tripdate',
        'tripno',
        'truckid',
        'partyid',
        'supplierid',
        'driverid',
        'originid',
        'destinationid',
        'partybillingtype',
        'rate',
        'wt',
        'freightamt',
        'supplierbillingtype',
        'sup_freightamt',
        'sup_rate',
        'supwt',
        'material',
        'remark',
    ];
}

