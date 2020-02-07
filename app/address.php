<?php

namespace App;

class Address
{
    private $language;
    private $longitude;
    private $latitude;

    public function __construct($latitude, $longitude, $language)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->language = $language;
    }
    public function getAddress()
    {
        $key = config('app.google_key');
        $url="https://maps.googleapis.com/maps/api/geocode/json?latlng={$this->latitude},{$this->longitude}&key={$key}&language={$this->language}";
        // get the json response
        $resp_json = file_get_contents($url);

        // decode the json
        $res = json_decode($resp_json, true);
        $address_city = '';
        $address_street = '';
        $address_route =''; $address_number ='';

        if (isset($res['results'][0])) {


            foreach ($res['results'][0]['address_components'] as $addr) {
                switch ($addr['types'][0]) {
                    case 'street_number':
                        $address_number = $addr['long_name'];
                        break;
                    case 'route':
                        $address_route = $addr['long_name'];
                        break;
                    case 'locality' :
                        $address_city = $addr['long_name'];
                        break;
                }
            }
        }

        $address_street = "{$address_route}, {$address_number}";

        return array("address_street" => $address_street, "address_city" => $address_city);
    }
}
