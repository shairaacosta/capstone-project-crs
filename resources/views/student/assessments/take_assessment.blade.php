{{-- \resources\views\exams\index.blade.php --}}
@extends('layouts.master-student')
@section('title', '| Assessments')
@push('styles')
    <link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        .step-answered{
            background: #198754!important;
            color: #fff;
        }
        a[title="Froala Editor"]{
            display: none;
        }
        p[data-f-id="pbf"]{
            display: none;
        }
        body{
            margin-top:40px;
        }

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            width: 100%;
            display: block;
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
            width: 40px;
            font-size: 11px;
            padding: 0px;
        }

        .stepwizard-step {
            display: inline-block;
            text-align: center;
            position: relative;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper ">
        <div class="content-header pb-2 row">
            <div class="col-6">
                <h3> Take Assessment</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Take Assessment</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                {{--                <h4 style="float: right; margin: 10px 0px;--}}
                {{--                    background: #ccc;--}}
                {{--                    display: inline-block;--}}
                {{--                    padding: 12px;--}}
                {{--                    border-radius: 12px;">TIMER: <span id="timer" style="color: red;">00h 00m 00s</span></h4>--}}
            </div>
        </div>
        <div class="content-body height-100 p-4">

            <div class="stepwizard">
                <div class="stepwizard-row setup-panel" style="">
                    @foreach($questions as $questionNo => $question)
                        <div class="stepwizard-step">
                            <a href="#step-{{$questionNo+1}}"  type="button" class="btn {{($loop->first?'btn-primary':'btn-light')}} step-{{$questionNo+1}}  {{(isset($assessmentProgressAnswers[$question->id])?((int)$assessmentProgressAnswers[$question->id] !== null?'step-answered':''):'' ) }} btn-step-nav">{{$questionNo+1}}</a>
                        </div>
                    @endforeach
                </div>
            </div>

            <form action="{{route('student.submit_assessment')}}"  id="assessmentForm" method="post">
                @csrf
                <input type="hidden" id="remaining_hours" name="remaining_hours">
                <input type="hidden" id="remaining_minutes" name="remaining_minutes">
                <input type="hidden" id="remaining_seconds" name="remaining_seconds">
                <input type="hidden" name="exam_id" value="{{$exam->id}}">

                @foreach($questions as $questionNo => $question)
                    <div class="row setup-content" id="step-{{$questionNo+1}}">
                        <div class="col-xs-12">
                            <div class="col-md-12">
                                <hr style="border-top:2px dashed #ccc;">
                                <h3 style="margin: 25px 0px;"> {{$question->category->category_name}}</h3>
                                <hr style="border-top:2px dashed #ccc;">

                                <div class="" style="display: inline-block; width: 25px;  vertical-align: top;"> <span>{{$questionNo+1}}.</span></div>
                                <div class="" style="display: inline-block; width: calc(100% - 30px)">
                                    <div class="question-container">
                                        {!! $question->question  !!}
                                    </div>
                                </div>
                                <input type="hidden" name="question_ids[]" value="{{$question->id}}">
                                @foreach($question->answers as $key => $answer)
                                    @if($answer->answer!=='<p data-f-id="pbf" style="text-align: center; font-size: 14px; margin-top: 30px; opacity: 0.65; font-family: sans-serif;">Powered by <a href="https://www.froala.com/wysiwyg-editor?pb=1" title="Froala Editor">Froala Editor</a></p>')
                                        <div class="form-check">
                                            <input class="form-check-input ans-radio" data-step="step-{{$questionNo+1}}" type="radio" {{(isset($assessmentProgressAnswers[$question->id])?((int)$assessmentProgressAnswers[$question->id] === $answer->id?'checked':''):'' ) }} name="qid_{{$question->id}}_ans" value="{{$answer->id}}" id="q_ans{{$key.$question->id}}">
                                            <label class="form-check-label" for="q_ans{{$key.$question->id}}">
                                                {!! $answer->answer !!}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                                @if(!$loop->first)
                                    <button class="btn btn-primary prevBtn btn-md float-start" type="button" ><i class='bx bx-chevron-left'></i> Previous</button>
                                @endif
                                @if(!$loop->last)
                                    <button class="btn btn-primary nextBtn btn-md float-end" type="button" >Next <i class='bx bx-chevron-right'></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <br>
                <div class="text-center">
                <button class="btn btn-block btn-success btn-md" type="submit">Submit Answers</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Set the date we're counting down to
        var remaining_minutes;
        function countdownTimeStart(){

            var endTime = '{{now()->addHours($assessmentProgress?$assessmentProgress->remaining_hours:0)->addMinutes(($assessmentProgress?$assessmentProgress->remaining_minutes:$exam->time_limit))->addSeconds(($assessmentProgress?$assessmentProgress->remaining_seconds:0))->format('Y-m-d H:i:s')}}';

            var countDownDate = new Date(endTime).getTime();

// Update the count down every 1 second
            var x = setInterval(function() {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                remaining_minutes = minutes;
                // Output the result in an element with id="demo"
                document.getElementById("timer").innerHTML = hours + "h "
                    + minutes + "m " + seconds + "s ";
                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("timer").innerHTML = "EXPIRED";
                }
                // $('#remaining_hours').val(hours);
                // $('#remaining_minutes').val(minutes);
                // $('#remaining_seconds').val(seconds);
                if(seconds % 30 === 0){
                    saveProgress();
                }

                if(minutes === 0 && seconds === 30){
                    Swal.fire(
                        'Ooops!',
                        'Time is almost up, you have 30 seconds to save your assessment or the system will automatically submit your assessment',
                        'warning'
                    )
                    var assessmentForm = $('#assessmentForm');
                    setInterval(function() {
                        $.ajax({
                            type: "POST",
                            url: '{{route('student.submit_assessment')}}',
                            data: assessmentForm.serialize(), // serializes the form's elements.
                            success: function(data){
                                // Swal.fire(
                                //     'Ooops!',
                                //     'Time is up, your assessment is auto-saved. Please wait for your results after this page reloads.',
                                //     'success'
                                // )
                                // setInterval(function() {
                                //     location.reload();
                                // },2500);
                            }
                        });
                    },30500)
                }


            }, 1000);
        }

        function saveProgress(){
            var assessmentForm = $('#assessmentForm');
            $.ajax({
                type: "POST",
                url: '{{route('student.save_assessment_progress')}}',
                data: assessmentForm.serialize(), // serializes the form's elements.
                success: function(data){
                    console.log(data); // show response from the php script.
                }
            });
        }

        $(document).on('click','.ans-radio',function (){
            saveProgress();
            var step = $(this).attr('data-step');
            $('.'+step).addClass('step-answered').removeClass('btn-primary');
        });




        $(document).ready(function () {
            countdownTimeStart();

            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn'),
            allPrevBtn = $('.prevBtn');

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

            allNextBtn.click(function(){

                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='radio'],input[type='url']"),
                    isValid = true;

                $(".form-group").removeClass("has-error");
                for(var i=0; i<curInputs.length; i++){
                    if (!curInputs[i].validity.valid){
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid)
                    nextStepWizard.removeAttr('disabled').trigger('click');
                else
                    Swal.fire(
                        'Ooops!',
                        'Please make sure you answer all the questions.',
                        'error'
                    )
            });


            allPrevBtn.click(function(){

                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='radio'],input[type='url']"),
                    isValid = true;

                $(".form-group").removeClass("has-error");
                for(var i=0; i<curInputs.length; i++){
                    if (!curInputs[i].validity.valid){
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid)
                    nextStepWizard.removeAttr('disabled').trigger('click');
                else
                    Swal.fire(
                        'Ooops!',
                        'Please make sure you answer all the questions.',
                        'error'
                    )
            });

            $('div.setup-panel div a.btn-primary').trigger('click');
        });
    </script>
@endpush
