{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.master-student')
@section('title', '| Change Password')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/css/froala_editor.min.css" integrity="sha512-OWgUOD+dAnc7yKSvG/f6AQlg/7R5b1iMXN7GeUuIwq0IabLcjNKEuu/4REC7gZeRkdE678X7f7ktHu/7VvDUUA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/plugins/table.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/4.0.9/css/froala_style.min.css" integrity="sha512-5sBxSzKqzQ0oQ7a77zRHMaclC5XQRIW2YT+X1bOoahMcM5Eo4L5MzI6eTxV/YTRgjTdn94jptURazpVfKFIZGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="content-wrapper ">
        <div class="content-header pb-2 row">
            <div class="col-6">
                <h3>Change Password</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><a href="">Change Password</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">
            </div>
        </div>
        <div class="content-body height-100 p-4">
            <div class="col-lg-12">
                <h3>Change Password</h3>
                <hr>
                @include('layouts.flash-message')
                <form action="{{route('student.store_new_password')}}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" aria-label="Confirm">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrow-right-long"></i> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

