{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.master-student ')
@section('title', '| Users')
@push('styles')
    <link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        p[data-f-id="pbf"]{
            display: none;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header pb-2 row">
            <div class="col-6">
                <h3> Course List</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Course List</li>
                    </ol>
                </nav>
            </div>

        </div>
        <div class="content-body height-100 p-4">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="coursesTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Course Name</th>
                            <th>Course Code</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($courses as $course)
                            <tr id="row{{$course->id}}">
                                <td><a href="{{route('student.view_course_details',$course->id)}}">{{ $course->course_name }}</a></td>
                                <td>{{ $course->course_code }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let dataTable;

        $(document).ready(function() {
            dataTable = $('#coursesTable').DataTable({
                language: { search: '', searchPlaceholder: "Search..." },
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });

        $(document).on( "click", ".action-icon.delete", function() {
            let dataID = $(this).attr('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteCourse'+dataID).submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });

        $(document).on( "submit", ".delete-form", function(e) {
            e.preventDefault();
            var form = $(this);
            var actionUrl = form.attr('action');
            let dataID = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    dataTable.row( $('#row'+dataID) )
                        .remove()
                        .draw();
                }
            });
        });
    </script>
@endpush

