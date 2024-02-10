<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class FetchDataArea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-data-area';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To import area data from Rajaongkir to DB';

    /**
     * Execute the console command.
     */

    public function getProvince()
    {
        try {
            $url = env('API_URL_RAJAONGKIR') . 'province';
            $key = env('API_KEY_RAJAONGKIR');

            $response = Http::withHeaders([
                'key' => $key
            ])->get($url);

            $data = $response->json();
            $data = $data['rajaongkir']['results'] ?? [];

            return $data;
        } catch (RequestException $e) {
            report($e);
            return response()->json(['error' => 'Error fetching data from the API'], 500);
        }
    }

    public function getCity()
    {
        try {
            $url = env('API_URL_RAJAONGKIR') . 'city';
            $key = env('API_KEY_RAJAONGKIR');

            $response = Http::withHeaders([
                'key' => $key
            ])->get($url);

            $data = $response->json();
            $data = $data['rajaongkir']['results'] ?? [];

            return $data;
        } catch (RequestException $e) {
            report($e);
            return response()->json(['error' => 'Error fetching data from the API'], 500);
        }
    }

    public function handle()
    {
        $check = $this->getCity();
        dd($check);
    }
}
