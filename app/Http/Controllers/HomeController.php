<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class HomeController extends Controller
{
    private $page = 'allocations';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'accounts', 'active']);
        $this->middleware('password_check')->except(['settings', 'changePassword']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function assets()
    {
        $assets = Asset::all();
        $page = 'assets';
        return view('accountant.assets.index', compact(['page', 'assets',]));
    }

    public function createAssets()
    {
        $users = User::all();
        $assets = ['Laptop', 'MI-FI', 'Cellphone', 'Ipad', 'Iphone'];
        $page = 'assets';
        return view('accountant.assets.create', compact(['page', 'assets', 'users']));
    }

    public function saveAssets(Request $request)
    {
        $request->validate([
            'asset' => ['required'],
            'serial' => ['required', 'unique:assets_tbl,serial_no'],
            'model' => ['required'],
            'dop' => ['required', 'date', 'before:tomorrow'],
        ]);

        try {
            $data = $request->input();
            Asset::create([
                'asset' => $data['asset'],
                'serial_no' => $data['asset'],
                'model' => $data['model'],
                'bought' => $data['dop'],
                'expires' => date('Y-m-d'),
                'recorder' => Auth::user()->id,
                'assigned' => false,
            ]);
        } catch (\Exception $exception) {
            \Session::flash('error-notification', 'Update Failed ' . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', 'Update Successful');
        return redirect()->route('home.assets');
    }

    public function allocations()
    {
        $page = $this->page;
        $allocations = Allocation::all();
        return view('accountant.allocations.index', compact(['allocations', 'page']));
    }

    public function createAllocations()
    {
        $assets = Asset::all();
        $users = User::all();
        $page = $this->page;
        return view('accountant.allocations.create', compact(['page', 'users', 'assets']));
    }

    public function settings()
    {
        $page = 'settings';
        return view('settings', compact(['page']));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old' => ['required'],
            'password' => ['required', 'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);
        $data = $request->input();
        if (Hash::check($data['old'], Auth::user()->password)) {
            //checking if the password is not equal to the new password
            if ($data['old'] == $data['password']) {
                \Session::flash('error-notification', 'Password Already used !');
                return redirect()->back();
            }

            //Changing password
            try {
                Auth::user()->update([
                    'password' => Hash::make($data['password']),
                    'force_passwd_change' => false,
                ]);
            } catch (\Exception $exception) {
                \Session::flash('error-notification', 'Password Change Failed ' . $exception->getMessage());
                return redirect()->back();
            }
            Auth::logout();
            return redirect()->route('login')->withMessage('Password Changed, Please login');
        } else {
            \Session::flash('error-notification', 'Invalid Old Password');
            return redirect()->back();
        }
    }

}
