<?php

namespace App\Http\Controllers;

use App;
use App\Outlet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminDataController;

class MapExportController extends Controller
{
    /**
     * Show the outlet listing in LeafletJS map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    protected $address_street, $address_city;
    public function index()
    {


        $outlets = DB::table('outlets')
            ->join('institutions', 'outlets.creator_id', '=', 'institutions.creator_id')
            ->join('instnames', 'instnames.id', '=', 'institutions.inst_name_id')
            ->select('outlets.latitude', 'outlets.longitude', 'outlets.name', 'instnames.name_ru', 'outlets.address_city_ru', 'outlets.address_street_ru')
            ->orderby('name_ru')
            ->get();



        return view('outlets.map_export', compact('outlets'));

    }
    public function index_en()
    {


        $outlets = DB::table('outlets')
            ->join('institutions', 'outlets.creator_id', '=', 'institutions.creator_id')
            ->join('instnames', 'instnames.id', '=', 'institutions.inst_name_id')
            ->select('outlets.latitude', 'outlets.longitude', 'outlets.name', 'instnames.name_en', 'outlets.address_city', 'outlets.address_street')
            ->orderby('name_en')
            ->get();



        return view('outlets.map_export_en', compact('outlets'));

    }

}
