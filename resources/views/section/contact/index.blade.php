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
                                        <textarea name="description" id="" cols="30" rows="3" class="form-control">{{ $txt->description }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Alamat</label>
                                        <textarea name="alamat" id="" cols="30" rows="3" class="form-control">{{ $txt->alamat }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Telp</label>
                                        <input type="text" name="telp" id="telp" class="form-control"
                                        value="{{ $txt->telp }}">
                                    </div>
                              
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                        value="{{ $txt->email }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Link Maps</label>
                                        <textarea name="link_maps" id="" cols="30" rows="3" class="form-control">{{ $txt->link_maps }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Text Submit Button</label>
                                        <input type="text" name="text_button" id="text_button" class="form-control"
                                        value="{{ $txt->text_button }}">
                                    </div>

                                    <button type="submit" id="action"
                                        class="btn btn-primary float-right">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>




        </div>
    </div>
</div>


@endsection


@push('script')

<script>

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
                    // table.api().ajax.reload();
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








</script>
@endpush
