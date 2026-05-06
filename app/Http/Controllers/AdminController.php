<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Course;

class AdminController extends Controller
{
    public function showManageCourses(){
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }
        $user = User::find(session('user_id'));
        if (!$user->hasPermissionTo('manage courses')) {
            return redirect('/')->with('error', 'Access denied. Instructors and Admins only.');
        }

        $courses = Course::all();
        return view('manage_courses', compact('courses'));
    }

    public function showManageUsers(){
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }
        $user = User::find(session('user_id'));
        if (!$user->hasPermissionTo('manage users')) {
            return redirect('/')->with('error', 'Access denied. Admins only.');
        }
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin', compact('users', 'roles'));
    }

    public function changeUserRole(){
        if (!session('user_id')) return redirect('/login');

        $currentUser = User::find(session('user_id'));
        if (!$currentUser->hasPermissionTo('manage users')) {
            return redirect('/')->with('error', 'Access denied.');
        }

        $targetUser = User::find(request('user_id'));
        $roleName   = request('role_name');

        $targetUser->syncRoles([$roleName]);

        return back()->with('success', 'Role updated successfully.');
    }
}
