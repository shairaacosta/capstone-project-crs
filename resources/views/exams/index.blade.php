{{-- \resources\views\exams\index.blade.php --}}
@extends('layouts.master-admin')
@section('title', '| Exams')
@push('styles')
    <link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush
@section('content')
    <div class="content-wrapper ">
        <div class="content-header pb-2 row">
            <div class="col-6">
                <h3> Exam Management</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Exam Management</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">
                <a href="{{route('exams.create')}}" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Add Exam</a>
            </div>
        </div>
        <div class="content-body height-100 p-4">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="examsTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Examination</th>
{{--                            <th>Exam Duration</th>--}}
                            <th>Created At</th>
                            <th class="no-sort text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($exams as $exam)
                            <tr id="row{{$exam->id}}">
                                <td>{{ $exam->exam_name }}</td>
{{--                                <td>{{ $exam->time_limit }} minutes</td>--}}
                                <td>{{ $exam->created_at->format('F d, Y h:ia') }}</td>
                                <td class="text-center">
                                    <a title="Edit" class="action-icon edit" href="{{ route('exams.edit', $exam->id) }}"><i class='bx bx-edit-alt'></i></a>
                                    <a title="Delete" data-id="{{$exam->id}}" class="action-icon delete" href="javascript:void(0);"><i class='bx bx-trash'></i></a>
                                    {!! Form::open(['method' => 'DELETE','id'=>'deleteExam'.$exam->id,'data-id'=>$exam->id,'class'=>'delete-form', 'route' => ['exams.destroy', $exam->id] ]) !!}
                                    {!! Form::close() !!}
                                </td>
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
             dataTable = $('#examsTable').DataTable({
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
                    $('#deleteExam'+dataID).submit();
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
                    console.log('#row'+dataID);
                    dataTable.row( $('#row'+dataID) )
                        .remove()
                        .draw();
                }
            });
        });
    </script>
@endpush
