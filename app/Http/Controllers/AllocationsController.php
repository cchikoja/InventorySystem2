<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AllocationsController extends Controller
{

    private $page = 'allocations';

    public function __construct()
    {
        $this->middleware(['auth','active','password_check']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = $this->page;
        $allocations = Allocation::all();
        return view('allocations.index', compact(['allocations', 'page']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assets = Asset::all();
        $users = User::all();
        $page = $this->page;
        return view('allocations.create', compact(['page', 'users', 'assets']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset' => ['required', 'exists:assets_tbl,id'],
            'user' => ['required', 'exists:users,id'],
            'date' => ['required', 'date', 'before:tomorrow'],
        ]);

        $data = $request->input();
        try {
            DB::transaction(function () use ($data) {
                Allocation::create([
                    'asset_id' => $data['asset'],
                    'user_id' => $data['user'],
                    'date' => date('Y-m-d', strtotime($data['date'])),
                    'status' => 'active',
                    'allocator' => Auth::user()->id,
                    'assigned' => true,
                ]);

                Asset::find($data['asset'])->update([
                    'assigned' => true,
                ]);
            });

        } catch (\Exception $exception) {
            \Session::flash('error-notification', 'There are errors ' . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', 'Allocation Successful');
        if (Auth::user()->role = 'employee'){
            return redirect()->route('home.allocations');
        } else{
            return redirect()->route('allocations.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
