@extends('layouts.master-student')
@section('content')
    <h4>Welcome {{auth()->user()->name}},</h4>
    <div class="card">
        <div class="card-header">
            Course Recommendation
        </div>
        <div class="card-body">
            <h5 class="card-title">Hi there!</h5>
            <p class="card-text">This Course Recommendation System will help you determine the courses that fits you based on your skills and knowledge by taking an assessment just like the National Career Assessment Examination. The examination has four categories which are, General Education, English, Mathematics and General Science. You can only answer it once. Thus, the examination is not time limited so you can take time answering the examination with full honesty. You can view the results after submitting your examination.</p>
            <p>Click the Take Assessment below if you wish to start. Goodluck!</p>
            <a href="{{route('student.take_assessment')}}" class="btn btn-primary">Take Assessment</a>
        </div>
    </div>
@endsection
