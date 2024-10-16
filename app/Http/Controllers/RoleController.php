<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view roles', ['only' => ['index']]);
    //     $this->middleware('permission:edit roles', ['only' => ['edit']]);
    //     $this->middleware('permission:create roles', ['only' => ['create']]);
    //     $this->middleware('permission:delete roles', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'DESC')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            } 
            return redirect()->route('roles.index')->with('success', 'Role added successfully');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
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
    public function edit(Role $role)
    {
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.edit', compact('hasPermissions', 'role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$role->id.',id',
        ]);

        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();
            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            }else{
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        } else {
            return redirect()->route('roles.edit', $role)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role == null) {
            session()->flash('success','Role not found!');
            return response()->json([
                'status' => false
            ]);
        }

        $role->delete();

        session()->flash('success','Role deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}
