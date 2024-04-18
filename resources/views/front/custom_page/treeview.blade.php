@extends('front.custom_page.layout')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
    <style>
        /* h5, h6 {
            text-align: center;
        } */
        ul, #myUL {
            list-style-type: none;
        }
        #myUL {
            margin: 0;
            padding: 0;
        }
        .caret {
            cursor: pointer;
            -webkit-user-select: none; /* Safari 3.1+ */
            -moz-user-select: none; /* Firefox 2+ */
            -ms-user-select: none; /* IE 10+ */
            user-select: none;
        }
        .caret::before {
            content: "\25B6";
            color: black;
            display: inline-block;
            margin-right: 6px;
        }
        .caret-down::before {
            -ms-transform: rotate(90deg); /* IE 9 */
            -webkit-transform: rotate(90deg); /* Safari */'
            transform: rotate(90deg);  
        }
        .nested {
            display: none;
        }
        .active {
            display: block;
        }
        #myDiagramDiv {
            width: 30%; /* Adjust width as needed */
            height: 500px;
            border: 0.5px solid black;
            overflow: auto;
            float: left; /* Float left to position next to the description box */
        }
            
            /* Style for the description box */
        #descriptionBox {
            width: 70%; /* Adjust width as needed */
            height: 500px;
            border: 0.5px solid black;
            overflow: auto;
            /* padding: 50px; */
        }
    </style>
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
    
    <div class="ex-basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs">
                        <a href="{{URL::to('/')}}">Home</a>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{URL::to('/treeview')}}">Cascading Tree</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" class="form-inline mt-2">
        <div class="form-group mb-3">
            <h5 class="ml-3"><label for="periode">Pilih Periode Tahun</label></h5>
            <select name="periode" id="periode" class="form-control ml-3">
                <option value="">Pilih</option>
                @foreach ($visi as $item)
                    <option value="{{ $item->id }}">{{ $item->tahun_awal }} - {{ $item->tahun_akhir }}</option>
                @endforeach
            </select>
        </div>
    </form>
    
    <!-- Diagram container -->
    <div id="myDiagramDiv">
        <h5 class="ml-3 mt-2">Pohon Kinerja</h5><hr>
        <ul id="myUL">
            <li class="ml-3"><span class="caret" id="visi" onclick="visi()">VISI: {{ $visi }}</span>
                <ul class="nested">
                    <li>MISI: 1</li>
                    <li>Misi: 2</li>
                    <li><span class="caret">Misi: 3</span>
                        <ul class="nested">
                            <li>TUJUAN RPD: 1</li>
                            <li>Tujuan: 2</li>
                            <li><span class="caret">Tujuan: 3</span>
                                <ul class="nested">
                                    <li>SASARAN RPD: 1</li>
                                    <li>Sasaran: 2</li>
                                    <li>Sasaran: 3</li>
                                    <li>Sasaran: 4</li>
                                </ul>
                            </li>
                        </ul>
                    </li> 
                </ul>
            </li>
        </ul>
    </div>
    
    <!-- Description box -->
    <div id="descriptionBox">
        <h5 class="ml-3 mt-2">Detail</h5><hr>
        <h5 style="text-align: center">Kota Tangerang Selatan</h5>
        <h5 style="text-align: center" id="textPeriode">Periode</h5>
        
        {{-- Judul --}}
        <h6 class="ml-3 mt-2" id="judul">Visi</h6>
        
        {{-- Deskripsi --}}
        <p class="ml-3 mt-2" id="deskripsi">Info detail</p>
        
        {{-- Tabel --}}
        
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;
        
        for (i = 0; i < toggler.length; i++) {
          toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
          });
        }

        // Set periode text label
        $('#periode').change(function(){
            document.getElementById("textPeriode").innerHTML = "Periode " + $('#periode').find(":selected").text();;
            console.log("Ubah");
        });

        function visi(){
            document.getElementById("deskripsi").innerHTML = document.getElementById("visi").value;
        }
        
        function misi(){
            document.getElementById("deskripsi").innerHTML = document.getElementById("misi").value;
        }
    </script>
@endsection