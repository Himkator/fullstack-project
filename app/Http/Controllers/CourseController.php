<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class CourseController extends Controller
{
    public function showCourses(){
        $courses = Course::all();
        return view('courses', compact('courses'));
    }

    public function showCourseDetails($id){
        $course = Course::findOrFail($id);
        return view('course_detail', compact('course'));
    }

    public function createCourse(){
        if (!session('user_id')) return redirect('/login');

        $user = User::find(session('user_id'));
        if (!$user->hasPermissionTo('manage own courses') && !$user->hasPermissionTo('manage courses')) {
            return redirect('/')->with('error', 'Access denied.');
        }

        $filePath = null;
        if (request()->hasFile('course_file')) {
            $file     = request()->file('course_file');
            $filePath = $file->store('courses', 'public');
        }

        Course::create([
            'title'       => request('title'),
            'level'       => request('level'),
            'description' => request('description'),
            'price'       => request('price'),
            'file_path'   => $filePath,
            'user_id'     => session('user_id'),
        ]);

        return redirect('/manage-courses')->with('success', 'Course added successfully!');
    }

    public function deleteCourse(){
        if (!session('user_id')) return redirect('/login');

        $user = User::find(session('user_id'));
        if (!$user->hasPermissionTo('manage own courses')) {
            return redirect('/')->with('error', 'Access denied.');
        }

        if (!$user->hasPermissionTo('manage courses')) {
            return redirect('/')->with('error', 'Access denied.');
        }
        $user = Course::find(request('course_id'))->user;
        if (!$user->hasPermissionTo('manage own courses') && $user->id !== session('user_id')) {
            return redirect('/')->with('error', 'Access denied.');
        }

        $course = Course::find(request('course_id'));
        if ($course && $course->file_path) {
            Storage::disk('public')->delete($course->file_path);
        }
        $course->delete();

        return redirect('/manage-courses')->with('success', 'Course deleted.');
    }

    public function showManageCourses(){
        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }
        $user = User::find(session('user_id'));

        if (!$user->hasPermissionTo('manage own courses')) {
            return redirect('/')->with('error', 'Access denied. Instructors and Admins only.');
        }
        $courses = Course::where('user_id', session('user_id'))->get();
        return view('manage_courses', compact('courses'));
    }
}
