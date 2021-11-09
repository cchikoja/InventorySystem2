<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\DailyMailNotifications;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class LegalHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'legal', 'active']);
        $this->middleware('password_check')->except(['settings', 'changePassword']);
        if (count($this->getExpiringContracts()) > 0) {
//            \Session::flash('error-notification', 'Some contracts are expiring, please check');
            $contracts = [];
            foreach ($this->getExpiringContracts() as $information) {
                $contracts[] = ['Title' => $information->title, 'Expiry' => $information->expiry_date, 'Description' => $information->description];
            }
            $prepared = json_encode($contracts);
            try {
                if (count(DailyMailNotifications::where('date', date('Y-m-d'))->get()) < 1) {
                    //Checking if there are expiring contracts
                    Mail::raw('The following contracts are expiring: ' . $prepared, function ($text) {
                        $text->to('helpdesk@continental.mw')->subject('Contracts Expiring');
                    });

                    //adding the entry
                    DailyMailNotifications::create([
                        'date' => date('Y-m-d'),
                        'notified' => true,
                    ]);
                }

            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
            }

        }
    }

    public function index()
    {
        $page = 'legal';
        $attentionItems = $this->getAttentionItems();
        $expiringContracts = $this->getExpiringContracts();
        $summary = $this->getSummary();
        return view('legal.index', compact(['page', 'attentionItems', 'expiringContracts', 'summary']));
    }

    public function getExpiringContracts()
    {
        $expiringContracts = [];
        foreach (Contract::where('status', 'active')->get() as $contract) {
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

    public function getAttentionItems()
    {
        $items = [];
        if (count($this->getExpiringContracts()) > 0) {
            $items [] = 'Contracts will expire soon, please check !';
        }

        if (Contract::where('status', 'expired')->count() > 0) {
            $items [] = 'Some contracts have expired !';
        }
        return $items;
    }

    public function reports(Request $request)
    {
        $expiringContracts = [];
        foreach (Contract::where('status', 'active')->get() as $contract) {
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
        return view('legal.reports', compact(['page', 'expiringContracts']));
    }

    public function reportsPDF()
    {
        $expiringContracts = [];
        foreach (Contract::where('status', 'active')->get() as $contract) {
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
        $data = [
            'title' => 'Contracts Expiring In ' . date('F-Y'),
            'author' => 'CMS',
        ];
        $pdf = \PDF::loadView('legal.pdf-reports', compact(['expiringContracts']));
        return $pdf->download('Expiring_Contracts_' . date('F-Y').'.pdf');
    }

    public function expiredContracts()
    {
        $contracts = Contract::where('status', 'expired')->get();
        $page = 'contracts';
        return view('legal.contracts.expired', compact(['page', 'contracts']));
    }

    public function getSummary(): array
    {
        return [
            'CAM' => Contract::where('company', 'CAM')->where('status', 'active')->count(),
            'CCL' => Contract::where('company', 'CCL')->where('status', 'active')->count(),
            'CPS' => Contract::where('company', 'CPS')->where('status', 'active')->count(),
            'CHL' => Contract::where('company', 'CHL')->where('status', 'active')->count(),
            'CPL' => Contract::where('company', 'CPL')->where('status', 'active')->count(),
        ];
    }

    public function settings()
    {
        $page = 'settings';
        return view('legal.settings', compact(['page']));
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
