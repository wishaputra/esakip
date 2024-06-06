@extends('front.custom_page.layout')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
    <header id="header" class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{$title}}</h1>
                </div>
            </div>
        </div>
    </header>
    
    <form action="" class="form-inline mt-4 justify-content-center">
        <div class="form-group mb-3">
            <h5 class="ml-3">Pilih Periode Tahun</h5>
            <select name="periode" id="periode" class="form-control ml-3">
                <option value="">Pilih</option>
            </select>
        </div>
    </form>

    <div class="ex-basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs">
                        <a href="{{URL::to('/')}}">Home</a>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{URL::to('/struktur')}}">Cascading Struktur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Organization Chart container -->
    <div id="myDiagramDiv" style="background-color: white; border: 1px solid black; height: 550px; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); cursor: auto;"></div>

    <script>
        
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/gojs@2.3.14/release/go.js"></script>
    <script src="{{ asset('js/orgchart2.js') }}"></script>  
@endsection
