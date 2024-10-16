<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view users', ['only' => ['index']]);
    //     $this->middleware('permission:edit users', ['only' => ['edit']]);
    //     // $this->middleware('permission:create users', ['only' => ['create']]);
    //     // $this->middleware('permission:delete users', ['only' => ['delete']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRoles = $user->roles->pluck('id');
        return view('users.edit', compact('user', 'roles', 'hasRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
        ]);
        if ($validator->fails()) {
            return redirect()->route('users.edit', $user)->withInput()->withErrors($validator);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
