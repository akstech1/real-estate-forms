<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'guard_name' => 'required|string|max:255'
        ], [
            'name.required' => 'Role name is required.',
            'name.unique' => 'Role name already exists.',
            'guard_name.required' => 'Guard name is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name ?? 'web'
            ]);

            return redirect()->route('dashboard.roles.index')
                ->with('success', 'Role created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating role: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'guard_name' => 'required|string|max:255'
        ], [
            'name.required' => 'Role name is required.',
            'name.unique' => 'Role name already exists.',
            'guard_name.required' => 'Guard name is required.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $role->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name ?? 'web'
            ]);

            return redirect()->route('dashboard.roles.index')
                ->with('success', 'Role updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating role: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id);
            
            // Check if role is assigned to any users
            if ($role->users()->count() > 0) {
                return redirect()->route('dashboard.roles.index')
                    ->with('error', 'Cannot delete role. It is assigned to users.');
            }

            $role->delete();

            return redirect()->route('dashboard.roles.index')
                ->with('success', 'Role deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('dashboard.roles.index')
                ->with('error', 'Error deleting role: ' . $e->getMessage());
        }
    }
}
