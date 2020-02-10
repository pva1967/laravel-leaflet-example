<?php

namespace App\Http\Controllers\Admin;

use App;
use App\Institution;
use App\Realm;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $institutions = Institution::get()->sortBy('name_ru');
        if (null!== $admin)
        {
            $session = Session::get('SA_Inst_id');
            $inst_id = $session ?? $institutions->first()->id;

        }
        else {

                App::abort(500, 'Нет данных об организации');
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
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

        ]);
        User::create([
                'name' => $data['name'],
                'email' => $data['email'],

            ]);
        return redirect()->route('admin.user_index');

    }
    public function user_update(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],

        ]);
        $user = User::find($request->input('user_id'));
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return redirect()->route('admin.user_index');

    }
    public function user_index()
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        $admins = DB::table('users')
            ->join('institutions', 'institutions.creator_id', '=', 'users.id')
            ->join('instnames','instnames.id', '=', 'institutions.id')
            ->select('users.name as name', 'users.email as email', 'instnames.name_ru as instname', 'users.id as user_id')
            ->where('name', 'like', '%' . request('q') . '%')
            ->orderBy('instname', 'asc')
            ->get();

        return view('admin.user_index', compact('admins'));

    }
    public function user_create()
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        return view('admin.user_create');
    }
    public function user_edit($user_id)
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        $user = User::find($user_id);
        return view('admin.user_edit', compact('user'));
    }
    public function name_create()

    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        return view('admin.name_create');
    }
    public function name_store(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
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
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        $instnames = DB::table('instnames')->orderBy('name_ru')->get();

        $users = DB::table('users')->orderBy('name')->get();
        return view('admin.inst_create', compact('instnames','users'));
    }
    public function inst_store(Request $request)
    {

        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        $data = $request->validate([
            'inst_name' =>'unique:institutions,inst_name_id' ,
            'creator_id' => 'required',
            'inst_type' => 'required',
            'info_URL_en' => 'required|url',
            'info_URL_ru' => 'nullable|url',
            'policy_URL_en' => 'required|url',
            'policy_URL_ru' => 'nullable|url',

        ]);
        $institution = new Institution;
        $institution->inst_name_id = $data['inst_name'];
        $institution->creator_id = $data['creator_id'];
        $institution->save();

        return redirect()->route('admin.dashboard');

    }
    public function realm_create()
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
       $instnames = DB::table('instnames')
            ->join('institutions', 'instnames.id', '=', 'institutions.inst_name_id')
            ->select('instnames.name_ru as inst_name', 'institutions.id as id')
            ->orderBy('inst_name')
            ->get();


        return view('admin.realm_create', compact('instnames'));
    }
    public function realm_store(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        $data = $request->validate([
            'inst_name' =>'required' ,
            'realm' => ['required', 'regex:/^([a-z0-9_*]+\.)+[a-z0-9_*]+$/', 'unique:realms,realm'],
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
    public function policy_add()
    {
        $admin = Auth::guard('admin')->user();
        $institutions = Institution::get()->sortBy('name_ru');
        if (null!== $admin)
        {
            $session = Session::get('SA_Inst_id');
            $inst_id = $session ?? $institutions->first()->id;

        }
        else {

            App::abort(500, 'Нет данных об организации');
        }
        $instname = DB::table('instnames')->find($inst_id);
        $instname_ru = $instname->name_ru;

        return view('admin.policy_add', compact('instname_ru', 'inst_id'));
    }
    public function policy_store(Request $request)
    {

        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        $data = $request->validate([
            'inst_id' =>'required' ,
            'policy' => 'required|url'
        ]);
        DB::table('institutions')
            ->where('id', $data['inst_id'])
            ->update(['policy' => $data['policy']]);

        return redirect()->route('admin.dashboard');

    }

    public function realm_edit()
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        if (isset($_GET['q']) and 'del' == $_GET['q']){
            $realm = $_GET['realm'];
            return view('admin.realm_edit', compact('realm'));
        }
        else{

        $realms = DB::table('realms')
            ->orderBy('realm')
            ->get();

        return view('admin.realm_edit', compact('realms'));
        }
    }
    public function realm_destroy(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (null == $admin)
        {
            return App::abort(403, 'Требуется авторизация');
        }
        $realm = $request->input('realm');

        $deleted = DB::table('realms')->where("realm", "=", $realm)->delete();

            return redirect()->route('admin.dashboard');
    }


    public function PasswordSend (Request $request)
    {

        $user = User::find($request->input('user_id'));
       // $new_token = (new Token())->Unique('users', 'email', 40);
       // dd($user, $new_token);
        $credentials = ['email' => $user->email];
        $response = Password::sendResetLink($credentials, function (Message $message) {
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }

    }


}
