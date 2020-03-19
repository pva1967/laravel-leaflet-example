<?php

namespace App\Http\Controllers;

use App;
use App\Institution;
use Illuminate\Support\Facades\Auth;
use App\Connection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    //
    public function index()
    {
        $user=Auth::user();
        $admin = Auth::guard('admin')->user();
        if ($admin)
        {
            $session = session('SA_Inst_id');

            if (null !== $session)
            {
                $institution = Institution::find (strval($session));
                // dd($institution);
            }
            else {
                $institution = Institution::get()->sortBy('name_ru')->first();
            }
        }
        elseif (null!==$user )
        {

            $user_id = Auth::id();
            $institution = Institution::where('creator_id', '=', $user_id)->firstOrFail();
        }

        else
        {
            App::abort(500, 'Нет данных об организации');
        }



        $tempFrom = Carbon::parse(request('from'))->format('d/m/Y');
        $tempTo = Carbon::parse(request('to'))->format('d/m/Y');
        $from = Carbon::parse($tempFrom ?? '03/01/2020')->toDateTimeLocalString();
        $to = Carbon::parse($tempTo ?? '03/03/2020')->addMinutes(1439)->toDateTimeLocalString();
        $stats = DB::table('connections')->where("time_conn", ">=", $from)->where("time_conn", "<=", $to)->paginate(15);

        return view('statistics.index', compact( 'stats', ['from', 'to']));
    }

}
