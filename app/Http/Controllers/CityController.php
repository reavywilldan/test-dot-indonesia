<?php

namespace App\Http\Controllers;

use App\Models\City;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\RajaOngkirService;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $RajaOngkirService;

    public function __construct(RajaOngkirService $RajaOngkirService)
    {
        $this->RajaOngkirService = $RajaOngkirService;
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $id = $request->query('id');
        $sourceImplementation = env('SOURCE_IMPLEMENTATION', 'db');

        if ($sourceImplementation == 'db') {
            if ($id === null) {
                $cities = City::select('city_id', 'province_id', 'province', 'type', 'city_name', 'postal_code')->get();
                return response()->json($cities);
            }

            $city = City::select('city_id', 'province_id', 'province', 'type', 'city_name', 'postal_code')->first();

            if ($city) {
                return response()->json($city);
            } else {
                return response()->json(['message' => 'City not found'], 404);
            }
        } else if ($sourceImplementation == 'rajaongkir') {
            return $this->RajaOngkirService->getCity($id);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
