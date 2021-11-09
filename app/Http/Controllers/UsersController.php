<?php

namespace App\Http\Controllers;

use App\Exports\UserRegistrationTemplate;
use App\Imports\UsersRegistrationSheet;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $page = 'users';

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
        $users = User::all();
        $page = $this->page;
        $exceptions = null;
        return view('admin.users.index', compact(['page', 'exceptions', 'users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = $this->page;
        $companies = [
            'CCL' => 'Continental Capital Limited',
            'CAM' => 'Continental Asset Management',
            'CPS' => 'Continental Pension Services',
            'CHL' => 'Continental Holdings Limited',
        ];
        return view('admin.users.create', compact(['page', 'companies']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $exceptions = [];
        if (isset($request->all()['user'])) {
            foreach ($request->all()['user'] as $user) {

                //Checking if the email is already taken to skip the user
                if (!User::checkEmail($user['email'])) {
                    try {
                        $user = User::create([
                            'email' => $user['email'],
                            'name' => strtolower($user['name']) . ' ' . strtolower($user['surname']),
                            'role' => 'employee',
                            'status' => true,
                            'company' => $user['company'],
                            'designation' => $user['designation'],
                            'gender' => $user['gender'],
                            'password' => bcrypt('Pasword@1')
                        ]);
                        $user->save();
                    } catch (\Exception $exception) {
                        $exceptions[] = $exception->getMessage();
                    }
                }
            }
        }

        if (count($exceptions) > 0) {
            \Session::flash('error-notification', 'There are errors');
        } else {
            \Session::flash('success-notification', 'Users Registration Successful');
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $page = $this->page;
        return view('admin.users.show', compact(['page', 'user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $page = $this->page;
        return view('admin.users.edit', compact(['page', 'user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'gender' => ['required'],
            'role' => ['required'],
            'company' => ['required'],
            'designation' => ['required'],
        ]);
        $data = $request->input();
        try {
            $user->update([
                'email' => $data['email'],
                'name' => $data['name'],
                'gender' => $data['gender'],
                'role' => $data['role'],
                'company' => $data['company'],
                'designation' => $data['designation'],
            ]);
        } catch (\Exception $exception) {
            \Session::flash('error-notification', "Update Failed" . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', "User Updated Successfully");
        return redirect()->route('users.index');
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
        $export = new UserRegistrationTemplate([]);
        return \Excel::download($export, 'Users_Registration_Template.xlsx');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uploadSheet(Request $request)
    {
        $request->validate([
            'sheet' => ['required', 'file', 'mimes:xlsx,csv'],
        ]);
        $page = $this->page;
        $generic = [];
        $data = \Excel::toCollection(new UsersRegistrationSheet, $request->file('sheet'));
        foreach ($data as $user) {
            for ($counter = 1; $counter < count($user); $counter++) {
                for ($columns = 0; $columns < 6; $columns++) {
                    if ($user[$counter][$columns] != null) {
                        $generic[] = [
                            strtolower($user[$counter][0]),
                            strtolower($user[$counter][1]),
                            strtolower($user[$counter][2]),
                            strtolower($user[$counter][3]),
                            strtolower($user[$counter][4]),
                            strtolower($user[$counter][5]),
                        ];
                        break;
                    }
                }
            }
        }
        return view('admin.users.confirm', compact(['generic', 'page']));
    }

    public function manage(User $user, Request $request)
    {
        try {
            switch ($request->input('flag')) {
                case 'enable':
                    $user->update(['status' => true]);
                    break;
                case 'disable':
                    $user->update(['status' => false]);
                    break;
            }
        } catch (\Exception $exception) {
            \Session::flash('error-notification', "Update Failed" . $exception->getMessage());
            return redirect()->back();
        }
        \Session::flash('success-notification', "User Updated Successfully");
        return redirect()->route('users.index');
    }
}
