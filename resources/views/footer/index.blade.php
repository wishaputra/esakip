@extends('layouts.app')
@section('title')
{{ $title }}
@endsection

@push('style')


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

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
                    {{-- <li>
                        <a class="nav-link " onclick="add()" href="#">
                            <i class="icon icon-plus-circle"></i>Tambah Data</a>
                    </li> --}}


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
                                <h3>Left Footer</h3>
                            </div>
                            <div class="card-body">
                                <div id="alert_1"></div>
                                <form class="needs-validation" id="form_about" method="POST" autocomplete="off" novalidate>
                                    {{ method_field('Patch') }}
                                    @csrf
                                    <input type="hidden" name="id_about" id="id_about" value="{{ $about->id }}">
                                    <input type="hidden" name="type" value="Left">
                                    <div class="form-group col-md-6">
                                        <label for="" class="col-form-label">Title</label>
                                        <input type="text" name="title_about" id="title_about" class="form-control" value="{{ $about->title }}">
                                    </div>


                                    {{-- <textarea id="test" name="test"> {!! Str::words(trim(strip_tags($about->content)),40, ' ...')!!}</textarea> --}}

                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Content</label>
                                        <textarea id="content_about" name="content_about">{{ $about->content }}</textarea>
                                    </div>

                                    <button type="submit" id="action_about" class="btn btn-primary float-right">Simpan</button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card mb-3 mt-3 shadow r-0">
                            <div class="card-header white">
                                <h3>Middle Footer</h3>

                            </div>
                            <div class="card-body">
                                <div id="alert_2"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <form class="needs-validation" id="form_link" method="POST" autocomplete="off" novalidate>
                                            {{ method_field('Patch') }}
                                            @csrf
                                            <input type="hidden" name="id_link" id="id_link" value="{{ $link->id }}">
                                            <input type="hidden" name="type" value="Middle">
                                            <div class="form-group col-md-6">
                                                <label for="" class="col-form-label">Title</label>
                                                <input type="text" name="title_link" id="title_link" class="form-control" value="{{ $link->title }}">
                                            </div>



                                            <button type="submit" id="action" class="btn btn-primary ml-3 ">Simpan</button>
                                        </form>
                                    </div>

                                </div>

                                <div class="row mt-5">
                                    <a class="ml-3 " onclick="add_link()" href="#!">
                                        <i class="icon icon-plus-circle"></i>&nbsp;Tambah</a>
                                    <table class="table" id="link-table">
                                        <thead>
                                            <tr>
                                                <td>#</td>

                                                <td>Order</td>
                                                <td>Link </td>


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
                <div class="row">

                    <div class="col-md-12">
                        <div class="card mb-3 mt-3 shadow r-0">
                            <div class="card-header white">
                                <h3>Right Footer</h3>
                            </div>
                            <div class="card-body">
                                <div id="alert_3"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <form class="needs-validation" id="form_social" method="POST" autocomplete="off" novalidate>
                                            {{ method_field('Patch') }}
                                            @csrf
                                            <input type="hidden" name="id_social" id="id_social" value="{{ $social->id }}">
                                            <input type="hidden" name="type" value="Right">
                                            <div class="form-group col-md-6">
                                                <label for="" class="col-form-label">Title</label>
                                                <input type="text" name="title_social" id="title_social" class="form-control" value="{{ $social->title }}">
                                            </div>




                                            <button type="submit" id="action" class="btn btn-primary ml-3 ">Simpan</button>
                                        </form>
                                    </div>

                                </div>


                                <div class="row mt-5">
                                    {{-- <a class="ml-3 " onclick="add_social()" href="#!">
                                        <i class="icon icon-plus-circle"></i>&nbsp;Tambah</a> --}}
                                    <table class="table" id="social-table">
                                        <thead>
                                            <tr>
                                                <td>#</td>

                                                <td>Order</td>
                                                <td>Name</td>
                                                <td>Icon</td>
                                                <td>Link </td>


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
</div>

