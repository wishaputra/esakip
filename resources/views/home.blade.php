@extends('layouts.app')
@section('title')
{{ $title }}
@endsection

@push('style')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
    integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />




@endpush

@section('content')





<div class="page has-sidebar-left bg-light">
    {{-- <header class="blue accent-3 relative nav-sticky">
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
    </header> --}}

    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <h1>Halaman Utama</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <p class="text-center">Dokumentasi Pengguna</p>
                <iframe src="{{ route('main.displaypdf') }}" width="100%" height="600px"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')


<script>
    
                
</script>



@endpush