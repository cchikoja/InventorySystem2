<?php

namespace App\Http\Controllers;

use App\Models\ContactsLinks;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractsController extends Controller
{
    private $page = 'contracts';

    public function __construct()
    {
        $this->middleware(['auth', 'active', 'password_check']);
        $this->middleware('legal')->except(['downloadContract']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $flag = $request->input('flag');
        $page = 'legal';
        if ($flag == 'CCL')
            $contracts = Contract::where('company', 'CCL')->get();
        elseif ($flag == 'CAM')
            $contracts = Contract::where('company', 'CAM')->get();
        elseif ($flag == 'CPS')
            $contracts = Contract::where('company', 'CPS')->get();
        else
            $contracts = [];
        $page = $this->page;
        return view('legal.contracts.index', compact(['page', 'contracts', 'flag']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contracts = Contract::all();
        $companies = [
            'CCL' => 'Continental Capital Limited',
            'CAM' => 'Continental Asset Management',
            'CPS' => 'Continental Pension Services',
            'CHL' => 'Continental Holdings Limited',
            'CPL' => 'Continental Properties Limited',
        ];
        $page = $this->page;
        return view('legal.contracts.create', compact(['page', 'companies', 'contracts']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'start' => ['required', 'date', 'before:tomorrow'],
            'close' => ['required', 'date'],
            'company' => ['required'],
            'description' => ['required'],
            'document' => ['required', 'mimes:pdf'],
        ]);

        $data = $request->input();
        try {
            //saving the file
            $document = preg_replace('/\s+/', '_', $data['title']);
            $filename = $document . '.' . $request->document->extension();
            if ($request->document->move(public_path('contracts'), $filename)) {
                DB::transaction(function () use ($data, $filename) {
                    $contract = Contract::create([
                        'title' => $data['title'],
                        'start_date' => $data['start'],
                        'expiry_date' => $data['close'],
                        'path' => 'contracts' . DIRECTORY_SEPARATOR . $filename,
                        'status' => 'active',
                        'description' => $data['description'],
                        'uploader' => Auth::user()->id,
                        'company' => $data['company']
                    ]);
                    $contract->save();

                    if ($data['link'] != null) {
                        ContactsLinks::create([
                            'subject' => $contract->id,
                            'object' => $data['link'],
                            'status' => true,
                        ]);
                    }
                });

            }
        } catch (\Exception $exception) {
            \Session::flash('error-notification', 'Registration Failed ' . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', 'Registration Successful');
        return redirect()->route('contracts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        $page = $this->page;
        $linkedContracts = ContactsLinks::where('subject', $contract->id)->get();
        return view('legal.contracts.show', compact(['page', 'contract', 'linkedContracts']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        $contracts = Contract::all();
        $companies = [
            'CCL' => 'Continental Capital Limited',
            'CAM' => 'Continental Asset Management',
            'CPS' => 'Continental Pension Services',
        ];
        $page = $this->page;
        $linkedContracts = ContactsLinks::where('subject', $contract->id)->get();
        return view('legal.contracts.edit', compact(['page', 'contract', 'linkedContracts', 'contracts', 'companies']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'title' => ['required'],
            'start' => ['required', 'date', 'before:tomorrow'],
            'close' => ['required', 'date'],
            'company' => ['required'],
            'description' => ['required'],
        ]);
        $data = $request->input();
        try {
            DB::transaction(function () use ($data, $contract, $request) {
                $contract->update([
                    'title' => $data['title'],
                    'start_date' => $data['start'],
                    'expiry_date' => $data['close'],
                    'status' => 'active',
                    'description' => $data['description'],
                    'uploader' => Auth::user()->id,
                    'company' => $data['company']
                ]);
                $contract->save();

                if ($request->file('document') !== null) {
                    //Saving the file
                    $document = preg_replace('/\s+/', '_', $data['title']);
                    $filename = $document . '.' . $request->document->extension();
                    if ($request->document->move(public_path('contracts'), $filename)) {
                        $contract->update([
                            'path' => 'contracts' . DIRECTORY_SEPARATOR . $filename,
                        ]);
                    } else {

                    }

                } else {

                }

                if ($data['link'] != null) {
                    if (ContactsLinks::where('subject', $contract->id)->count() > 0) {
                        ContactsLinks::where('subject', $contract->id)->first()->update([
                            'subject' => $contract->id,
                            'object' => $data['link'],
                            'status' => true,
                        ]);
                    }
                }
            });
        } catch (\Exception $exception) {
            \Session::flash('error-notification', 'Update Failed ' . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', 'Update Successful');
        return redirect()->route('contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function openContract(Contract $contract)
    {
        $pathToFile = public_path($contract->path);
        return response()->file($pathToFile);
    }

    public function downloadContract(Contract $contract)
    {
        $pathToFile = public_path($contract->path);
        return response()->download($pathToFile);
    }

    public function cancelContract(Contract $contract)
    {
        try {
            $contract->update(['status' => 'cancelled']);
        } catch (\Exception $exception) {
            \Session::flash('error-notification', 'Operation Failed ' . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', 'Contract Cancelling Successful');
        return redirect()->route('contracts.index');
    }
}
