<?php

namespace App\Http\Controllers;

use App\Country;
use App\Covid;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Psy\Util\Json;

class DataServiceWorker extends Controller
{
    public function runworker() {

        try {
            set_time_limit(0);
            $client = new Client();
            $res = $client->request('GET', 'https://pomber.github.io/covid19/timeseries.json');
            $data = $res->getBody();
            $stream = $data->getContents();
            $stream = json_decode($stream, true);
//            dd($stream);

            Covid::truncate();

            foreach ($stream as $key => $val) {
                foreach ( $val as $insert) {
                    $model = new Covid();
                    $model->country_id = Country::where('country', $key)->first()->id;
                    $model->date = $insert["date"];
                    $model->comfirmed = $insert["confirmed"];
                    $model->deaths = $insert["deaths"];
                    $model->recovered = $insert["recovered"];
                    $model->save();
                }
            }

            echo "done working records db";

        } catch(ClientException $e) {
            dd($e->getMessage());
        }

    }
}
