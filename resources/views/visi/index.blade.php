@extends('layouts.app')
@section('title')

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
                       
                    </h4>
                </div>
            </div>
            <div class="row">
                <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                    <li>
                        <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1">
                            <i class="icon icon-list"></i>Semua Data</a>
                    </li>
                    <li>
                        <a class="nav-link " onclick="add()" href="#">
                            <i class="icon icon-plus-circle"></i>Tambah Data</a>
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
                                <table class="table" id="menu-table">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td width="20%">tahun awal</td>
                                            <td>tahun akhir</td>
                                            <td>visi</td>
                                            <td>misi</td>
                                            

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
                                <label for="" class="col-form-label">Tahun Awal</label>
                                <input type= "hidden" name="creator" id="creator" value= "{{ Auth::user()->id }}">
                                <input type="number" name="tahun_awal" id="tahun_awal" min="2008" max="3000" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Tahun Akhir</label>
                                <input type="number" name="tahun_akhir" id="tahun_akhir" min="2008" max="3000" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                <label for="visi" class="col-form-label">visi</label>
                                <textarea name="visi" id="visi" class="form-control" rows="3"></textarea>
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
        $('#nama').focus();
        
            
       
    }
    
    function edit(id){
        save_method = 'edit';
        $('#alert').html('');
        $('#form').trigger('reset');
        
        $('.modal-title').html("Edit Data");
        $('#reset').hide();
        $('input[name=_method]').val('PATCH');
        $.get("{{ route('setup.visi.edit', ':id') }}".replace(':id', id), function(data){
            $('#id').val(data.id);
            $('#tahun_awal').val(data.tahun_awal).focus();
            $('#tahun_akhir').val(data.tahun_akhir);
            $('#visi').val(data.visi);

           
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

            url = (save_method == 'add') ? "{{ route('setup.visi.store') }}" : "{{ route('setup.visi.update', ':id') }}".replace(':id', $('#id').val());
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

    var table = $('#menu-table').dataTable({
        processing: true,
        serverSide: true,
        order: [2, 'asc'],
        ajax: {
            url: "{{ route('setup.visi.api') }}",
            method: 'POST'
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'tahun_awal', name: 'tahun_awal'},
            {data: 'tahun_akhir', name: 'tahun_akhir'},
            {data: 'visi', name: 'visi'},
            {data: 'misi_count', name: 'misi_count'},
           
            
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    table.on('draw.dt', function(){
        var PageInfo = $('#menu-table').DataTable().page.info();
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
                        $.post("{{ route('setup.visi.destroy', ':id') }}".replace(':id', id), {'_method' : 'DELETE'}, function(data) {
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