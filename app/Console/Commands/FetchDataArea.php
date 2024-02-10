<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Province;
use App\Models\City;

use App\Services\RajaOngkirService;

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
    protected $RajaOngkirService;

    /**
     * Execute the console command.
     */

    public function __construct(RajaOngkirService $RajaOngkirService)
    {
        parent::__construct();
        $this->RajaOngkirService = $RajaOngkirService;
    }

    public function handle()
    {
        try {
            $provinces = $this->RajaOngkirService->getProvince();
            $provinces = array_map(function ($item) {
                $item['created_at'] = now();
                $item['updated_at'] = now();

                return $item;
            }, $provinces);
            Province::createProvincesWithTransaction($provinces);

            $cities = $this->RajaOngkirService->getCity();
            $cities = array_map(function ($item) {
                $item['created_at'] = now();
                $item['updated_at'] = now();

                return $item;
            }, $cities);
            City::createCitiesWithTransaction($cities);

            $this->info('Berhasil mengimport data dari rajaongkir');
        } catch (\Exception $e) {
            $this->error('Gagal mengimport data dari rajaongkir dengan error: ' . $e);
        }
    }
}
