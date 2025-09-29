<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Services\FileStorageService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {

        $this->fileStorageService = $fileStorageService;
    }

    /**
     * Display a listing of the super admins.
     */
    public function index()
    {
        $users = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new super admin.
     */
    public function create()
    {
        $roles = Role::where('slug', '!=', 'super-admin')->get();

        return view('users.create', compact('roles'));
    }

    public function toggleStatus($id)
    {
        $super_admin = User::findOrFail($id);

        if ($super_admin->status == 'active') {
            $super_admin->status = 'freeze';
        } else {
            $super_admin->status = 'active';
        }

        $super_admin->save();

        return redirect()->route('users.list')->with('success', 'User status updated successfully.');
    }

    /**
     * Store a newly created super admin in the database.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255',
            'role_id'    => 'required|integer|exists:roles,id',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            Toastr::error($validator->errors()->first()); // Show first error message
            return redirect()->back()->withInput();
        }

        // Use validated data
        // $validated = $validator->validated();

        $superAdmin = new User();
        $superAdmin->name = $request->name;
        $superAdmin->role_id = $request->role_id;
        $superAdmin->email = $request->email;
        $superAdmin->password = bcrypt($request->password);
        $superAdmin->status = 'active';
        $superAdmin->failed_attempt_count = 0;
        $superAdmin->last_login_ip = request()->ip();
        $superAdmin->last_login = now();
        $superAdmin->created_by = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $awsImageUploadResponse = $this->fileStorageService->uploadImageToCloud($image, 'users');
            $superAdmin->image = $awsImageUploadResponse['public_path'];
        }

        $superAdmin->save();

        return redirect()->back()->with('success', 'User created successfully.');
    }

    /**
     * Display the specified super admin.
     */
    public function show($id)
    {
        $superAdmin = User::findOrFail($id);
        $roles = DB::table('roles')->get();

        return view('users.edit', compact('superAdmin', 'roles'));
    }


    public function profile()
    {
        $superAdmin = User::findOrFail(auth()->user()->id);

        return view('users.profile', compact('superAdmin'));
    }

    /**
     * Update the specified super admin in the database.
     * This method uses POST instead of PUT/PATCH.
     */
    public function update(Request $request, $id)
    {
        $superAdmin = User::findOrFail($id);
        $superAdmin->name = $request->name;
        if (auth()->user()->id == $superAdmin->id && $superAdmin->role_id != $request->role_id) {
            return redirect()->route('super-admin.index')->with('error', 'You cannot change your own role.');
        }
        $superAdmin->role_id = $request->role_id;
        $superAdmin->email = $request->email;

        if ($request->filled('password')) {
            $superAdmin->password = Hash::make($request->password);
        }

        $superAdmin->status = $request->status;
        // $superAdmin->updated_by = auth()->user()->id;
        $superAdmin->last_login_ip = request()->ip();
        $superAdmin->last_login = now();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($superAdmin->image) {
                $deleteFile = $this->fileStorageService->updateFileFromCloud($superAdmin->image, $image);
            }

            $awsImageUploadResponse = $this->fileStorageService->uploadImageToCloud($image,'user');
            $superAdmin->image = $awsImageUploadResponse['public_path'];
        }

        $superAdmin->save();

        Toastr::success("User updated successfully");
        return redirect()->route('users.list');
    }

    /**
     * Remove the specified super admin from the database (Soft Delete).
     */
    public function destroy($id)
    {
        $superAdmin = SuperAdmin::findOrFail($id);

        $superAdmin->status = 'inactive';
        $superAdmin->save();

        $superAdmin->delete();
        return redirect()->route('super-admin.index')->with('success', 'Super Admin deleted successfully.');
    }
}
