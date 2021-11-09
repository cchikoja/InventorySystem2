<?php

namespace App\Http\Controllers;

use App\Exports\AssetsRegistrationTemplate;
use App\Imports\AssetsRegistrationSheet;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetsController extends Controller
{
    private $page = 'assets';

    public function __construct()
    {
        $this->middleware(['auth', 'admin', 'active','password_check']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::all();
        $page = $this->page;
        return view('admin.assets.index', compact(['page', 'assets']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->page;
        return view('admin.assets.create', compact(['page']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exceptions = [];
        if (isset($request->all()['asset'])) {
            foreach ($request->all()['asset'] as $asset) {

                //Checking if the email is already taken to skip the user
                if (!Asset::checkAsset($asset['serial'])) {
                    try {
                        $asset = Asset::create([
                            'asset' => $asset['asset'],
                            'serial_no' => $asset['serial'],
                            'model' => $asset['model'],
                            'company' => $asset['company'],
                            'bought' => date('Y-m-d', strtotime($asset['bought'])),
                            'expires' => date('Y-m-d', strtotime($asset['expires'])),
                            'recorder' => Auth::user()->id,
                        ]);
                        $asset->save();
                    } catch (\Exception $exception) {
                        $exceptions[] = $exception->getMessage();
                    }
                }
            }
        }

        if (count($exceptions) > 0) {
            \Session::flash('error-notification', 'There are errors');
        } else {
            \Session::flash('success-notification', 'Assets Registration Successful');
        }
        return redirect()->route('assets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {
        $page = 'allocations';
        return view('admin.assets.show', compact(['page', 'asset']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        $page = $this->page;
        return view('admin.assets.edit', compact(['page', 'asset']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'asset' => ['required'],
            'serial' => ['required'],
            'model' => ['required'],
        ]);
        $data = $request->input();
        try {
            $asset->update([
                'asset' => $data['asset'],
                'serial_no' => $data['serial'],
                'model' => $data['model'],
            ]);
        } catch (\Exception $exception) {
            \Session::flash('error-notification', 'Update Failed ' . $exception->getMessage());
            return redirect()->route('assets.index');
        }
        \Session::flash('success-notification', 'Update Successful');
        return redirect()->route('assets.index');
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

    public function registrationSheet()
    {
        $export = new AssetsRegistrationTemplate([]);
        return \Excel::download($export, 'Assets_Registration_Template.xlsx');
    }

    public function uploadSheet(Request $request)
    {
        $request->validate([
            'sheet' => ['required', 'file', 'mimes:xlsx,csv'],
        ]);
        $page = $this->page;
        $generic = [];
        $data = \Excel::toCollection(new AssetsRegistrationSheet, $request->file('sheet'));
        foreach ($data as $asset) {
            for ($counter = 1; $counter < count($asset); $counter++) {
                for ($columns = 0; $columns < 8; $columns++) {
                    if ($asset[$counter][$columns] != null) {
                        $generic[] = [
                            strtolower($asset[$counter][0]),
                            strtolower($asset[$counter][1]),
                            strtolower($asset[$counter][2]),
                            strtolower($asset[$counter][3]),
                            date('d-M-Y', strtotime('1899-12-31+' . ((int)strtolower($asset[$counter][4] - 1)) . 'days')),
                            date('d-M-Y', strtotime('1899-12-31+' . ((int)strtolower($asset[$counter][5] - 1)) . 'days')),
                        ];
                        break;
                    }
                }
            }
        }
        return view('admin.assets.confirm', compact(['generic', 'page']));
    }
}
