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
                    {{-- <li>
                        <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1">
                            <i class="icon icon-list"></i>Semua Data</a>
                    </li>
                    <li>
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
                                <form class="needs-validation"  id="form2" method="POST" autocomplete="off" novalidate>
                                    {{ method_field('PATCH') }}
                                    @csrf
                                    <input type="hidden" name="id" id="id_logo" value="{{ $logo->id }}">
                                    <div class="form-group col-md-12">
                                        <img id="prevlogo" src="{{ $logo->getImage(1) }}" alt="">
                                        <label for="" class="col-form-label">Logo</label>
                                        <input type="file" name="logo" id="logo" class="form-control">
                                        <small class="text-danger" >*Abaikan jika tidak ingin mengganti Logo</small>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <img id="prevfavicon" src="{{ $logo->getImage(2) }}" alt="">
                                        <label for="" class="col-form-label">Favicon</label>
                                        <input type="file" name="favicon" id="favicon" class="form-control">
                                        <small class="text-danger" >*Abaikan jika tidak ingin mengganti Favicon</small>
                                    </div>
                                    <button type="submit" id="action" class="btn btn-primary float-right">Simpan</button>
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

            url =  "{{ route($route.'update', ':id') }}".replace(':id', $('#id_logo').val());
            $.ajax({
                url : url,
                type : 'POST',
                data: new FormData($(this)[0]),
                contentType: false,
                processData: false,
                success : function(data) {
                    $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");

                    $.alert({
                            title: 'Success!',
                            type: 'green',
                            content: data.message,
                        });
                        $('#prevfavicon').attr('src','{{URL::to("/")}}'+'/'+data.logo.favicon);
                        $('#prevlogo').attr('src','{{URL::to("/")}}'+'/'+data.logo.logo);


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
