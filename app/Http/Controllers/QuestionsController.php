<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $questions = Question::with('answers')->with('category')->latest()->get();

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exams = Exam::orderBy('exam_name')->get();
        $categories = Category::orderBy('category_name')->get();
        $courses = Course::orderBy('course_name')->get();

        return view('questions.create', compact('exams','categories','courses'));


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
            'question' => 'required',
            'category_id' => 'required',
            'exam_id' => 'required',
            'course_ids' => 'required',
        ]);


        DB::beginTransaction();
        $question = new Question();
        $question->question = $request->question;
        $question->category_id = $request->category_id;
        $question->course_ids = json_encode($request->course_ids);
        $question->exam_id = $request->exam_id;
        if($question->save()){
            if($request->has('q_answer')){
                $answers = $request->q_answer;
                foreach ($answers as $key => $ans){
                    $answer = new Answer();
                    $answer->answer = $ans;
                    $answer->question_id = $question->id;
                    if($key == $request->correct_answer_key){
                        $answer->correct = 1;
                    }
                    $answer->save();
                }
                DB::commit();
            }
        }

        return redirect()->route('questions.index')->with('success','Question has been created');

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
        $question = Question::with('answers')->findOrFail($id);
        $categories = Category::orderBy('category_name')->get();
        $exams = Exam::orderBy('exam_name')->get();
        $courses = Course::orderBy('course_name')->get();


        return view('questions.edit', compact('question','exams','categories','courses'));
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
            'question' => 'required',
            'exam_id' => 'required',
            'category_id' => 'required',
            'course_ids' => 'required'
        ]);
        DB::beginTransaction();
        $question = Question::with('answers')->findOrFail($id);
        $question->question = $request->question;
        $question->category_id = $request->category_id;
        $question->course_ids = json_encode($request->course_ids);
        $question->exam_id = $request->exam_id;
        if($question->save()){
            if($request->has('q_answer')){
                $answer_ids = $request->answer_ids;
                $answers = $request->q_answer;
                foreach ($answers as $key => $ans){
                    $ans_id = $answer_ids[$key];
                    $answer = Answer::find($ans_id);
                    $answer->answer = $ans;
                    $answer->question_id = $question->id;
                    if($key == $request->correct_answer_key){
                        $answer->correct = 1;
                    }
                    $answer->save();
                }
                DB::commit();
            }
        }

        return redirect()->route('questions.index')->with('success','Question has been created');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        if($question->delete()){
            return ['status'=>'success'];
        }else{
            return ['status'=>'failed'];
        }
    }
}

