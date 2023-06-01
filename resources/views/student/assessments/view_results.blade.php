{{-- \resources\views\exams\index.blade.php --}}
@extends('layouts.master-student')
@section('title', '| Assessments')
@push('styles')
    <link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        a[title="Froala Editor"]{
            display: none;
        }
        p[data-f-id="pbf"]{
            display: none;
        }
        body{
            margin-top:40px;
        }
        #chart {
            max-width: 650px;
            margin: 35px auto;
        }
        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }
        .btn-step-nav{
            width: 300px;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }
        .form-check-label > p{
            margin-bottom: 0px!important;
        }
        .correct-answer{
            background: rgb(76, 154, 42, 0.7);
        }
        .answer-legend{
            width: 25px;
            height: 12px;
            display: inline-block;
            margin-right: 10px;
        }
        .answer.green{
            background: rgb(76, 154, 42, 0.7);
        }
        .answer.red{
            background: rgb(255,0, 0.7);
        }
        .answer.yellow{
            background: rgb(255,255, 0.7);
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper ">
        <div class="content-header pb-2 row">
            <div class="col-6">
                    <h3> View Assessment Results </h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Assessment Results</li>
                    </ol>
                </nav>
            </div>

        </div>
        <div class="content-body height-100 p-4">
            @include('layouts.flash-message')
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    @foreach($categories as $key => $category)
                        <div class="stepwizard-step">
                            <a href="#step-{{$key}}" type="button" class="btn {{($loop->first?'btn-primary':'btn-light')}} btn-step-nav">{{$category->category_name}}</a>
                        </div>
                    @endforeach
                    <div class="stepwizard-step">
                        <a href="#step-summary" type="button" class="btn  btn-step-nav">Exam Results Summary</a>
                    </div>
                </div>
            </div>


            @csrf
            @php
                $correctCourses = [];
                $correctAnswersPerCategoryArr = [];
                $incorrectAnswersPerCategoryArr = [];
            @endphp
            @foreach($categories as $key => $category)
                <div class="row setup-content" id="step-{{$key}}">
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <h3 style="margin: 25px 0px;"> {{$category->category_name}}</h3>
                            <div class="row">
                                <div class="col-6">
                                    <div><span class="answer-legend answer green" style=" "></span>Correct Answer</div>
                                    <div><span class="answer-legend answer red"></span>Wrong Answer</div>
                                    <div><span class="answer-legend answer yellow"></span>Corrected Answer</div>
                                </div>

                                <div class="col-6 result-box-container">

                                </div>
                            </div>

                            @if(isset($questions[$key] ))
                                @php
                                    $totalQuestions = 0;
                                    $correctAnswers = 0;

                                @endphp
                                @foreach($questions[$key] as $questionNo => $question)
                                    @php
                                        $totalQuestions++;
                                    @endphp
                                    <div class="" style="display: inline-block; width: 25px;  vertical-align: top;"> <span>{{$questionNo+1}}.</span></div>
                                    <div class="" style="display: inline-block; width: calc(100% - 30px)">
                                        <div class="question-container">

                                            {!! $question->question  !!}
                                        </div>
                                    </div>
                                    <input type="hidden" name="question_ids[]" value="{{$question->id}}">
                                    @foreach($question->answers as $answer)
                                        @if($answer->answer!=='<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>')
                                        <div class="form-check">
                                            @php
                                                $className = '';
                                                if(isset($studentAnswers[$question->id])){
                                                    if($studentAnswers[$question->id] == $answer->id && $answer->correct == 0){
                                                         $className = 'red';
                                                    }else if($studentAnswers[$question->id] == $answer->id && $answer->correct == 1){
                                                         $correctCourses = array_merge(json_decode($question->course_ids,true),$correctCourses);
                                                         $className = 'green';
                                                         $correctAnswers++;
                                                    }else if($studentAnswers[$question->id] != $answer->id && $answer->correct == 1){
                                                          $className = 'yellow';
                                                    }else{
                                                         $className = '';
                                                    }
                                                }
                                            @endphp
                                            <label class="form-check-label answer {{$className}}" for="q_ans1">
                                                {!! $answer->answer !!}
                                            </label>
                                        </div>
                                        @endif
                                    @endforeach

                                @endforeach
                                @php
                                    $correctPercentate = $correctAnswers/$totalQuestions * 100;
                                @endphp
                                @php
                                    $correctAnswersPerCategoryArr[]= $totalQuestions - $correctAnswers;
                                    $incorrectAnswersPerCategoryArr[]= $correctAnswers;
                                @endphp

                                <div class="result-box">
                                    <p>Score: {{$correctAnswers.'/'.$totalQuestions}}</p>
                                    <p>{{number_format($correctPercentate,2)}}%</p>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            @endforeach
            <div class="row setup-content" id="step-summary">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <h3> Exam Results Summary</h3>

                        <div class="row">
                            <div class="col-8 result-box-container">
                                <div id="chart">
                                </div>
                                @php
                                    $array = $correctCourses;
                                    $values = array_count_values($array);
                                    arsort($values);
                                    $recommendedCourses = array_slice(array_keys($values), 0, 5, true);
                                @endphp

                            </div>
                            <div class="col-sm-3">
                                <h3>Recommended Courses</h3>
                                <ol type="1">
                                    @php
                                        $recommendedCount = 0;
                                    @endphp
                                    @foreach($recommendedCourses as $courseID)
                                        @php
                                            $recommendedCount++
                                        @endphp
                                        @if($recommendedCount<3)
                                            @if(isset($courses[$courseID]))
                                                <li><a href="{{route('student.view_course_details',$courseID)}}">{{$courses[$courseID]['course_name']}}</a></li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden"  id="categoriesArr"  value="{{json_encode($categories->pluck('category_name')->toArray())}}">
    <input type="hidden" id="correctAnswersPerCategoryArr" value="{{json_encode($correctAnswersPerCategoryArr)}}">
    <input type="hidden" id="incorrectAnswersPerCategoryArr" value="{{json_encode($incorrectAnswersPerCategoryArr)}}">
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>

        $(document).ready(function () {
            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn');

            allWells.hide();

            navListItems.click(function (e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-light');
                    $item.removeClass('btn-light').addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });
            $('div.setup-panel div a.btn-primary').trigger('click');


            $( ".result-box" ).each(function( index ) {

                $(this).appendTo($(this).parent().find('.result-box-container'));
            });



            var correctAnswersPerCategoryArr = JSON.parse($('#correctAnswersPerCategoryArr').val());
            var incorrectAnswersPerCategoryArr = JSON.parse($('#incorrectAnswersPerCategoryArr').val());
            var categoriesArr = JSON.parse($('#categoriesArr').val());
            var options = {
                series: [ {
                    name: 'CORRECT ANSWERS',
                    data: incorrectAnswersPerCategoryArr
                },
                    {
                        name: 'INCORRECT ANSWERS',
                        data: correctAnswersPerCategoryArr
                    }],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                    stackType: '100%'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                xaxis: {
                    categories: categoriesArr,
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'right',
                    offsetX: 0,
                    offsetY: 50
                },
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();


        });
    </script>
@endpush
