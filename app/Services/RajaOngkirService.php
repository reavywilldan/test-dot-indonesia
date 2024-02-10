<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class RajaOngkirService
{
    protected $httpClient;
    protected $baseUrl;
    protected $apiKey;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = env('API_URL_RAJAONGKIR', 'https://api.rajaongkir.com/starter/');
        $this->apiKey = env('API_KEY_RAJAONGKIR', '0df6d5bf733214af6c6644eb8717c92c');
    }

    public function getProvince($id = null)
    {
        try {
            $url = $this->baseUrl . 'province';
            $queryParams = [];

            if ($id) {
                $queryParams['id'] = $id;
            }

            if (count($queryParams) > 0) {
                $params = http_build_query($queryParams);
                $url = $url . '?' . $params;
            }

            $response = $this->httpClient::withHeaders([
                'key' => $this->apiKey
            ])->get($url);

            $data = $response->json();
            $data = $data['rajaongkir']['results'] ?? [];

            return $data;
        } catch (RequestException $e) {
            report($e);
            return response()->json(['error' => 'Error fetching data from the API'], 500);
        }
    }

    public function getCity($id = null, $province = null)
    {
        try {
            $url = $this->baseUrl . 'city';
            $queryParams = [];

            if ($id) {
                $queryParams['id'] = $id;
            }

            if ($province) {
                $queryParams['province'] = $province;
            }

            if (count($queryParams) > 0) {
                $params = http_build_query($queryParams);
                $url = $url . '?' . $params;
            }

            $response = $this->httpClient::withHeaders([
                'key' => $this->apiKey
            ])->get($url);

            $data = $response->json();
            $data = $data['rajaongkir']['results'] ?? [];

            return $data;
        } catch (RequestException $e) {
            report($e);
            return response()->json(['error' => 'Error fetching data from the API'], 500);
        }
    }
}
