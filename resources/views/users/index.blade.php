{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.master-admin ')
@section('title', '| Users')
@push('styles')
    <link rel="stylesheet" type="text/css"  href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush
@section('content')
    <div class="content-wrapper">
        <div class="content-header pb-2 row">
            <div class="col-6">
                <h3> User Management</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
                        <li class="breadcrumb-item active">User Management</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6 d-flex align-items-center justify-content-end">
                <a href="{{route('users.create')}}" class="btn btn-outline-primary m-lg-1" role="button"><i class="fa-solid fa-plus"></i> Add User</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importUsersModal">
                    <i class="fa-solid fa-upload"></i> Import Users
                </button>
            </div>

            <div class="content-body height-100 p-4">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date/Time Added</th>
                                <th>User Roles</th>
                                <th class="no-sort text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr id="row{{$user->id}}">
                                    <td class="text-capitalize">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td data-sort="{{$user->created_at}}">{{ $user->created_at->format('F d, Y h:ia') }}</td>
                                    <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>
                                    <td class="text-center">
                                        <a title="Edit" class="action-icon edit" href="{{ route('users.edit', $user->id) }}"><i class='bx bx-edit-alt'></i></a>
                                        <a title="Delete" data-id="{{$user->id}}" class="action-icon delete" href="javascript:void(0);"><i class='bx bx-trash'></i></a>
                                        {!! Form::open(['method' => 'DELETE','id'=>'deleteUser'.$user->id,'data-id'=>$user->id,'class'=>'delete-form', 'route' => ['users.destroy',$user->id] ]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach


                            {{--                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>--}}
                            {{--                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}--}}
                            {{--                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}--}}
                            {{--                            {!! Form::close() !!}--}}
                            {{--                        </td>--}}
                            {{--                    </tr>--}}
                            {{--                @endforeach--}}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="importUsersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('import-users')}}" method="POST" id="fileImportForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Users</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <a class="btn btn-success btn-sm" style="margin-bottom: 5px;" href="{{route('export-users-template')}}"><i class="fa fa-download"></i> Download Template</a>
                            <div class="d-flex">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                    <label class="custom-file-label" for="customFile"><span>Choose file</span></label>
                                </div>
                            </div>

                            <div id="progress_status" style="padding-bottom: 5px;">
                            </div>
                            <div class="progress" style="display: none">
                                <div id="upload_progress" class="progress-bar bg-success progress-bar-striped progress-bar-animated active" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
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

        function progressBarStatus(Text,Percent=100,Active=false,DivClass="") {
            $('.progress').show();
            $("#upload_progress").width(parseFloat(Percent).toFixed(2) + "%");
            $("#upload_progress").html(parseFloat(Percent).toFixed(2) + "%");
            $("#upload_progress").removeClass('active');
            if (Active) {
                $("#upload_progress").addClass('active');
            }
            $("#progress_status").removeClass().html(Text);
            if (DivClass != "") {
                $("#progress_status").addClass(DivClass);
            }

        }

        $(document).on('submit','#fileImportForm',function(e){
            e.preventDefault();

            var formData = new FormData();
            formData.append('file', $("input[name='file']").prop('files')[0]);
            formData.append('_token','{{csrf_token()}}');
            var formAction = $( this ).attr('action');
            $.ajax({
                url: formAction,
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                cache: false,
                xhr: function() {  // custom xhr
                    myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // check if upload property exists
                        myXhr.upload.addEventListener('progress',
                            function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete;
                                    percentComplete = (evt.loaded / evt.total) * 100;

                                    if (percentComplete > 5 ) {
                                        progressBarStatus("Uploading Files. This might take sometime...",percentComplete,true);
                                    } else if (percentComplete < 75) {
                                        progressBarStatus("Finalizing things...",percentComplete,true);
                                    } else {
                                        progressBarStatus("Uploading files. Please do not close this tab",percentComplete,true);
                                    }

                                    // percentComplete = (evt.loaded / evt.total) * 30;

                                    // percentComplete = (evt.loaded / evt.total) * 20;

                                }
                            }, false); // for handling the progress of the upload
                    }
                    return myXhr;
                },
                error: function (object, string, error) {
                    alert(object.message);
                },
                success: function (data){
                    location.reload();
                }

            });
        });





        let dataTable;

        $(document).ready(function() {
            dataTable = $('#usersTable').DataTable({
                language: { search: '', searchPlaceholder: "Search..." },
                "columnDefs": [ {
                    "targets": 'no-sort',
                    "orderable": false,
                } ],
                "order": [[ 2, "desc" ]],
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


                    $('#deleteUser'+dataID).submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });

        $(document).on( "submit", ".btn btn-danger", function(e) {
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

