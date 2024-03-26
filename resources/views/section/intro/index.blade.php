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
                                <div id="alert"></div>
                                <form class="needs-validation" id="form" method="POST" autocomplete="off" novalidate>
                                    @method('PATCH')
                                    @csrf
                                    <div class="row">


                                        <div class="col-6">

                                            <input type="hidden" name="id" id="id" value="{{$intro->id}}">
                                            <div class="form-group">
                                                <label for="title" class="col-form-label">Title</label>
                                                <input type="text" name="title" class="form-control" id="title"
                                                    placeholder="" value="{{$intro->title}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="subtitle" class="col-form-label">Sub Title</label>
                                                <input type="text" name="subtitle" class="form-control" id="subtitle"
                                                    placeholder="" value="{{$intro->subtitle}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="title" class="col-form-label">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="5"
                                                    class="form-control">{{$intro->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="title" class="col-form-label">Text Button</label>
                                                <input type="text" name="text_button" class="form-control"
                                                    id="text_button" placeholder="" value="{{$intro->text_button}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="title" class="col-form-label">Link Button</label>
                                                <input type="text" name="href_button" class="form-control"
                                                    id="href_button" placeholder="" value="{{$intro->href_button}}">
                                            </div>
                                            <img src="{{asset($intro->image)}}" width="100px" alt="">
                                            <div class="form-group">
                                                <label for="title" class="col-form-label">Image <small>( 500px x 500px )</small></label>
                                                <input type="file" name="image" class="form-control" id="image"
                                                    placeholder="as" value="{{$intro->image}}">
                                                <small class="text-red">
                                                    Abaikan jika tidak ingin diganti.
                                                </small>
                                            </div>

                                            <button type="submit" id="action"
                                                class="btn btn-primary tButton float-right">Simpan</button>
                                        </div>
                                    </div>

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
$('#form').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert').html('');
            $('#action').attr('disabled', true);

            url =  "{{ route($route.'update', ':id') }}".replace(':id', $('#id').val());
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