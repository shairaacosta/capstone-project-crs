{{-- \resources\views\exams\index.blade.php --}}
@extends('layouts.master-admin ')
@section('title', '| Exams')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/css/froala_editor.min.css" integrity="sha512-OWgUOD+dAnc7yKSvG/f6AQlg/7R5b1iMXN7GeUuIwq0IabLcjNKEuu/4REC7gZeRkdE678X7f7ktHu/7VvDUUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/plugins/table.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/css/froala_style.min.css" integrity="sha512-5sBxSzKqzQ0oQ7a77zRHMaclC5XQRIW2YT+X1bOoahMcM5Eo4L5MzI6eTxV/YTRgjTdn94jptURazpVfKFIZGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <div class="content-wrapper ">
        <div class="content-header pb-2 row">
            <div class="col-6">
                <h3> Edit Exam</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('exams.index')}}">Exam Management</a></li>
                        <li class="breadcrumb-item active">Edit Exam</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">
            </div>
        </div>
        <div class="content-body height-100 p-4">
            <div class="col-lg-12">
                <h3>Exam Details</h3>
                <hr>
                <form action="{{route('exams.update',$exam->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row g-3">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="exam_name" value="{{$exam->exam_name}}" placeholder="Exam" aria-label="State">
                        </div>
{{--                        <div class="col-sm-3">--}}
{{--                            <input type="text" class="form-control" name="time_limit" value="{{$exam->time_limit}}" placeholder="Exam" aria-label="State">--}}
{{--                        </div>--}}
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrow-right-long"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/js/froala_editor.min.js" integrity="sha512-LU+esJH+70iLCKGXb7n1krkNcBrCJGU89N5Etfm1Ur2O6LYObElInmc4zCtWWyFWLy2irA65IaSfuYdUaxn9EA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/plugins/table.min.js"></script>
    <script>
        $(document).ready(function() {
            var editor = new FroalaEditor('#example', {
                // Define new table cell styles.
                attribution: false,
                tableCellStyles: {
                    class1: 'Class 1',
                    class2: 'Class 2'
                }
            });
        });
    </script>
@endpush
