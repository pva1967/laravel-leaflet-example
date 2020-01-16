<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
        	'venue_type',	'inst_stage',	'inst_name_id',	'address_street',	'address_city', 'latitude',	'longitude','info_URL_en','info_URL_ru',
    'policy_URL_en', 'policy_URL_ru', 'creator_id', 'venue_type', 'inst_stage'
    ];

    /**
     * @return string
     */
    public function getLocAttribute()
    {
        $venue ='';
        switch($this->venue_type)
        {

            case '3,3':
                $venue = "Университет, колледж";
                break;
            case '2,8' :
                $venue = "Исследовательский институт";
                break;
            case '7,3' :
                $venue = "Общежитие";
        }

        return $venue;
    }
    public function getNameRuAttribute()
    {
        $name_ru = DB::table('instnames')
            ->where('id','=', $this->inst_name_id)
            ->select('name_ru')
            ->first();

        return $name_ru->name_ru ?? '';
    }
    public function getNameEnAttribute()
    {
        $name_en = DB::table('instnames')
            ->where('id','=', $this->inst_name_id)
            ->select('name_en')
            ->first();

        return $name_en->name_en ?? '';
    }
}
