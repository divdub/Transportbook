<?php

namespace App\Http\Controllers\Api;
use App\Models\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $drivers = Driver::orderBy('driverid', 'desc')->get();
        return response()->json([ 'status' => true, 'message' => 'Driver list fetched successfully', 
        'data' => $drivers], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validator = Validator::make($request->all(), [
            'drivername'       => 'required|string|max:255',
            'mobile'           => 'required|string|max:20|unique:drivers,mobile',
       ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $driver = Driver::create([
            'drivername'      => $request->drivername,
            'mobile'          => $request->mobile,
            'opening_balance' => $request->opening_balance,
            'balance_type'    => $request->balance_type,
            'status'          => 1,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Driver created successfully',
        ], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $driver = Driver::find($id);
       if (!$driver) { return response()->json([ 'status' => false, 
       'message' => 'Driver not found' ], 404); } 
      return response()->json([ 'status' => true, 
      'message' => 'Driver fetched successfully', 'data' => $driver ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $driver = Driver::find($id); 
       if (!$driver) { 
        return response()->json([ 'status' => false, 'message' => 'Driver not found' ], 404); }
         $validator = Validator::make($request->all(), [ 'drivername' => 'required|string|max:255', 'mobile' => 'nullable|string|max:20']);
          if ($validator->fails()) { 
            return response()->json([ 'status' => false, 'message' => 'Validation failed', 'errors' => $validator->errors() ], 422); }
            
            $driver->update([ 'drivername' => $request->drivername, 'mobile' => $request->mobile, 'opening_balance' => $request->opening_balance ?? $driver->opening_balance, 
            'balance_type' => $request->balance_type ?? $driver->balance_type, 'status' => $request->status ?? $driver->status, ]); 
       return response()->json([ 'status' => true, 'message' => 'Driver updated successfully', 'data' => $driver->fresh() ], 200);
  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $driver = Driver::find($id); 
        if (!$driver) {
             return response()->json([ 'status' => false,
              'message' => 'Driver not found' ], 404); } 
        $driver->delete();
         return response()->json([ 'status' => true, 
         'message' => 'Driver deleted successfully' ], 200);
    }
}
