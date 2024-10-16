<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view permissions', ['only' => ['index']]);
    //     $this->middleware('permission:edit permissions', ['only' => ['edit']]);
    //     $this->middleware('permission:create permissions', ['only' => ['create']]);
    //     $this->middleware('permission:delete permissions', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('created_at','DESC')->paginate(10);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission added successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id',
        ]);

        if ($validator->passes()) {
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $permission = Permission::find($request->id);
    
        if ($permission == null) {
            session()->flash('error', 'Permission not found!');
            return response()->json([
                'status' => false,
                'message' => 'Permission not found!'
            ], 404);
        }
    
        $permission->delete();
    
        session()->flash('success', 'Permission deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Permission deleted successfully'
        ]);
    }
    
}
