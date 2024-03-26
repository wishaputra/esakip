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

                            </div>
                            <div class="card-body">
                                <div id="alert"></div>
                                <form class="needs-validation" id="form" method="POST" autocomplete="off" novalidate>


                                    {{ method_field('POST') }}
                                    @csrf
                                    {{-- <input type="hidden" name="id" id="id_txt" value="{{ $txt->id }}"> --}}
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" value="">
                                    </div>
                                    @php
                                    $type = Request::segment(2);
                                @endphp
                                    @if ($type == 'blog')
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Thumbnail</label>
                                        <input type="file" name="thumbnail" id="thumbnail" class="form-control" value="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Category</label>
                                        <select name="post_category_id" id="post_category_id" class="form-control" required>
                                            {{-- <option value="">Pilih</option> --}}
                                            @foreach ($categories as $i)

                                            <option value="{{ $i->id }} ">{{ $i->nama }}</option>
                                            @endforeach
                                        </select>

                                    </div>


                                    @endif
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Content</label>
                                        <textarea id="content" name="content"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="Draft">Draft</option>
                                            <option value="Publish">Publish</option>
                                        </select>
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

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>

$(document).ready(function(){

// Define function to open filemanager window
// var lfm = function(options, cb) {
//   var route_prefix = (options && options.prefix) ? options.prefix : '{{ env("APP_URL") }}'+'/laravel-filemanager';
//   window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
//   window.SetUrl = cb;
// };

// Define LFM summernote button
// var LFMButton = function(context) {
//   var ui = $.summernote.ui;
//   var button = ui.button({
//     contents: '<i class="note-icon-picture"></i> ',
//     tooltip: 'Insert image with filemanager',
//     click: function() {

//       lfm({type: 'image', prefix: '{{ env("APP_URL") }}'+'/laravel-filemanager'}, function(lfmItems, path) {
//         lfmItems.forEach(function (lfmItem) {
//           context.invoke('insertImage', lfmItem.url);
//         });
//       });

//     }
//   });
//   return button.render();
// };

// Initialize summernote with LFM button in the popover button group
// Please note that you can add this button to any other button group you'd like
$('#content').summernote({
    dialogsInBody: true,
    height: 600,
    maximumImageFileSize: 1024*1024, // 1 MB
    callbacks:{
        onImageUploadError: function(msg){
            alert('Ukuran foto maksimal 1 MB');
        //    console.log(msg + ' (1 MB)');
        }
    }
//   toolbar: [
//                 ['style', ['style']],
//                 ['font', ['bold', 'underline', 'clear']],
//                 ['fontsize', ['fontsize']],
//                 ['color', ['color']],
//                 ['para', ['ul', 'ol', 'paragraph']],
//                 ['table', ['table']],
//                 ['insert', ['link', 'lfm','video', 'filemanager']],
//                 ['view', ['fullscreen', 'codeview']]
//             ],
//   buttons: {
//     lfm: LFMButton
//   }
})
});

$('#form').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert').html('');
            $('#action').attr('disabled', true);

            url = "{{ route($route.'store') }}";
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
                            buttons: {
                                ok: function(){
                                    location.href = '{{ route($route.'index')}}'
                                }
                            }
                        });


                },
                error : function(data){
                    err = ''; respon = data.responseJSON;
                    $.each(respon.errors, function(index, value){
                        err += "<li>" + value +"</li>";
                    });
                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                    $('#action').removeAttr('disabled');
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
