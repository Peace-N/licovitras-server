<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;

use App\Country;
use App\Covid;
use Illuminate\Http\Request;

class IngestController extends Controller
{

    private const ENDPOINT = 'https://coronavirus-tracker-api.herokuapp.com/v2/';

    /** @var string */
    protected $endpoint = '';

    /** @var float */
    protected $timeout;

    /** @var string[] */
    protected $sources = [];

    public function __construct(string $endpoint = '', float $timeout = 20.0)
    {
        $this->endpoint = $endpoint ?: static::ENDPOINT;
        $this->timeout = $timeout;
    }

    public function getSources(): array
    {
        if ($this->sources === []) {
            $this->sources = $this->request('sources')['sources'] ?? [];
        }

        return $this->sources;
    }

    public function getLatest(string $source = ''): array
    {
        return $this->request('latest', $this->getQueryParameters(false, $source));
    }

    public function getAllLocations(bool $includeTimelines = false, string $source = ''): array
    {
        return $this->request('locations', $this->getQueryParameters($includeTimelines, $source));
    }

    public function findByCountryCode(string $countryCode, bool $includeTimelines = false, string $source = ''): array
    {
        return $this->request('locations', $this->getQueryParameters($includeTimelines, $source, $countryCode));
    }

    public function findByLocation(int $locationId, bool $includeTimelines = false, string $source = ''): array
    {
        return $this->request('locations/' . $locationId, $this->getQueryParameters($includeTimelines, $source));
    }

    protected function getQueryParameters(
        bool $includeTimelines = false,
        string $source = '',
        string $countryCode = ''
    ): array {
        $queryParameters['timelines'] = $includeTimelines;

        if ($source !== '' && \in_array($source, $this->getSources(), true)) {
            $queryParameters['source'] = $source;
        }

        if ($countryCode !== '') {
            $queryParameters['country_code'] = \strtoupper(\substr(\trim($countryCode), 0, 2));
        }

        return ['query' => $queryParameters];
    }

    protected function request(string $uri, array $options = []): array
    {
        $client = new Client([
            'base_uri' => $this->endpoint,
            'timeout' => $this->timeout,
        ]);

        try {
            $response = $client->request('GET', $uri, $options);
        } catch (ClientException $e) {
            return [];
        }

        if ($response->getStatusCode() !== 200) {
            return [];
        }

        return \json_decode($response->getBody()->getContents() ?? '', true) ?? [];
    }

    public function index()
    {

        $sa = [
//            "global" => $this->getLatest()["latest"],
//            "sa" => $this->findByCountryCode('ZA')["latest"],
            "regional" => Covid::first()
        ];

        return json_encode($sa);


//        try {
//            // get data
//            $countries = Country::has('covids')->with('covids')->get();
//            // array of data
//            $fuse = [];
//            foreach ($countries as $key => $val) {
//                $covid = $val->covids->last();
//                $fuse[] = [
//                    "country" => $val["country"],
//                    "flag" => $val["flag"],
//                    "date" => $covid["date"],
//                    "comfirmed" => $covid["comfirmed"],
//                    "deaths" => $covid["deaths"],
//                    "recovered" => $covid["recovered"],
//                ];
//            }
//
//            return json_encode($fuse);
//
//        } catch (\Exception $e) {
//
//
//        }
    }
}
