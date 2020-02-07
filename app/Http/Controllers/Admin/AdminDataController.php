<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use App\Institution;
use App\Contact;
use App\Outlet;
use App\User;
use SoapBox\Formatter\Formatter;
use Spatie\ArrayToXml\ArrayToXml;

use \Carbon\Carbon;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminDataController extends Controller
{
    protected $address_street, $address_city;
    public function import()
    {

        $exists = Storage::disk('public')->exists('institution.xml');
        if ($exists) {
            $content = Storage::disk('public')->get('institution.xml');
            $formatter = Formatter::make($content, Formatter::XML);
            $export = $formatter->toArray();
            $arr = array();
            $institutions = $export['institution'];
            //dd($institutions);
            foreach ($institutions as $inst_key=>$inst) {
                if (is_array($inst['inst_realm']))
                {
                    foreach ($inst['inst_realm'] as $key => $i_r)
                    {
                        //echo ($key."--".$i_r."<br>");
                    }
                } else {
                    //echo($inst['inst_realm']."<br>");
                }
                if (isset($inst['location'][0]))
                {
                    $lat = strval(round((float)$inst['location'][0]['latitude'], 6));
                    $lon = strval(round((float)$inst['location'][0]['longitude'], 6));
                }
                elseif (isset($inst['location']))
                {
                    $lat = strval(round((float)$inst['location']['latitude'], 6));
                    $lon = strval(round((float)$inst['location']['longitude'], 6));
                }
                else
                {
                    $lat=0; $lon=0;
                }

                $this->address($lat, $lon, 'en');
                //var_dump ($this->>address_city, $this->address_street);
                /*Создаем юзера для института*/
                $name=$inst_key;
                $email = '';
                if (isset($inst['contact'][0]))
                {
                    $name = $inst['contact'][0]['name'];
                    $email = $inst['contact'][0]['email'];
                }
                elseif (isset($inst['contact']))
                {
                    $name = $inst['contact']['name'];
                    $email = $inst['contact']['email'];
                }
                if (!(User::where('email', $email)->exists()))
                {
                    $user = new User();
                    $user->password = Hash::make('123456');
                    $user->email = $email;
                    $user->name = $name;
                    $user->save();

                    /*Создаем институт*/

                    $institution = new Institution();
                    $institution->longitude = $lon;
                    $institution->latitude = $lat;
                    $institution->creator_id = $user->id;
                    $institution->inst_name_id = $user->id;
                    $institution->address_street = $this->address_street;
                    $institution->address_city = $this->address_city;
                    $institution->inst_type = 'IdP+SP';
                    $institution->venue_type = '3,3';
                    $institution->inst_stage = 1;
                    $pattern = '/^(?:[a-zA-Z0-9_*]+\.)*([a-zA-Z0-9_*-]+)(?:\.\w+)$/';
                    if (is_array($inst['inst_realm'])) {
                        preg_match($pattern, $inst['inst_realm'][0], $matches);
                    } else {
                        preg_match($pattern, $inst['inst_realm'], $matches);
                    }

                    $institution->inst_id = $matches[1];
                    if (isset($inst['info_URL'])) {
                        if (is_array($inst['info_URL'])) {
                            if (is_array($inst['info_URL'][0])) {
                                $institution->info_URL_en = $inst['info_URL'][1];
                            } else {
                                $institution->info_URL_en = $inst['info_URL'][0];
                                $institution->info_URL_ru = $inst['info_URL'][1];
                            }
                        } else {
                            $institution->info_URL_en = $inst['info_URL'];
                        }

                    }
                    if (isset($inst['policy_URL'])) {
                        if (is_array($inst['policy_URL'])) {
                            if (is_array($inst['policy_URL'][0])) {
                                $institution->policy_URL_en = $inst['policy_URL'][1];
                            } else {
                                $institution->policy_URL_en = $inst['policy_URL'][0];
                                $institution->policy_URL_ru = $inst['policy_URL'][1];
                            }
                        } else {
                            $institution->policy_URL_en = $inst['policy_URL'];
                        }

                    }


                    $institution->save();
                    /*Реалмы*/
                    if (is_array($inst['inst_realm'])) {
                        foreach ($inst['inst_realm'] as $realm)
                            DB::table('realms')->insert(['realm' => $realm, 'inst_id' => $institution->id]);
                    } else {
                        DB::table('realms')->insert(['realm' => $inst['inst_realm'], 'inst_id' => $institution->id]);
                    }

                    /*Контакты */
                    if (isset($inst['contact'][0]) && is_array($inst['contact'][0])) {
                        foreach ($inst['contact'] as $cont_info) {

                            $contact = new Contact();
                            $contact->name = $cont_info['name'];
                            $contact->email = $cont_info['email'];
                            $contact->phone = is_array($cont_info['phone'])? '':$cont_info['phone'];
                            $contact->creator_id = $user->id;
                            $contact->save();

                        }
                    } elseif (isset($inst['contact'])) {
                        var_dump($inst['contact']);
                        $contact= new Contact();
                        $contact->name = $inst['contact']['name'] ;
                        $contact->email = $inst['contact']['email'] ;
                        $contact->phone = is_array($inst['contact']['phone'])? '': $inst['contact']['phone'];
                        $contact->creator_id = $user->id;
                        $contact->save();
                    }
                    /*Созадем локации*/
                    if (isset($inst['location'])) {
                        $locations = $inst['location'];
                        if (isset($locations[0])) {
                            foreach ($locations as $key=>$location) {
                                $loc = new Outlet();
                                $pref = $key>8? strval($key+1): "0".strval($key+1);
                                $loc->name = "{$institution->inst_id}-{$pref}";
                                $loc->location_id = "{$institution->inst_id}-{$pref}";
                                $loc->latitude = strval(round((float)$location['latitude'], 6));
                                 $loc->longitude = strval(round((float)$location['longitude'], 6));
                                $this->address($loc->latitude, $loc->longitude, 'en');
                                $loc->address_street = $this->address_street;
                                $loc->address_city = $this->address_city;
                                $loc->AP_no = $location['AP_no'] ?? 1;
                                $loc->info_URL=$institution->info_URL_en;

                                $loc->creator_id = $user->id;

                                $loc->save();

                            }

                        }
                        else {
                            $location=$locations;
                            $loc = new Outlet();
                            $loc->name = "{$institution->inst_id}-01";
                            $loc->location_id = "{$institution->inst_id}-01";
                            $loc->latitude = strval(round((float)$location['latitude'], 6));
                            $loc->longitude = strval(round((float)$location['longitude'], 6));
                            $this->address($loc->latitude, $loc->longitude, 'en');
                            $loc->address_street = $this->address_street;
                            $loc->address_city = $this->address_city;
                            $loc->AP_no = $location['AP_no'] ?? 1;
                            $loc->info_URL=$institution->info_URL_en;

                            $loc->creator_id = $user->id;
                            $loc->save();
                        }
                    }
                    $contacts = Contact::where('creator_id', $user->id)->get();
                    $locations = Outlet::where('creator_id', $user->id)->get();
                    foreach ($contacts as $contact){
                        DB::table('cont2insts')->insert(['cont_id' => $contact->id, 'inst_id' => $institution->id]);
                        foreach ($locations as $location){
                            DB::table('cont2locs')->insert(['cont_id' => $contact->id, 'loc_id' => $location->id]);
                        }
                    }

                } /*Конец блока провеки юзера*/
            /*Конец блока для каждого института*/
            }
        }
    }
    public function export(){

        $last_outlet = DB::table('outlets')
            ->orderBy('updated_at', 'desc')
            ->first();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://eduroam.ru/general/institution.xml");
// SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_FILETIME, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $output = curl_exec($ch);

        if ($output === false) {
            $timestamp = 0;
        }
        else {
            $timestamp = curl_getinfo($ch, CURLINFO_FILETIME);

        }

        curl_close($ch);
        if ($timestamp > strtotime($last_outlet->updated_at)) {
            echo $timestamp."<br>";
            echo $last_outlet->updated_at;
            echo "NULL";
            return;
        }





        $institutions = Institution::all();
        foreach ($institutions as $institution){
            $institution_xml =  array('instid' => $institution->inst_id);
            $institution_xml['ROid'] =  config('data.ROid');
            $institution_xml['type'] = $institution->inst_type;
            $institution_xml['stage'] = $institution->inst_stage;
            if ($institution_xml['type'] == 'IdP' or $institution_xml['type'] == 'IdP+SP'){
                $realms = DB::table('realms')
                    ->where('inst_id', '=', $institution->id)
                    ->get();
                  foreach ($realms as $key=>$realm){
                           $institution_xml['inst_realm'][]= $realm->realm;
                  }
            }

            $instname = DB::table('instnames')
                ->find($institution->inst_name_id);

            $institution_xml['inst_name'][]=['_attributes' => ['lang' => 'en'],'fake'=>$instname->name_en];

            if (isset($instname->name_en)) {
                $institution_xml['inst_name'][]=['_attributes' => ['lang' => 'ru'],'fake'=>$instname->name_ru];
            }

            $institution_xml['address']['street']  = ['_attributes' => ['lang' => 'en'],'fake'=>$institution->address_street];
            $institution_xml['address']['city']  = ['_attributes' => ['lang' => 'en'],'fake'=>$institution->address_city];
            $institution_xml['coordinates'] = "{$institution->longitude},{$institution->latitude}";
            $institution_xml['inst_type'] = $institution->venue_type;

            $contacts=DB::table('contacts')
                ->join('cont2insts','cont2insts.cont_id' , '=' , 'contacts.id')
                ->where('cont2insts.inst_id', '=', $institution->id)
                ->select('contacts.*')->get();
            foreach ($contacts as $contact){
                $phone = (isset($contact->phone)? $contact->phone:'');
                $institution_xml['contact'][] = ['name'=>$contact->name, 'email'=>$contact->email, 'phone'=>$phone, 'type'=>$contact->type, 'privacy'=>1];
            }
            $institution_xml['info_URL'][]=['_attributes' => ['lang' => 'en'],'fake'=>$institution->info_URL_en];
            $institution_xml['info_URL'][]=['_attributes' => ['lang' => 'ru'],'fake'=>$institution->info_URL_ru];
            $institution_xml['policy_URL'][]=['_attributes' => ['lang' => 'en'],'fake'=>$institution->policy_URL_en];
            $institution_xml['policy_URL'][]=['_attributes' => ['lang' => 'ru'],'fake'=>$institution->policy_URL_ru];

            $date = Carbon::now()->format('Y-m-d');
            $time= Carbon::now()->format('H:i:s');

            $institution_xml['ts'] = "{$date}T{$time}";

            $locations = DB::table('outlets')
                ->where('creator_id', '=', $institution->creator_id)
                ->get();

            foreach ($locations as $location) {
                $locs=array();
                $locs['locationid']=$location->location_id;
                $locs['coordinates'] = "{$location->longitude},{$location->latitude}";
                $locs['stage'] =1;
                $locs['type'] = 1;
                $locs['loc_name']=['_attributes' => ['lang' => 'en'],'fake'=>$instname->name_en];
                $locs['address']['street']  = ['_attributes' => ['lang' => 'en'],'fake'=>$location->address_street];
                $locs['address']['city']  = ['_attributes' => ['lang' => 'en'],'fake'=>$location->address_city];
                $locs['location_type'] = $location->location_type;
                $contacts=DB::table('contacts')
                    ->join('cont2locs','cont2locs.cont_id' , '=' , 'contacts.id')
                    ->where('cont2locs.loc_id', '=', $location->id)
                    ->select('contacts.*')->get();

                foreach ($contacts as $contact){
                    $phone = (isset($contact->phone)? $contact->phone:'');
                    $locs['contact'][] = ['name'=>$contact->name, 'email'=>$contact->email, 'phone'=>$phone, 'type'=>$contact->type, 'privacy'=>1];
                }
                $locs['SSID'] = 'eduroam';
                $locs['enc_level'] = 'WPA2';
                $locs['AP_no'] = $location->AP_no;
                $locs['info_URL']  = ['_attributes' => ['lang' => 'en'],'fake'=>$location->info_URL];

                $institution_xml['location'][] = $locs;
            }

            $a['institution'][]=$institution_xml;
        }
         $result = ArrayToXml::convert($a, [
            'rootElementName' => 'institutions',
        ], true, 'UTF-8', "1.0", ['formatOutput' => true]);
        $result = str_replace("<fake>", '', $result);
        $result = str_replace("</fake>", '', $result);


        echo $result;

    }

    public function export_m()
    {
        $markers=array();
        $institutions = Institution::all();
        foreach($institutions as $institution){
            $name_1=DB::table('instnames')->where('id', '=', $institution->id)->first();
            $name = $name_1->name_ru;
            $locations = Outlet::where('creator_id','=', $institution->creator_id)->get();
            foreach ($locations as $location){
                $marker=array();
                $this->address ($location->latitude, $location->longitude, 'ru');
                $marker['lat'] = $location->latitude;
                $marker['lon'] = $location->longitude;
                $marker['address'] = "{$this->address_city}, {$this->address_street}";
                $marker['markername']=$location->location_id;
                $marker['basemap']='osm_mapnik';
                $marker['layer']=2;
                $marker['icon']="eduroam_marker.png";
                $marker['popuptext']=$name;
                $marker['zoom']=17;
                $marker['mapwidth']=640;
                $marker['mapwidthunit']='px';
                $marker['mapheight']=480;
                $marker['panel'] =1;
                $marker['createdby'] ="wordpress_user";
                $marker['createdon'] = $location->created_at;
                $marker['cupdatedby'] ="wordpress_user";
                $marker['cupdatedby'] = $location->updated_at;
                $markers[]=$marker;
            }

        }
        $formatter = Formatter::make($markers, Formatter::ARR);
        $csv   = $formatter->toCsv();
        dd($csv);
    }

    public function fill_ru_address (){
          $outlets = Outlet::all();
       foreach ($outlets as $outlet) {
           if (!$outlet->address_street_ru) {
               $this->address($outlet->latitude, $outlet->longitude, 'ru');
               $outlet->address_city_ru = $this->address_city;
               $outlet->address_street_ru = $this->address_street;
               $outlet->save();
           }
       }

    }

    public function address($lat, $lon, $language)
    {
	//$key = env('GOOGLE_API');
        $key = config('app.google_key');
        $url="https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lon}&key={$key}&language={$language}";
        // get the json response
	$resp_json = file_get_contents($url);

        // decode the json
        $res = json_decode($resp_json, true);
        $this->address_city = '';
        $this->address_street = '';
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
                        $this->address_city = $addr['long_name'];
                        break;
                }
            }
        }

        $this->address_street = "{$address_route}, {$address_number}";
    }


    protected function array_to_xml( $data, &$xml_data ) {
        foreach( $data as $key => $value ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            if( is_array($value) ) {
                $subnode = $xml_data->addChild($key);
                array_to_xml($value, $subnode);
            } else {
                $xml_data->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }


}
