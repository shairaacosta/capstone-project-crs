{{-- \resources\views\exams\index.blade.php --}}
@extends('layouts.master-admin ')
@section('title', '| Questions')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/css/froala_editor.min.css" integrity="sha512-OWgUOD+dAnc7yKSvG/f6AQlg/7R5b1iMXN7GeUuIwq0IabLcjNKEuu/4REC7gZeRkdE678X7f7ktHu/7VvDUUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/plugins/table.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/css/froala_style.min.css" integrity="sha512-5sBxSzKqzQ0oQ7a77zRHMaclC5XQRIW2YT+X1bOoahMcM5Eo4L5MzI6eTxV/YTRgjTdn94jptURazpVfKFIZGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--multiple{
            min-height: 38px!important;
        }
        .fr-wrapper > div:not(.fr-element){
            display: none!important;
        }
        .form-check{
            border-top: 1px solid #ccc;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-radius: 10px 10px 0px 0px;
            -webkit-border-radius: 10px 10px 0px 0px;
            margin-bottom: 0;
            margin-top: 20px;
        }
        .fr-toolbar.fr-top{
            border-radius: 0px;
            -webkit-border-radius: 0px;
        }
        .ans-radio{
            margin-left: 0px!important;
            margin-right: 5px!important;
        }
        .orig-q-and-a-container{
            display: none;
        }
        .q-and-a-container{
            margin-bottom: 15px;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper ">
        <div class="content-header pb-2 row">
            <div class="col-6">
                <h3> Add Questions</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('questions.index')}}">Questionnaire Management</a></li>
                        <li class="breadcrumb-item active">Add Questions</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">
            </div>
        </div>
        <div class="content-body height-100 p-4">
            <div class="col-lg-12">
                <h3>Question Details</h3>
                <hr>
                @include('layouts.flash-message')
                <form action="{{route('questions.store')}}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-3">
                            <select class="form-select" name="exam_id" aria-label="Default select exams">
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->exam_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-select" name="category_id" aria-label="Default select categories">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-select select2" name="course_ids[]" aria-label="Default select  course" multiple>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="question-and-answers-container">
                            <div class="q-and-a-container">
                                <div class="row">
                                    <div class="col-6">
                                        <h4>Question </h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea id="example" name="question"></textarea>
                                    </div>
                                    <h5 class="mt-2">Answers</h5>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input ans-radio" type="radio" name="correct_answer_key" value="0" id="q_ans1">
                                            <label class="form-check-label" for="q_ans1">
                                                Correct Answer
                                            </label>
                                        </div>
                                        <textarea id="example" name="q_answer[]"></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input ans-radio" type="radio" name="correct_answer_key"  value="1" id="q_ans2">
                                            <label class="form-check-label" for="q_ans2">
                                                Correct Answer
                                            </label>
                                        </div>
                                        <textarea id="example" name="q_answer[]"></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input ans-radio" type="radio" name="correct_answer_key" value="2" id="q_ans3">
                                            <label class="form-check-label" for="q_ans3">
                                                Correct Answer
                                            </label>
                                        </div>
                                        <textarea id="example" name="q_answer[]"></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input ans-radio" type="radio" name="correct_answer_key" value="3" id="q_ans4">
                                            <label class="form-check-label" for="q_ans4">
                                                Correct Answer
                                            </label>
                                        </div>
                                        <textarea id="example" name="q_answer[]"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success add-question"><i class="fa-solid fa-plus"></i> Submit Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/js/froala_editor.min.js" integrity="sha512-LU+esJH+70iLCKGXb7n1krkNcBrCJGU89N5Etfm1Ur2O6LYObElInmc4zCtWWyFWLy2irA65IaSfuYdUaxn9EA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/plugins/table.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.select2').select2({
                'placeholder':'Select 3 Courses',
                'maximumSelectionLength':3,
            });
            var editor = new FroalaEditor('#example', {
                // Define new table cell styles.
                attribution: false,
                tableCellStyles: {
                    class1: 'Class 1',
                    class2: 'Class 2'
                }
            });
            $('#example').html('');
        });
    </script>
@endpush
