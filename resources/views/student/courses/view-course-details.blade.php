@extends('layouts.master-student')
@section('title', '| Assessments')
@push('styles')
    <link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
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
                <h3> Course Details Assessment</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Course List</li>
                        <li class="breadcrumb-item active">View Course</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="content-body height-100 p-4">
            <div class="col-sm-12">
              <p style=" background:gainsboro; border-radius: 8px;
    padding: 10px;
    text-align: center;"><b>{{$course->course_name}}</b></p>
            </div>
            <div class="col-sm-12" >
                <div style="box-shadow: 0 2px 10px rgb(0 0 0 / 10%), 3px 5px 20px rgb(0 0 0 / 20%);  border-radius: 5px; padding: 15px;">
                    <h3 style="padding: 5px 15px; border-radius: 5px;
    display: inline-block;
    background: #0d6efd!important;
    color: #fff; margin-bottom: 0px;!important;">COURSE</h3> <br>

                    <h3 style="padding: 5px 15px; border-radius: 5px;
    display: inline-block;
    background: #808080!important;
    color: #fff;"><b>DESCRIPTION</b>
                    </h3>

                    <hr style="border-top: 3px dashed gray; background-color: transparent; ">
                    {!! $course->course_description !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')

@endpush
