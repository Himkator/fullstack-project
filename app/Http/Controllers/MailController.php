<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnrollmentMail;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

class MailController extends Controller {

    public function enroll(Request $request) {

        if (!session('user_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $user   = User::find(session('user_id'));
        $course = Course::find($request->course_id);

        if (!$course) {
            return back()->with('error', 'Course not found.');
        }

        $alreadyEnrolled = Enrollment::where('user_id', $user->id)
                                     ->where('course_id', $course->id)
                                     ->first();

        if ($alreadyEnrolled) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'user_id'   => $user->id,
            'course_id' => $course->id,
        ]);

        Mail::to($user->email)->send(
            new EnrollmentMail($user->login, $course->title)
        );

        return back()->with('success', 'Successfully enrolled in ' . $course->title . '! Check your email.');
    }
}