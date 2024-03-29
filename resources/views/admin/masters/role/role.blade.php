@extends('admin.layout.master')
@section('content')
@section('Master', 'active')
@section('Collapse', 'show')
@section('Role', 'active')
@section('title', 'Master Role')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Role Tables </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="add-certificate">
                            <a class="nav-link btn create-new-button" style="width: fit-content;" id="addRole" data-toggle="dropdown" aria-expanded="false" 
                            {{ (session('role') == 3 || session('role') == 2 || $count == 4) ? 'hidden' : ''}}>+ Create Role</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" style="text-align: center;">
                                <thead>
                                    <tr>
                                        <th>ACTION</th>
                                        <th>NAME</th>
                                        <th>STATUS</th>
                                        <th>AUTHORIZATION</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ACTION</th>
                                        <th>Name</th>
                                        <th>STATUS</th>
                                        <th>AUTHORIZATION</th>
                                    </tr>
                                </tfoot>
                                @foreach($data as $role)
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="display: flex; justify-content: center;">
                                                <button class="btn btn-primary actBtn" {{ session('role') == 3 ? 'hidden' : ''}} title="Edit" id="update" onclick="updRole({{$role->id}})">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger actBtn" {{ (session('role') == 3 || session('role') == 2) ? 'hidden' : ''}} title="Hapus" onclick="delRole({{$role->id}})">
                                                    <i class="mdi mdi-delete-forever"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>{{$role->name}}</td>
                                        <td>
                                            <div class="dropdown {{ session('role') == 3 ? 'disabled' : ''}}">
                                                <button class="btn {{ $role->status == 'Active' ? 'btn-success' : 'btn-danger' }} dropdown-toggle actBtn" type="button" id="status"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{$role->status}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="status" id="myDropdown">
                                                    <button class="dropdown-item" type="button" data-value="active" onclick="changeStatus('Active', '{{$role->id}}')">Active</button>
                                                    <div class="dropdown-divider"></div>
                                                    <button class="dropdown-item" type="button" data-value="draft" onclick="changeStatus('Inactive', '{{$role->id}}')">Inactive</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>@if($role->authorization == 1)
                                            Super Admin
                                            @elseif($role->authorization == 2)
                                            Admin
                                            @elseif($role->authorization == 3)
                                            Sales
                                            @elseif($role->authorization == 4)
                                            Operation
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    {{ $data->appends(Request::all())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function changeStatus(status, id) {
        Swal.fire({
            title: 'Are you sure you want to change the certificate status?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Change'
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.isConfirmed) {
                    axios.post('/role/changeStatus/' + id, {
                            status,
                        }).then(() => {
                            Swal.fire({
                                title: 'Success',
                                position: 'top-end',
                                icon: 'success',
                                text: 'Status Changed!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1600);
                        })
                        .catch((err) => {
                            Swal.fire({
                                title: 'Error',
                                position: 'top-end',
                                icon: 'error',
                                text: err,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                }
            }
        })
    };

    $("#modalCloseSM").click(function() {
        $('#modalSmall').modal('hide');
    })

    $('#addRole').click(function() {
        axios.get('/role/create')
            .then(function(response) {
                $('.modal-title').html("Add New Role");
                $(".modal-dialog").removeClass("modal-xl").addClass("modal-md");
                $('.modal-body').html(response.data);
                $('#myModal').modal('show');
            })
            .catch(function(error) {
                console.log(error);
            });
    })

    function updRole(id) {
        axios.get('/role/getUpdate/' + id)
            .then(function(response) {
                $('.modal-title').html("Update Role");
                $(".modal-dialog").removeClass("modal-xl").addClass("modal-md");
                $('.modal-body').html(response.data);
                $('#myModal').modal('show');
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    function delRole(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "The deleted data cannot be recovered!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancle',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/role/delete/' + id)
                    .then(() => {
                        Swal.fire({
                            title: 'Success',
                            position: 'top-end',
                            icon: 'success',
                            text: 'Data deleted successfuly!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1600);
                    })
                    .catch((err) => {
                        Swal.fire({
                            title: 'Error',
                            position: 'top-end',
                            icon: 'error',
                            text: err,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
            }
        });
    }

    $("#modalClose").click(function() {
        $('#myModal').modal('hide');
    })
</script>

@endsection