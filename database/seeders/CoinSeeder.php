<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Download updated coins json file and saves it on /database/data/coins.json
        $this->downloadUpdatedJson();

        Coin::truncate();
        $json = File::get("database/data/coins.json");
        $coins = json_decode($json);
        foreach ($coins as $key => $value) {
            Coin::create([
                "name" => $value->name,
                "symbol" => $value->symbol,
                "image" => $value->image,
                "current_price" => $value->current_price,
                "market_cap" => $value->market_cap
            ]);
        }
    }

    public function downloadUpdatedJson()
    {
        $url = Config::get('crypto.coin_list_api');
        $fileName = 'coins.json';
        $pathToFile = database_path('data/' . $fileName);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        file_put_contents($pathToFile, $resp);

    }
}
