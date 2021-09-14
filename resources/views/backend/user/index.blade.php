@extends('backend.layouts.app')
@section('title','Admin User List')
@section('home user active','mm-active');
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>User List View</div>
        </div>
    </div>
</div>
<div class="pt-3">
    <a href="{{ route('admin.user.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle">Create User</i></a>
</div>
<div class="content pt-3">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="app">
                <thead>
                    <tr class="bg-light">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>IP</th>
                        <th>User Agent</th>
                        <th>Login_at</th>
                        <th>Created_at</th>
                        <th>Updated_at</th>
                        <th class="no-sort-search">Action</th>
                    </tr>
                </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table =$('#app').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "/admin/user/datatable/ssd",
            "columns":[
                {
                    data: "name",
                    name: "name"
                },
                {
                    data: "email",
                    name: "email",
                },
                {
                    data: "phone",
                    name: "phone"
                },
                {
                    data: "ip",
                    name: "ip"
                },
                {
                    data: "login_at",
                    name: "login_at"
                },
                {
                    //one way column editing
                    data: "user_agent",
                    name: "user_agent",
                    sortable : false,
                    searchable : false
                },
                {
                    data: "created_at",
                    name: "created_at",
                },
                {
                    data: "updated_at",
                    name: "updated_at",
                },
                {
                    data: "action",
                    name: "action",
                }

            ],
            order: [
                [7, 'desc']
            ],
            //two way column editing
            "columnDefs": [{
            "targets": 3,
            "sortable": false,
            "searchable": false
            }],
            //three way column  editing
            "columnDefs": [{
            "targets": "no-sort-search",
            "sortable": false
            }]
        });
    $(document).on('click','.delete',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        //sweetalert2
        Swal.fire({
        title: 'Do you want to delete?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Confirm',
        denyButtonText: `Cancel`,
        }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/admin/user/'+ id,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    },
                success:function(){
                    table.ajax.reload();
                }


            })
        }else if (result.isDenied) {

        }
        })
    })
});
</script>
@endsection