<div class="modal fade" id="form-modal-link" tabindex="-1" role="dialog" aria-labelledby="form-modal-linkLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-link" id="form-modal-linkLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-modal-link"></div>
                <form class="needs-validation" id="form-modal-link-form" method="POST" autocomplete="off" novalidate>
                    <input type="hidden" name="_method" id="method_link">
                    @csrf
                    <input type="hidden" name="frm_link_id" id="frm_link_id">




                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Order</label>
                        <input type="number" name="frm_link_order" id="frm_link_order" class="form-control">
                    </div>


                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Link</label>
                        <textarea name="frm_link_content" id="frm_link_content"  ></textarea>
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

<div class="modal fade" id="form-modal-social" tabindex="-1" role="dialog" aria-labelledby="form-modal-socialLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-social" id="form-modal-socialLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert-modal-social"></div>
                <form class="needs-validation" id="form-modal-social-form" method="POST" autocomplete="off" novalidate>
                    <input type="hidden" name="_method" id="method_social">
                    @csrf
                    <input type="hidden" name="frm_social_id" id="frm_social_id">




                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Order</label>
                        <input type="number" name="frm_social_order" id="frm_social_order" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Name</label>
                        <input type="text" name="frm_social_name" id="frm_social_name" class="form-control">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Icon <small><a
                            href="https://fontawesome.com/icons?d=gallery&v=5.0.0,5.0.1,5.0.10,5.0.11,5.0.12,5.0.13,5.0.2,5.0.3,5.0.4,5.0.5,5.0.6,5.0.7,5.0.8,5.0.9,5.1.0,5.1.1,5.2.0,5.3.0,5.3.1,5.4.0,5.4.1,5.4.2,5.5.0,5.6.0,5.6.1,5.6.3,5.9.0&m=free"
                            target="_blank"> List</a> </small></label>
                        <input type="text" name="frm_social_icon" id="frm_social_icon" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Link</label>
                        <input type="text" name="frm_social_link" id="frm_social_link" class="form-control">
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

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
function sm(id){
    $('#'+id).summernote({
    // dialogsInBody: true,
    height: 200,
  toolbar: [
                // ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],

                ['insert', ['link',]],
                ['view', ['fullscreen', 'codeview']]
            ],


});

}
$(document).ready(function(){
sm('content_about');
sm('frm_link_content');



});

// Initialize summernote with LFM button in the popover button group
// Please note that you can add this button to any other button group you'd like


$('#form_about').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert_1').html('');
            $('#action_about').attr('disabled', true);

            url = "{{ route($route.'update', ':id') }}".replace(':id', $('#id_about').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert_1').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");

                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                            buttons: {
                                ok: function(){
                                    // location.href = '{{ route($route.'index')}}
                                }
                            }
                        });


                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert_1').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    $('#action_about').removeAttr('disabled');
                },
                complete : function(data){
                    $('#action_about').removeAttr('disabled');
                }
            });

            return false;
        }
        $(this).addClass('was-validated');
    });

$('#form_link').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert_2').html('');
            $('#action_about').attr('disabled', true);

            url = "{{ route($route.'update', ':id') }}".replace(':id', $('#id_link').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert_2').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");

                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                            buttons: {
                                ok: function(){
                                    // location.href = '{{ route($route.'index')}}
                                }
                            }
                        });


                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert_2').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    $('#action_about').removeAttr('disabled');
                },
                complete : function(data){
                    $('#action_about').removeAttr('disabled');
                }
            });

            return false;
        }
        $(this).addClass('was-validated');
    });

