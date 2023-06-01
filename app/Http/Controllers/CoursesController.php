<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class
CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::latest()->get();

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function courseList()
    {

        $courses = Course::latest()->get();


        return view('student.courses.course-list',compact('courses',));
    }

    public function viewCourseDetails($id){
        $course = Course::find($id);

        return view('student.courses.view-course-details',compact('course'));
    }

    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_name' => 'required',
            'course_code' => 'required',
            'units' => 'required',
            'course_description' => 'required',
        ]);

        $course = new Course();
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->course_description = $request->course_description;
        $course->units = $request->units;

        $course->save();

        return redirect()->route('courses.index')->with('success','Course has been created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $course = Course::findOrFail($id);

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'course_name' => 'required',
            'course_code' => 'required',
            'units' => 'required',
            'course_description' => 'required',
        ]);

        $course = Course::findOrFail($id);
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->course_description = $request->course_description;
        $course->units = $request->units;
        $course->save();

        return redirect()->route('courses.index')->with('success','Course has been created');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if($course->delete()){
            return ['status'=>'success'];
        }else{
            return ['status'=>'failed'];
        }
    }
}
