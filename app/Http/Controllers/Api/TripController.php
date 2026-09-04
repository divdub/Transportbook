<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    /**
     * Display a listing of trips.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $trips = Trip::where('companyid',$user->companyid)->orderBy('tripid', 'desc')->get();
          $totalfreightamt = $trips->sum('freightamt');
          $totalAdd = Chargeentry::where('companyid',$user->companyid)
            ->where('billadjustment', 'add')
            ->sum('amount');
         $totalReduce = Chargeentry::where('companyid',$user->companyid)
            ->where('billadjustment', 'reduce')
            ->sum('amount');
            $totaladvance = Advanceentry::where('companyid',$user->companyid)
            ->sum('amount');
             $totalpayment = Trippayment::where('companyid',$user->companyid)
            ->sum('amount');
            $partybal=$totalfreightamt -  $totaladvance + $totalAdd - $totalReduce -$totalpayment;
        return response()->json([
            'status'  => true,
            'message' => 'Trip list fetched successfully',
            'data'    => $trips,
              'partybal' => number_format($partybal, 2, '.', ''),
        ], 200);
    }


    /**
     * Store a newly created trip.
     */
    public function store(Request $request)
    {
        
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'tripdate'            => 'nullable|date',
            'truckid'             => 'nullable|integer',
            'partyid'             => 'nullable|integer',
            'supplierid'          => 'nullable|integer',
            'driverid'            => 'nullable|integer',
            'originid'            => 'nullable|integer',
            'destinationid'       => 'nullable|integer',
             'partybillingtype'    => 'nullable|string|max:255',

            'rate'                => 'nullable|numeric',
            'wt'                  => 'nullable|numeric',
            'freightamt'          => 'nullable|numeric',

            'supplierbillingtype' => 'nullable|string|max:255',

            'sup_freightamt'      => 'nullable|numeric',
            'sup_rate'            => 'nullable|numeric',
            'supwt'               => 'nullable|numeric',

            'material'            => 'nullable|string|max:255',
            'remark'              => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }


        $lastTrip = Trip::where('companyid',$user->companyid)->orderBy('tripid', 'desc')->first();

        if ($lastTrip) {
            $lastNumber = (int) substr($lastTrip->tripno, 4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $tripno = 'TRIP' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);


        $trip = Trip::create([
            'tripdate'            => $request->tripdate,
            'tripno'              => $tripno,

            'truckid'             => $request->truckid,
            'partyid'             => $request->partyid,
            'supplierid'          => $request->supplierid,
            'driverid'            => $request->driverid,

            'originid'            => $request->originid,
            'destinationid'       => $request->destinationid,

            'partybillingtype'    => $request->partybillingtype,

            'rate'                => $request->rate ?? 0,
            'wt'                  => $request->wt ?? 0,
            'freightamt'          => $request->freightamt ?? 0,

            'supplierbillingtype' => $request->supplierbillingtype,

            'sup_freightamt'      => $request->sup_freightamt ?? 0,
            'sup_rate'            => $request->sup_rate ?? 0,
            'supwt'               => $request->supwt ?? 0,

            'material'            => $request->material,
            'remark'              => $request->remark,
            'tripstatus'          => 'Started' ,
             'companyid' => $user->companyid,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Trip created successfully',
            'data'    => $trip
        ], 201);
    }


    /**
     * Display the specified trip.
     */
    public function show($id)
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'status'  => false,
                'message' => 'Trip not found'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Trip fetched successfully',
            'data'    => $trip
        ], 200);
    }


    /**
     * Update the specified trip.
     */
    public function update(Request $request, $id)
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'status'  => false,
                'message' => 'Trip not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'tripdate'            => 'nullable|date',
            'truckid'             => 'nullable|integer',
            'partyid'             => 'nullable|integer',
            'supplierid'          => 'nullable|integer',
            'driverid'            => 'nullable|integer',
            'originid'            => 'nullable|integer',
            'destinationid'       => 'nullable|integer',
            'partybillingtype'    => 'nullable|string|max:255',
            'rate'                => 'nullable|numeric',
            'wt'                  => 'nullable|numeric',
            'freightamt'          => 'nullable|numeric',
            'supplierbillingtype' => 'nullable|string|max:255',
            'sup_freightamt'      => 'nullable|numeric',
            'sup_rate'            => 'nullable|numeric',
            'supwt'               => 'nullable|numeric',
            'material'            => 'nullable|string|max:255',
            'remark'              => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        /*
         * Trip number is NOT changed during update.
         */

        $trip->update([
            'tripdate'            => $request->tripdate,
            'truckid'             => $request->truckid,
            'partyid'             => $request->partyid,
            'supplierid'          => $request->supplierid,
            'driverid'            => $request->driverid,
            'originid'            => $request->originid,
            'destinationid'       => $request->destinationid,

            'partybillingtype'    => $request->partybillingtype,

            'rate'                => $request->rate ?? 0,
            'wt'                  => $request->wt ?? 0,
            'freightamt'          => $request->freightamt ?? 0,
         'supplierbillingtype' => $request->supplierbillingtype,

            'sup_freightamt'      => $request->sup_freightamt ?? 0,
            'sup_rate'            => $request->sup_rate ?? 0,
            'supwt'               => $request->supwt ?? 0,

            'material'            => $request->material,
            'remark'              => $request->remark,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Trip updated successfully',
            'data'    => $trip->fresh()
        ], 200);
    }


    /**
     * Remove the specified trip.
     */
    public function destroy($id)
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'status'  => false,
                'message' => 'Trip not found'
            ], 404);
        }

        $trip->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Trip deleted successfully'
        ], 200);
    }
    
    public function updateStatus(Request $request,$tripid)
{
    
    $trip = Trip::find($tripid);

    if (!$trip) {
        return response()->json([
            'status'  => false,
            'message' => 'Trip not found'
        ], 404);
    }

    // Update only status
    $trip->tripstatus = $request->tripstatus;
    $trip->save();

    return response()->json([
        'status'  => true,
        'message' => 'Trip status updated successfully',
        'data'    => $trip
    ], 200);
}
}
?>
