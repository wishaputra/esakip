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

                    <div class="col-md-6 offset-3">
                        <div class="card mb-3 mt-3 shadow r-0">

                            <div class="card-body">
                                <form class="needs-validation" id="form2" method="POST" autocomplete="off" novalidate>
                                    {{ method_field('PATCH') }}
                                    @csrf
                                    <input type="hidden" name="id" id="id_txt" value="{{ $txt->id }}">
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Title</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ $txt->title }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Description</label>
                                        <textarea name="description" id="" cols="30" rows="3"
                                            class="form-control">{{ $txt->description }}</textarea>
                                    </div>
                                    <button type="submit" id="action"
                                        class="btn btn-primary float-right">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
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
                                            <td>Urutan</td>
                                            <td>Nama</td>
                                            <td>Deskripsi</td>
                                            <td>Harga</td>

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
                        <div class="col-6">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">No Urut</label>
                                <input type="number" name="order" id="order" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Deskripsi</label>

                                <textarea name="deskripsi" id="deskripsi" cols="30" rows="5"
                                    class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Harga</label>
                                <input type="number" name="harga" id="harga" value="" placeholder=""
                                    class="form-control">

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Durasi</label>
                                <input type="text" name="durasi" id="durasi" value="" placeholder=""
                                    class="form-control">

                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Text Button </label>
                                <input type="text" name="text_button" id="text_button" value="" placeholder=""
                                    class="form-control">

                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Link Button </label>
                                <input type="text" name="link_button" id="link_button" value="" placeholder=""
                                    class="form-control">

                            </div>
                            <div class="form-group col-md-12">
                                <label for="" class="col-form-label">Badge Text</label>
                                <input type="text" name="badge_text" id="badge_text" class="form-control">

                            </div>
                           

                        </div>
                    </div>

                    <div id="dt_fitur">


                       

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
        resetFitur();
        
        
            
       
    }
    
    function edit(id){
        save_method = 'edit';
        $('#alert').html('');
        $('#form').trigger('reset');
        
        $('.modal-title').html("Edit Data");
        $('#reset').hide();
        resetFitur();
        
        $('input[name=_method]').val('PATCH');
        $.get("{{ route($route.'edit', ':id') }}".replace(':id', id), function(data){
            $('#id').val(data.pricing.id);
            $('#nama').val(data.pricing.nama).focus();
            $('#order').val(data.pricing.order);
            $('#harga').val(data.pricing.harga);
            $('#durasi').val(data.pricing.durasi);
            $('#text_button').val(data.pricing.text_button);
            $('#link_button').val(data.pricing.link_button);
            $('#badge_text').val(data.pricing.badge_text);
            $('#deskripsi').val(data.pricing.deskripsi);

            $.each(data.list, function (i,v){
                if(i != 0){
                addForm();

                }
                $('#cheklist_'+i).val(v.check);
                $('#fitur_'+i).val(v.nama);
                $('#urutan_'+i).val(v.order);
            })
          
           
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

            url = (save_method == 'add') ? "{{ route($route.'store') }}" : "{{ route($route.'update', ':id') }}".replace(':id', $('#id').val());
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
    $('#form2').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert').html('');
            $('#action').attr('disabled', true);

            url =  "{{ route('setup.section.textcontent.update', ':id') }}".replace(':id', $('#id_txt').val());
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
        order: [1, 'asc'],
        ajax: {
            url: "{{ route($route.'api') }}",
            method: 'POST'
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'order', name: 'order'},
            {data: 'nama', name: 'nama'},
            {data: 'deskripsi', name: 'deskripsi'},
            {data: 'harga', name: 'harga'},
           
            
            
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
                        $.post("{{ route($route.'destroy', ':id') }}".replace(':id', id), {'_method' : 'DELETE'}, function(data) {
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

    var dt_fitur = 0;
    function addForm(){
        $('.addBtnFrm').hide();
        
        dt_fitur++;

        html = `<div class="form-row" id="frm`+dt_fitur+`" >

            <div class="col-md-2">
                                <div class="form-group col-md-12">
                                    <label for="" class="col-form-label">Urutan</label>
                                    
                                    <input type="number" name="urutan[`+dt_fitur+`]" id="urutan_`+dt_fitur+`" value="" placeholder=""
                                    class="form-control">
                                </div>
                            </div>
    
                            <div class="col-md-2">
                                <div class="form-group col-md-12">
                                    <label for="" class="col-form-label">Checklist</label>
                                    <select name="cheklist[`+dt_fitur+`]" id="cheklist_`+dt_fitur+`" class="form-control">
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="" class="col-form-label">Fitur</label>
                                    <input type="text" name="fitur[`+dt_fitur+`]" id="fitur_`+dt_fitur+`" class="form-control">

                                </div>
                            </div>
                    <div class="col-md-2">
                    <div class="form-group">
                        <label for="" class="col-form-label s-12"></label>
                            <a class="btn-fab btn-fab-sm shadow btn-danger" style="margin-top:30px;"  onclick="deleteForm(`+dt_fitur+`);"><i class="icon-minus"></i></a>
                            <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrm" style="margin-top:30px;" id="addBtn`+dt_fitur+`" onclick="addForm();"><i class="icon-plus"></i></a>
                    </div>
                    </div>

                </div>`
        $('#dt_fitur').append(html);
        
        $('.addBtnFrm').last().show();


    }
    function deleteForm(id){
   
       
   $('.addBtnFrm').hide();
   
   $('#frm'+id).remove();
   $('.addBtnFrm').last().show();
}

    function resetFitur(){
        dt_fitur = 0;
        var html = `<div class="form-row">
                            <div class="col-md-2">
                                <div class="form-group col-md-12">
                                    <label for="" class="col-form-label">Urutan</label>
                                    
                                    <input type="number" name="urutan[0]" id="urutan_0" value="" placeholder=""
                                    class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group col-md-12">
                                    <label for="" class="col-form-label">Checklist</label>
                                    <select name="cheklist[0]" id="cheklist_0" class="form-control">
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="" class="col-form-label">Fitur</label>
                                    <input type="text" name="fitur[0]" id="fitur_0" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <label for="" class="col-form-label s-12"></label>
                                    <a class="btn-fab btn-fab-sm shadow btn-primary addBtnFrm" style="margin-top:30px;"
                                        id="addBtn1" onclick="addForm();"><i class="icon-plus"></i></a>
                                </div>
                            </div>
                            
                        </div>`;
                        $('#dt_fitur').html(html);

    }
</script>
@endpush