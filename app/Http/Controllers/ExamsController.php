<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Exam;

class ExamsController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::with('category')->latest()->get();

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        return view('exams.create',compact('categories'));
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
            'exam_name' => 'required',
//            'time_limit' => 'required',
//            'category_id' => 'required'
        ]);

        $exams = new Exam();
        $exams->exam_name = $request->exam_name;
//        $exams->time_limit = $request->time_limit;
//        $exams->category_id = $request->category_id;
        $exams->save();

        return redirect()->route('exams.index')->with('success','Exam has been created');

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
            $exam = Exam::findOrFail($id);
        $categories = Category::orderBy('category_name')->get();

        return view('exams.edit', compact('exam','categories'));
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
            'exam_name' => 'required',
//            'time_limit' => 'required',
//            'category_id' => 'required'
        ]);

        $exam = Exam::findOrFail($id);
        $exam->exam_name = $request->exam_name;
//        $exam->time_limit = $request->time_limit;
//        $exam->category_id = $request->category_id;
        $exam->save();

        return redirect()->route('exams.index')->with('success','Exam has been created');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        if($exam->delete()){
            return ['status'=>'success'];
        }else{
            return ['status'=>'failed'];
        }
    }
}
