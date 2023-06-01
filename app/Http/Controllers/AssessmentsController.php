<?php

namespace App\Http\Controllers;

use App\Models\AssessmentProgress;
use App\Models\Category;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use App\Models\RemainingMinutes;
use App\Models\StudentAnswer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AssessmentsController extends Controller
{

    public function take_assessment(){

        $checkIfDone = StudentAnswer::where('user_id',auth()->user()->id)->first();
        if($checkIfDone){
            return  redirect()->route('student.view_assessment_results',$checkIfDone->id)->with('error','Exam Already Taken. Please see your results.');
        }



        $categories = Category::get()->keyBy('id');
        $exam = Exam::first();
        if(!$exam){
            return redirect()->back()->with('error','There is no available exam at the moment');
        }

        $assessmentProgress = AssessmentProgress::where('user_id',auth()->user()->id)->where('exam_id',$exam->id)->first();
        $assessmentProgressAnswers = null;
        if($assessmentProgress){
            $assessmentProgressAnswers = json_decode($assessmentProgress->answers,true);
        }


        $questions = Question::where('exam_id',$exam->id)->with('category')->with(['answers'=>function($answerQuery){
            $answerQuery->inRandomOrder();
        }])->get();

        return view('student.assessments.take_assessment',compact('exam','categories','questions','assessmentProgress','assessmentProgressAnswers'));
    }


    public function submitAssessment(Request $request){
        $question_ids = $request->question_ids;



        $q_and_q_array = [];
        foreach($question_ids as $q){
            if($request->has('qid_'.$q.'_ans')){
                $q_and_q_array[$q] = $request->get('qid_'.$q.'_ans');
            }else{
                $q_and_q_array[$q] = null;
            }
        }

        $studentAnswer = new StudentAnswer();
        $studentAnswer->user_id = auth()->user()->id;
        $studentAnswer->answers = json_encode($q_and_q_array);
        $studentAnswer->exam_id = $request->exam_id;
        if($studentAnswer->save()){
            return redirect()->route('student.view_assessment_results',$studentAnswer->id);
        }
    }


    public function saveAssessmentProgress(Request $request){
        $question_ids = $request->question_ids;

        $q_and_q_array = [];
        foreach($question_ids as $q){
            if($request->has('qid_'.$q.'_ans')){
                $q_and_q_array[$q] = $request->get('qid_'.$q.'_ans');
            }else{
                $q_and_q_array[$q] = null;
            }
        }
        $studentAnswer = AssessmentProgress::where('user_id',auth()->user()->id)->where('exam_id',$request->exam_id)->first();
        if(!$studentAnswer){
            $studentAnswer = new AssessmentProgress();
        }
        $studentAnswer->user_id = auth()->user()->id;
        $studentAnswer->answers = json_encode($q_and_q_array);
        $studentAnswer->exam_id = $request->exam_id;
        if($studentAnswer->save()){
           return ['status'=>'saved'];
        }
    }


    public function viewAssessmentResults($id){
        $assessmentResults = StudentAnswer::findOrFail($id);

        $studentAnswers = json_decode($assessmentResults->answers,true);

        $categories = Category::get()->keyBy('id');
        $exam = Exam::where('id',$assessmentResults->exam_id)->first();

        $questions = Question::where('exam_id',$exam->id)->with(['answers'=>function($answerQuery){
            $answerQuery->inRandomOrder();
        }])->get()->groupBy('category_id');

        $courses = Course::get()->keyBy('id');


        return view('student.assessments.view_results',compact('exam','categories','questions','studentAnswers','courses'));
    }


}
