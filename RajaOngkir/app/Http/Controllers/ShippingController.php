<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = 'https://api.rajaongkir.com/starter/city';
        $response  = $client->request('GET', $url, [
            'query' => [
                'key' => '8783cf4c3abaae16775b7c7cb3045eb3'
            ]
        ]);
        $data = json_decode($response->getBody()->getContents(), true);
        $results = $data;

        $cityNames = array_column($results, 'city_name');

        return response()->json($results);
    }

    public function cost(Request $request){

        // $validator = Validator::make($request->all(), [
        //     'destination' => 'required',
        //     'weight' =>  'required',
        //     'courier' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        $client = new Client();
        $url = 'https://api.rajaongkir.com/starter/cost';
        $apiKey = '8783cf4c3abaae16775b7c7cb3045eb3';

        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'key' => $apiKey,
            ],
            'form_params' => [
                'origin' => '151',
                'destination' => $request->city,
                'weight' =>  $request->weight,
                'courier' => $request->code,
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);
        
        return response()->json([
            $responseData
        ]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
