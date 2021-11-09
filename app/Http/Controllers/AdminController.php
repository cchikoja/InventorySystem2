<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Asset;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{

    private $page = 'admin';

    public function __construct()
    {
        $this->middleware(['auth', 'admin', 'active']);
        $this->middleware('password_check')->except(['settings', 'changePassword']);
        self::expireAllocations();
        self::expiringAllocations();
    }

    public function index()
    {
        $summary = [
            'admin' => User::where('role', 'admin')->count(),
            'accountants' => User::where('role', 'employee')->count(),
            'assets' => Asset::all()->count(),
            'active-allocations' => Allocation::where('status', 'active')->count(),
        ];
        $attentionItems = self::getAttentionItems();
        $expiringAllocations = self::expiringAllocations();
        $page = $this->page;
        return view('admin.index', compact(['page', 'summary', 'attentionItems', 'expiringAllocations']));
    }

    public function assets()
    {
        $page = 'assets';
        return view('admin.assets.index', compact(['page']));
    }

    public function contracts()
    {
        $page = 'contracts';
        $contracts = Contract::all();
        return view('admin.contracts.index', compact(['contracts', 'page']));
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required'],
            'role' => ['required'],
            'company' => ['required'],
            'designation' => ['required'],
            'gender' => ['required'],
        ]);
        $data = $request->input();
        //registering one user
        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'status' => true,
                'password' => bcrypt('Pasword@1'),
                'company' => $data['company'],
                'designation' => $data['designation'],
                'gender' => $data['gender'],
            ]);
        } catch (\Exception $exception) {
            \Session::flash('error-notification', 'User Registration Failed ' . $exception->getMessage());
            return redirect()->route('users.index');
        }
        \Session::flash('success-notification', 'User Registration Successful');
        return redirect()->route('users.index');
    }

    /**
     * @return array
     */
    public function getAttentionItems(): array
    {
        $items = [];
        if (Asset::where('assigned', false)->count() > 0) {
            $items[] = 'There are some assets which are not assigned to users';
        }
        return $items;

    }

    /**
     *  Automatically Expire Allocations
     */
    public function expireAllocations()
    {
        foreach (Allocation::where('status', 'active')->get() as $allocation) {
            $expire = $allocation->date;
            $expireDate = strtotime($expire);
            $expire = date('Y-m-d', strtotime(' + 3 years', $expireDate));
            $date = date('Y-m-d');
            if ($date >= $expire) {
                try {
                    $allocation->update(['status' => 'expired']);
                } catch (\Exception $exception) {
                    dd($exception);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function expiringAllocations(): array
    {
        $data = [];
        foreach (Allocation::where('status', 'active')->get() as $allocation) {
            $expire = $allocation->date;
            $expireDate = strtotime($expire);
            $expire = date('Y-m-d', strtotime(' + 3 years', $expireDate));
            $date = date('Y-m-d');
            $createdExpire = date_create($expire);
            $createdDate = date_create($date);
            $difference = date_diff($createdDate, $createdExpire);
            if ($difference->format('%R%a days') < 32) {
                $data[] = $allocation;
            }
        }
        return $data;
    }

    public function settings()
    {
        $page = 'settings';
        return view('admin.settings', compact(['page']));
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
                    'password'=>Hash::make($data['password']),
                    'force_passwd_change' => false,
                ]);
            }catch (\Exception $exception){
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

    public function expirePassword(User $user)
    {
        try {
            $user->update(['force_passwd_change'=>true]);
        }catch (\Exception $exception){
            \Session::flash('error-notification', 'Operation Failed' . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', 'Operation Successful');
        return redirect()->back();
    }
}