$('#form_social').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert_3').html('');
            $('#action_about').attr('disabled', true);

            url = "{{ route($route.'update', ':id') }}".replace(':id', $('#id_social').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert_3').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");

                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                            buttons: {
                                ok: function(){
                                    // location.href = '{{ route($route.'index')}}
                                }
                            }
                        });


                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert_3').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    $('#action_about').removeAttr('disabled');
                },
                complete : function(data){
                    $('#action_about').removeAttr('disabled');
                }
            });

            return false;
        }
        $(this).addClass('was-validated');
    });


    //table link

    var table_link = $('#link-table').dataTable({
        processing: true,
        serverSide: true,
        order: [1, 'asc'],

        ajax: {
            url: "{{ route($route.'api_link') }}",
            method: 'POST'
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'order', name: 'order'},
            {data: 'content', name: 'content'},



            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    table_link.on('draw.dt', function(){
        var PageInfo = $('#link-table').DataTable().page.info();
        table_link.api().column(0, {page: 'current'}).nodes().each(function (cell, i){
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

    function add_link(){
        $('#alert-modal-link').html('');
        save_method_link = "add";
        $('#form-modal-link-form').trigger('reset');
        $('.modal-title-link').html('Tambah Data')
        $('#method_link').val('POST');
        $('#form-modal-link').modal('show');
        $('#frm_link_content').summernote('code', '');
        $('#frm_link_id').val('');




    }


    function edit_link(id){
        save_method_link = 'edit';
        $('#alert-modal-link').html('');
        $('#form-modal-link-form').trigger('reset');

        $('.modal-title-link').html("Edit Data");

        $('#method_link').val('PATCH');
        $.get("{{ route('setup.footer.link_edit', ':id') }}".replace(':id', id), function(data){

            $('#frm_link_id').val(data.id);
            $('#frm_link_order').val(data.order).focus();

            $('#frm_link_content').summernote('code', data.content);


            $('#form-modal-link').modal('show');
        }, "JSON").fail(function(){
            reload();
        });



    }
    $('#form-modal-link-form').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert-modal-link').html('');
            $('#action').attr('disabled', true);

            url = (save_method_link == 'add') ? "{{ route('setup.footer.link_store') }}" : "{{ route('setup.footer.link_patch', ':id') }}".replace(':id', $('#frm_link_id').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert_2').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                    table_link.api().ajax.reload();
                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                        });
                    $('#form-modal-link').modal('hide');
                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert-modal-link').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                },
                complete : function(data){
                    $('#action').removeAttr('disabled');
                }
            });

            return false;
        }
        $(this).addClass('was-validated');
    });

    function remove_link(id){
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
                        $.post("{{ route('setup.footer.link_destroy', ':id') }}".replace(':id', id), {'_method' : 'DELETE'}, function(data) {
                            table_link.api().ajax.reload();
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

    //table social

    var table_social = $('#social-table').dataTable({
        processing: true,
        serverSide: true,
        order: [1, 'asc'],

        ajax: {
            url: "{{ route($route.'api_social') }}",
            method: 'POST'
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'order', name: 'order'},
            {data: 'name', name: 'name'},
            {data: 'icon', name: 'icon'},
            {data: 'link', name: 'link'},



            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    table_social.on('draw.dt', function(){
        var PageInfo = $('#social-table').DataTable().page.info();
        table_social.api().column(0, {page: 'current'}).nodes().each(function (cell, i){
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

    function add_social(){
        $('#alert-modal-social').html('');
        save_method_social = "add";
        $('#form-modal-social-form').trigger('reset');
        $('.modal-title-social').html('Tambah Data')
        $('#method_social').val('POST');
        $('#form-modal-social').modal('show');
        $('#frm_social_content').summernote('code', '');
        $('#frm_social_id').val('');




    }


    function edit_social(id){
        save_method_social = 'edit';
        $('#alert-modal-social').html('');
        $('#form-modal-social-form').trigger('reset');

        $('.modal-title-social').html("Edit Data");

        $('#method_social').val('PATCH');
        $.get("{{ route('setup.footer.social_edit', ':id') }}".replace(':id', id), function(data){

            $('#frm_social_id').val(data.id);
            $('#frm_social_order').val(data.order).focus();

            $('#frm_social_icon').val( data.icon);
            $('#frm_social_name').val( data.name);
            $('#frm_social_link').val( data.link);


            $('#form-modal-social').modal('show');
        }, "JSON").fail(function(){
            reload();
        });



    }
    $('#form-modal-social-form').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert-modal-social').html('');
            $('#action').attr('disabled', true);

            url = (save_method_social == 'add') ? "{{ route('setup.footer.social_store') }}" : "{{ route('setup.footer.social_patch', ':id') }}".replace(':id', $('#frm_social_id').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert_3').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                    table_social.api().ajax.reload();
                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                        });
                    $('#form-modal-social').modal('hide');
                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert-modal-social').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                },
                complete : function(data){
                    $('#action').removeAttr('disabled');
                }
            });

            return false;
        }
        $(this).addClass('was-validated');
    });

    function remove_social(id){
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
                        $.post("{{ route('setup.footer.social_destroy', ':id') }}".replace(':id', id), {'_method' : 'DELETE'}, function(data) {
                            table_social.api().ajax.reload();
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
