<?php

namespace App\Http\Controllers;

use App\Models\Province;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\RajaOngkirService;

class ProvinceController extends Controller
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
                $provinces = Province::select('province_id', 'province')->get();
                return response()->json($provinces);
            }

            $province = Province::select('province_id', 'province')->where('province_id', $id)->first();

            if ($province) {
                return response()->json($province);
            } else {
                return response()->json(['message' => 'Province not found'], 404);
            }
        } else if ($sourceImplementation == 'rajaongkir') {
            $data = $this->RajaOngkirService->getProvince($id);
            if (count($data) < 1) {
                return response()->json([
                    'message' => 'Province not found'
                ], 404);
            }

            return $data;
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
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        //
    }
}
