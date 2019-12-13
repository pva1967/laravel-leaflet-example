<?php

namespace App\Http\Controllers;

use App;
use App\Institution;
use App\Realm;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
    public function dashboard()
    {
        $user=Auth::user();
        if (null!== $user)
        {
            if ($user->is_Admin()) {
                $session = Session::get('SA_Inst_id');
                if (null !== $session) {
                    $inst_id = $session;
                } else {
                    $inst_id = Institution::first()->id;
                }
            } else {
                App::abort(500, 'Нет данных об организации');
            }

            $institutions = Institution::all();
        }
        return view('admin.dashboard', compact('institutions', 'inst_id'));
    }

    public function store(Request $request)
    {
        $inst =  $_GET['inst'];
        $request->session()->put('SA_Inst_id', $inst);
        $session = $request->session()->get('SA_Inst_id');
        if (null !== $session) {
            return response()->json([
                'res' => $session,
            ]);
        }
        else {
            return response()->json([
                'res' => 'qq',
            ]);
        }

    }
    public function user_store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        return redirect()->route('admin.dashboard');

    }
    public function user_create()
    {
       return view('admin.user_create');
    }
    public function name_create()
    {
        return view('admin.name_create');
    }
    public function name_store(Request $request)
    {
        $data = $request->validate([
            'name_ru' => ['required', 'string'],
            'name_en' => ['required', 'string'],
        ]);

        try
        {
            // inserting in DB;
            DB::table('instnames')->insert([
                ['name_ru' => $data['name_ru'], 'name_en' => $data['name_en']],
            ]);
        }
        catch(\Illuminate\Database\QueryException $e){
            dump ($e->getMessage());
        }

        return redirect()->route('admin.dashboard');

    }
    public function inst_create()
    {
        $instnames = DB::table('instnames')->get();

        $users = DB::table('users')->get();
        return view('admin.inst_create', compact('instnames','users'));
    }
    public function inst_store(Request $request)
    {

        $data = $request->all();
        $institution = new Institution;
        $institution->inst_name_id = $data['inst_name'];
        $institution->creator_id = $data['creator_id'];
        $institution->save();

        return redirect()->route('admin.dashboard');

    }
    public function realm_create()
    {
       $instnames = DB::table('instnames')
            ->join('institutions', 'instnames.id', '=', 'institutions.inst_name_id')
            ->select('instnames.name_ru as inst_name', 'institutions.id as id')
            ->get();


        return view('admin.realm_create', compact('instnames'));
    }
    public function realm_store(Request $request)
    {
        $data = $request->validate([
            'inst_name' =>'required' ,
            'realm' => ['required', 'regex:/^([a-z0-9_*]+\.)+[a-z0-9_*]+$/'],
            'inst_type',

              ]);
        $pattern = '/^(?:[a-zA-Z0-9_*]+\.)*([a-zA-Z0-9_*-]+)(?:\.\w+)$/';
        preg_match($pattern, $data['realm'], $matches);
        $inst_id = $matches[1];
        $realm = new Realm;
        $realm->realm = $data['realm'];
        $realm->inst_id = $data['inst_name'];
        $realm->save();

        $institution = Institution::find(strval($data['inst_name']));
        $institution->inst_id = $inst_id;
        $institution->save();

        return redirect()->route('admin.dashboard');

    }


}
