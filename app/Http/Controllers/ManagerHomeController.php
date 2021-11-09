<?php

namespace App\Http\Controllers;

use App\Models\ContactsLinks;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ManagerHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'manager']);
        $this->middleware('password_check')->except(['settings', 'changePassword']);
    }

    public function index()
    {
        $page = 'gfc';
        $attentionItems = [];
        $expiringContracts = $this->getExpiringContracts();
        return view('manager.index', compact(['page', 'attentionItems', 'expiringContracts']));
    }

    public function reports(Request $request)
    {
        $company = strtoupper(Auth::user()->company);
        $expiringContracts = [];
        foreach (Contract::where('status', 'active')->where('company', $company)->get() as $contract) {
            $expiryDate = date_create(date('Y-m-d', strtotime($contract->expiry_date)));
            $date = date_create(date('Y-m-d'));
            $difference = date_diff($date, $expiryDate);
            $number = (int)$difference->format('%R%a days');
            if ($number < 30) {
                $expiringContracts[] = $contract;
                //checking if expired to flag them expired
                if ($number < 0) {
                    $contract->update([
                        'status' => 'expired',
                    ]);
                }
            }
        }
        $page = 'reports';
        return view('manager.reports', compact(['page', 'expiringContracts']));
    }

    public function contracts(Request $request)
    {
        $flag = $request->input('flag');
        $contracts = array();
        if ($flag != null && $flag = 'expired') {
            $contracts = Contract::where('status', 'expired')->where('company', Auth::user()->company)->get();
        } else {
            $contracts = Contract::where('status', 'active')->where('company', Auth::user()->company)->get();
        }
        $page = 'contracts';
        return view('manager.contracts', compact(['page', 'contracts', 'flag']));
    }

    public function openContract(Contract $contract)
    {
        $page = 'contracts';
        $linkedContracts = ContactsLinks::where('subject', $contract->id)->get();
        return view('manager.show-contract', compact(['page', 'contract', 'linkedContracts']));
    }

    public function getExpiringContracts()
    {
        $company = Auth::user()->company;
        $expiringContracts = [];
        foreach (Contract::where('status', 'active')->where('company', $company)->get() as $contract) {
            $expiryDate = date_create(date('Y-m-d', strtotime($contract->expiry_date)));
            $date = date_create(date('Y-m-d'));
            $difference = date_diff($date, $expiryDate);
            $number = (int)$difference->format('%R%a days');
            if ($number < 14) {
                $expiringContracts[] = $contract;
                //checking if expired to flag them expired
                if ($number < 0) {
                    $contract->update([
                        'status' => 'expired',
                    ]);
                }
            }
        }
        return $expiringContracts;
    }

    public function settings()
    {
        $page = 'settings';
        return view('manager.settings', compact(['page']));
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
