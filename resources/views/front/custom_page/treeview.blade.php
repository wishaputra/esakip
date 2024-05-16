@extends('front.custom_page.layout')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.css" />
  
    <style>
        ul, #myUL {
            list-style-type: none;
        }
        #myUL {
            margin: 0;
            padding: 0;
        }
        .caret {
            cursor: pointer;
            user-select: none;
        }
        .caret::before {
            content: "\25B6";
            color: black;
            display: inline-block;
            margin-right: 6px;
        }
        .caret-down::before {
            transform: rotate(90deg);  
        }
        .nested {
            display: none;
        }
        .active {
            display: block;
        }
        #diagramBox {
            width: 30%;
            height: 500px;
            border: 0.5px solid black;
            overflow: auto;
            float: left;
        }
        #descriptionBox {
            width: 70%;
            height: 500px;
            border: 0.5px solid black;
            overflow: auto;
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

<form action="" class="form-inline mt-4 justify-content-center">
    <div class="form-group mb-3">
        <h5 class="ml-3">Pilih Periode Tahun</h5>
        <select name="periode" id="periode" class="form-control ml-3">
            <option value="">Pilih</option>
            @foreach ($visi as $item)
                <option value="{{ $item->id }}" data-visi="{{ $item->visi }}" data-misi="{{ $item->misi->pluck('misi')->join(', ') }}">
                    {{ $item->tahun_awal }} - {{ $item->tahun_akhir }}
                </option>
            @endforeach
        </select>
    </div>
</form>

<!-- Diagram box -->
<div id="diagramBox">
    <h5 class="ml-3 mt-2">Pohon Kinerja</h5><hr>
    <ul id="myUL">
        <li class="ml-3"><span class="caret" id="visi" onclick="visi()">VISI: </span>
            <ul class="nested">
                <li><span class="caret" id="misi" onclick="misi()">MISI: </span>
                <ul class="nested" id="misiList">
                        <li><span class="caret" id="tujuan" onclick="tujuan()">TUJUAN: </span>
                            <ul class="nested">
                                <li>SASARAN: 1</li>
                                <li>SASARAN: 2</li>
                                <li>SASARAN: 3</li>
                                <li>SASARAN: 4</li>
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
    <h6 class="ml-3 mt-2" id="judul">Visi</h6>
    <p class="ml-3 mt-2" id="deskripsi">Info detail</p>
    <div id="tabel" class="table-responsive mx-3" style="display: none">
        <table class="table table-bordered" id="dataTable">
            <thead class="card-header">
                <tr>
                    <th width="250px">Indikator</th>
                    <th width="90px">Satuan</th>
                    <th width="90px">Tahun 1</th>
                    <th width="90px">Tahun 2</th>
                    <th width="90px">Tahun 3</th>
                    <th width="90px">Tahun 4</th>
                    <th width="90px">Tahun 5</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
<script>
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }

    $('#periode').change(function(){
    var selectedOption = $('#periode').find(":selected");
    var visiText = selectedOption.data('visi');
    var misiText = selectedOption.data('misi').split(', '); // Split the MISI data into an array
    var periodeText = selectedOption.text();
    
    $("#textPeriode").html("Periode " + periodeText);
    $("#visi").html("VISI: " + visiText);
    
    // Update the MISI list
    var misiList = $("#misiList");
    misiList.empty(); // Clear existing list items
    
    misiText.forEach(function(misi) {
        var li = $("<li><span class='caret' onclick='misi()'>MISI: " + misi + "</span></li>");
        misiList.append(li);
    });
});

    // Use event delegation to handle click events for all 'Misi' nodes
    $('#misiList').on('click', 'span.caret', function() {
        $(this).siblings(".nested").toggleClass("active");
        $(this).toggleClass("caret-down");
    });

    function visi(){
        var selectedOption = $('#periode').find(":selected");
        var visiText = selectedOption.data('visi');
        
        $("#judul").html("Visi");
        $("#deskripsi").html(visiText);
    }

    function misi(){
    var selectedMisi = event.target.textContent.replace('MISI: ', ''); // Get the selected MISI text
    
    $("#judul").html("Misi");
    $("#deskripsi").html(selectedMisi); // Update the deskripsi section with the selected MISI
    
    // Toggle the display of the Tujuan node's children
    var tujuanNode = $("#misiList").find("span:contains('TUJUAN')");
    tujuanNode.siblings(".nested").toggleClass("active");
    tujuanNode.toggleClass("caret-down");
}

    function tujuan(){
        var selectedTujuan = event.target.getAttribute('data-tujuan');
        
        $("#judul").html("Tujuan");
        $("#deskripsi").html(selectedTujuan);
        $('#tabel').show();
        $('#dataTable').DataTable();
    }

    function sasaran(){
        var selectedSasaran = event.target.getAttribute('data-sasaran');
        
        $("#judul").html("Sasaran");
        $("#deskripsi").html(selectedSasaran);
        $('#tabel').show();
        $('#dataTable').DataTable();
    }
    
    function program(){
        $("#judul").html("Program");
        $("#deskripsi").html($("#program").text());
        $('#tabel').show();
        $('#dataTable').DataTable();
    }
    
    function kegiatan(){
        $("#judul").html("Kegiatan");
        $("#deskripsi").html($("#kegiatan").text());
        $('#tabel').show();
        $('#dataTable').DataTable();
    }
    
    function subkegiatan(){
        $("#judul").html("Sub Kegiatan");
        $("#deskripsi").html($("#subkegiatan").text());
        $('#tabel').show();
        $('#dataTable').DataTable();
    }
</script>

@endsection
