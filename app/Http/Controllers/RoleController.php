<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Role;
use App\Models\RolePermission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::all();
        $modules = Module::with('Permissions')->get(); 
        return view('role.create',compact('role', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'role_name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'required|integer|exists:permissions,id'
        ]);

        if($validator->fails())
        {
            Toastr::error($validator->getMessageBag(), 'Error', ['options']);
            return redirect()->back();
        }

        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->role_name,
                'slug' => Str::slug($request->role_name),
            ]);

            // Assign permissions to role
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permissionId) {
                    RolePermission::create([
                        'role_id' => $role->id,
                        'permission_id' => $permissionId,
                    ]);
                }
            }

            DB::commit();

            Toastr::success('Role created successfully.');
            return redirect()->route('user.roles.list');
        } 
        catch (\Exception $e) {
            DB::rollBack();
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $modules = Module::with('Permissions')->get();

        return view('role.edit', compact('role', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id'
        ]);

        DB::beginTransaction();
        try {

            $role = Role::findOrFail($id);
            $role->update([
                'name' => $request->role_name,
            ]);

            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            } else {
                $role->permissions()->sync([]);
            }

            DB::commit();
            return redirect()->route('user.roles.list')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Change status of role & user storage.
     */
    public function toggleStatus($id)
    {
        DB::beginTransaction();
    
        try {
            $role = Role::findOrFail($id);
    
            if ($role->status == 'active') {
                $role->status = 'inactive';
                $role->users()->update(['status' => 'frozen']);
            } else {
                $role->status = 'active';
                $role->users()->update(['status' => 'active']);
            }
    
            $role->save();
    
            DB::commit();
    
            return redirect()->route('user.roles.list')->with('success', 'Role status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('user.roles.list')->with('error', 'Failed to update role status: ' . $e->getMessage());
        }
    }
}
