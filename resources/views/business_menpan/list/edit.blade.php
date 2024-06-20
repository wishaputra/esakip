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
                        <a class="nav-link active" id="v-pills-1-tab" href="{{ route($route.'index')}}">
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
                                    {{ method_field('Patch') }}
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $list->id }}">
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Title</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ $list->title }}">
                                    </div>


                                    <div class="form-group col-md-12">
                                        @if ($list->thumbnail)

                                        <img width="400px" alt="" src="{{ $list->getImage() }}">
                                        <br>
                                        @endif

                                        <label for="" class="col-form-label">Thumbnail</label>

                                        <input type="file" name="thumbnail" id="thumbnail" class="form-control"
                                            value="">
                                        @if ($list->thumbnail)

                                        <small class="text-danger">*Abaikan jika tidak ingin mengganti thumbnail</small>

                                        @endif

                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Category</label>
                                        <select name="business_category_id" id="business_category_id"
                                            class="form-control" required>
                                            {{-- <option value="">Pilih</option> --}}
                                            @foreach ($categories as $i)

                                            <option value="{{ $i->id }} " @if($list->business_category_id == $i->id)
                                                selected @endif>{{ $i->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div id="accordion" style="padding-right: 15px;padding-left:15px;">

                                        <div class="card">
                                          <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse-1">
                                              Content 1
                                            </a>
                                          </div>
                                          <div id="collapse-1" class="collapse show" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Title Tab</label>
                                                    <input type="text" name="tab_content" id="tab_content" class="form-control"
                                                        value="{{ $list->tab_content }}">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Content</label>
                                                    <textarea class="sumerNote" id="content"
                                                        name="content">{{ $list->content }}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse-2">
                                              Content 2
                                            </a>
                                          </div>
                                          <div id="collapse-2" class="collapse {{ $list->tab_content_2 ? 'show':''}} " data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Title Tab 2</label>
                                                    <input type="text" name="tab_content_2" id="tab_content_2" class="form-control"
                                                        value="{{ $list->tab_content_2 }}">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Content 2</label>
                                                    <textarea class="sumerNote" id="content_2"
                                                        name="content_2">{{ $list->content_2 }}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse-3">
                                              Content 3
                                            </a>
                                          </div>
                                          <div id="collapse-3" class="collapse {{ $list->tab_content_3 ? 'show':''}} " data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Title Tab 3</label>
                                                    <input type="text" name="tab_content_3" id="tab_content_3" class="form-control"
                                                        value="{{ $list->tab_content_3 }}">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Content 3</label>
                                                    <textarea class="sumerNote" id="content_3"
                                                        name="content_3">{{ $list->content_3 }}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse-4">
                                              Content 4
                                            </a>
                                          </div>
                                          <div id="collapse-4" class="collapse {{ $list->tab_content_4 ? 'show':''}} " data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Title Tab 4</label>
                                                    <input type="text" name="tab_content_4" id="tab_content_4" class="form-control"
                                                        value="{{ $list->tab_content_4 }}">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Content 4</label>
                                                    <textarea class="sumerNote" id="content_4"
                                                        name="content_4">{{ $list->content_4 }}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card">
                                          <div class="card-header">
                                            <a class="card-link" data-toggle="collapse" href="#collapse-5">
                                              Content 5
                                            </a>
                                          </div>
                                          <div id="collapse-5" class="collapse {{ $list->tab_content_5? 'show':''}} " data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Title Tab 5</label>
                                                    <input type="text" name="tab_content_5" id="tab_content_5" class="form-control"
                                                        value="{{ $list->tab_content_5 }}">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="" class="col-form-label">Content 5</label>
                                                    <textarea class="sumerNote" id="content_5"
                                                        name="content_5">{{ $list->content_5 }}</textarea>
                                                </div>
                                            </div>
                                          </div>
                                        </div>


                                      </div>




                                    {{-- <textarea id="test" name="test"> {!! Str::words(trim(strip_tags($list->content)),40, ' ...')!!}</textarea> --}}








                                    <div class="form-group col-md-12">
                                        <label for="" class="col-form-label">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="Draft" {{ $list->status == "Draft" ? 'selected':'' }}>Draft
                                            </option>
                                            <option value="Publish" {{ $list->status == "Publish" ? 'selected':'' }}>
                                                Publish</option>
                                        </select>
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

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function(){

// Define function to open filemanager window
var lfm = function(options, cb) {
  var route_prefix = (options && options.prefix) ? options.prefix : '{{ env("APP_URL") }}'+'/laravel-filemanager';
  window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
  window.SetUrl = cb;
};

// Define LFM summernote button
var LFMButton = function(context) {
  var ui = $.summernote.ui;
  var button = ui.button({
    contents: '<i class="note-icon-picture"></i> ',
    tooltip: 'Insert image with filemanager',
    click: function() {

      lfm({type: 'image', prefix: '{{ env("APP_URL") }}'+'/laravel-filemanager'}, function(lfmItems, path) {
        lfmItems.forEach(function (lfmItem) {
          context.invoke('insertImage', lfmItem.url);
        });
      });

    }
  });
  return button.render();
};

// Initialize summernote with LFM button in the popover button group
// Please note that you can add this button to any other button group you'd like
$('.sumerNote').summernote({
    dialogsInBody: true,
    height: 600,
  toolbar: [
                ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
            ],

  buttons: {
    lfm: LFMButton
  },
})
});

$('#form').on('submit', function (a) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }else{
            $('#alert').html('');
            $('#action').attr('disabled', true);

            url = "{{ route($route.'update', ':id') }}".replace(':id', $('#id').val());
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
