@extends('layouts.app')
@section('title')
{{ $title }}
@endsection

@push('style')


@endpush

@section('content')



<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                        {{ $title}}
                    </h4>
                </div>
            </div>
            <div class="row">
                <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                    <li>
                        <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1">
                            <i class="icon icon-list"></i>Semua User</a>
                    </li>
                    <li>
                        <a class="nav-link " onclick="add()" href="#">
                            <i class="icon icon-plus-circle"></i>Tambah User</a>
                    </li>


                </ul>

            </div>
        </div>
    </header>

    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">

                <div class="row">

                    <div class="col-md-12">
                        <div class="card mb-3 mt-3 shadow r-0">
                            <div class="card-header white">

                            </div>
                            <div class="card-body">
                                <table class="table" id="user-table">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td width="20%">Nama</td>
                                            <td width="20%">Username</td>
                                            <td width="20%">Email</td>
                                            <td width="20%">No. Telp</td>
                                            <td>Perangkat Daerah</td>
                                            <td>Role</td>
                                            <td width="10%">Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>




        </div>
    </div>
</div>

<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form-modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert"></div>
                <form class="needs-validation" id="form" method="POST" autocomplete="off" novalidate>
                    {{ method_field('POST') }}
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">No. Telp</label>
                                <input type="number" name="telp" id="telp" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Perangkat Daerah</label>
                                <select name="id_opd" id="id_opd" class="form-control">
                                    <option value="">Pilih</option>
                                    @foreach ($opd as $item)
                                        <option value="{{ $item->id }}">{{ $item->perangkat_daerah }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="1">Super Admin</option>
                                    <option value="2">Admin Perangkat Daerah</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="action" class="btn btn-primary tButton">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('script')

<script>
    function add(){
        $('#alert').html('');
        save_method = "add";
        $('#form').trigger('reset');
        $('.modal-title').html('Tambah Data')
        $('input[name=_method]').val('POST');
        $('#form-modal').modal('show');
        $('#name').focus();
    }
    
    function edit(id){
        save_method = 'edit';
        $('#alert').html('');
        $('#form').trigger('reset');
        $('.modal-title').html("Edit Data");
        $('#reset').hide();
        $('input[name=_method]').val('PATCH');
        $.get("{{ route('setup.user.edit', ':id') }}".replace(':id', id), function(data){
            $('#id').val(data.id);
            $('#name').val(data.name).focus();
            $('#username').val(data.username);
            $('#password').val(data.password);
            $('#email').val(data.email);
            $('#telp').val(data.telp);
            $('#id_opd').val(data.id_opd);
            $('#role').val(data.role);
            $('#form-modal').modal('show');
        }, "JSON").fail(function(){
            reload();
        });
    }
   
    $('#form').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert').html('');
            $('#action').attr('disabled', true);

            url = (save_method == 'add') ? "{{ route('setup.user.store') }}" : "{{ route('setup.user.update', ':id') }}".replace(':id', $('#id').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                    table.api().ajax.reload();
                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                        });
                    $('#form-modal').modal('hide');
                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                },
                complete : function(data){
                    $('#action').removeAttr('disabled');
                }
            });
          
            return false;
        }
        $(this).addClass('was-validated');
    });

    var table = $('#user-table').dataTable({
        processing: true,
        serverSide: true,
        order: [2, 'asc'],
        ajax: {
            url: "{{ route('setup.user.api') }}",
            method: 'POST'
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'name', name: 'name'},
            {data: 'username', name: 'username'},
            {data: 'email', name: 'email'},
            {data: 'telp', name: 'telp'},
            {data: 'id_opd', name: 'id_opd'},
            {data: 'role', name: 'role'},       
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    table.on('draw.dt', function(){
        var PageInfo = $('#user-table').DataTable().page.info();
        table.api().column(0, {page: 'current'}).nodes().each(function (cell, i){
            cell.innerHTML = i + 1 + PageInfo.start;
        });
        $("a.group").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
    });

        function remove(id){
        $.confirm({
            title: '',
            content: 'Apakah Anda yakin akan menghapus data ini?',
            icon: 'icon icon-question amber-text',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                ok: {
                    text: "ok!",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        $.post("{{ route('setup.user.destroy', ':id') }}".replace(':id', id), {'_method' : 'DELETE'}, function(data) {
                            table.api().ajax.reload();
                            $.alert({
                                title: 'Success!',
                                type: 'red',
                                content: data.message,
                            });
                        }, "JSON").fail(function(data){
                            console.log(data);
                            $.alert({
                                title: 'Error!',
                                type: 'red',
                                content: data.responseJSON.message,
                            });
                        });
                    }
                },
                cancel: function(){}
            }
        });
    }
</script>
@endpush