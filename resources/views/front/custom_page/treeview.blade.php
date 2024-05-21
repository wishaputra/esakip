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
            <option value="{{ $item->id }}" data-visi="{{ $item->visi }}" data-misi="{{ json_encode($item->misi->map(function($misi) { return ['id' => $misi->id, 'misi' => $misi->misi, 'tujuan' => $misi->tujuan->map(function($tujuan) { return ['id' => $tujuan->id, 'tujuan' => $tujuan->tujuan, 'sasaran' => $tujuan->sasaran->map(function($sasaran) { return ['id' => $sasaran->id, 'sasaran' => $sasaran->sasaran, 'tujuanRenstra' => $sasaran->tujuanRenstra ? $sasaran->tujuanRenstra->pluck('tujuan_renstra') : collect()]; })]; })]; })) }}">
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
                <li><span class="caret" id="misi">MISI: </span>
                    <ul class="nested" id="misiList">
                        <li><span class="caret" id="tujuan">TUJUAN: </span>
                            <ul class="nested" id="tujuanList">
                                <!-- Tujuan items will be populated here dynamically -->
                                <li><span class="caret" id="sasaran">SASARAN: </span>
                                    <ul class="nested" id="sasaranList">
                                        <!-- Sasaran items will be populated here dynamically -->
                                        <li><span class="caret" id="tujuan_renstra">TUJUAN RENSTRA: </span>
                                            <ul class="nested" id="tujuanRenstraList">
                                                <!-- Tujuan Renstra items will be populated here dynamically -->
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
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
    $(document).ready(function() {
    // Handler for selecting a period
    $('#periode').change(function() {
        var selectedOption = $('#periode').find(":selected");
        var visiText = selectedOption.data('visi');
        var misiData = selectedOption.data('misi'); // Get the MISI data from the selected option
        var periodeText = selectedOption.text();

        $("#textPeriode").html("Periode " + periodeText);
        $("#visi").html("VISI: " + visiText);

        // Update the MISI list
        var misiList = $("#misiList");
        misiList.empty(); // Clear existing list items

        misiData.forEach(function(misiItem) {
            var misi = misiItem.misi;
            var tujuan = misiItem.tujuan;
            var li = $("<li><span class='caret misi'>MISI: " + misi + "</span><ul class='nested'></ul></li>");
            var tujuanList = li.find('.nested');
            tujuan.forEach(function(tujuanItem) {
                var tujuanLi = $("<li><span class='caret tujuan' data-tujuanid='" + tujuanItem.id + "'>TUJUAN: " + tujuanItem.tujuan + "</span><ul class='nested'></ul></li>");
                var sasaranList = tujuanLi.find('.nested');
                tujuanItem.sasaran.forEach(function(sasaranItem) {
                    var sasaranLi = $("<li><span class='caret sasaran' data-sasaranid='" + sasaranItem.id + "'>SASARAN: " + sasaranItem.sasaran + "</span><ul class='nested'></ul></li>");
                    var tujuanRenstraList = sasaranLi.find('.nested');
                    sasaranItem.tujuanRenstra.forEach(function(tujuanRenstraItem) {
                        var tujuanRenstraLi = $("<li><span class='tujuan_renstra'>TUJUAN RENSTRA: " + tujuanRenstraItem + "</span></li>");
                        tujuanRenstraList.append(tujuanRenstraLi);
                    });
                    sasaranList.append(sasaranLi);
                });
                tujuanList.append(tujuanLi);
            });
            misiList.append(li);
        });
    });

    // Use event delegation to handle click events for dynamically created 'Misi', 'Tujuan', 'Sasaran', and 'Tujuan Renstra' nodes
    $('#myUL').on('click', 'span.caret', function() {
        $(this).siblings(".nested").toggleClass("active");
        $(this).toggleClass("caret-down");
    });

    $('#myUL').on('click', 'span.misi', function() {
        var selectedMisi = $(this).text().replace('MISI: ', ''); // Get the selected MISI text
        $("#judul").html("Misi");
        $("#deskripsi").html(selectedMisi); // Update the deskripsi section with the selected MISI
    });

    $('#myUL').on('click', 'span.tujuan', function() {
        var selectedTujuan = $(this).text().replace('TUJUAN: ', ''); // Get the selected TUJUAN text
        $("#judul").html("Tujuan");
        $("#deskripsi").html(selectedTujuan); // Update the deskripsi section with the selected TUJUAN
        $('#tabel').show();
    });

    $('#myUL').on('click', 'span.sasaran', function() {
        var selectedSasaran = $(this).text().replace('SASARAN: ', ''); // Get the selected SASARAN text
        $("#judul").html("Sasaran");
        $("#deskripsi").html(selectedSasaran); // Update the deskripsi section with the selected SASARAN
        $('#tabel').show();
    });

    $('#myUL').on('click', 'span.tujuan_renstra', function() {
        var selectedTujuanRenstra = $(this).text().replace('TUJUAN RENSTRA: ', ''); // Get the selected TUJUAN RENSTRA text
        $("#judul").html("Tujuan Renstra");
        $("#deskripsi").html(selectedTujuanRenstra); // Update the deskripsi section with the selected TUJUAN RENSTRA
        $('#tabel').show();
    });
});

function visi() {
    var selectedOption = $('#periode').find(":selected");
    var visiText = selectedOption.data('visi');

    $("#judul").html("Visi");
    $("#deskripsi").html(visiText);
}

function misi() {
    var selectedMisi = event.target.textContent.replace('MISI: ', ''); // Get the selected MISI text

    $("#judul").html("Misi");
    $("#deskripsi").html(selectedMisi); // Update the deskripsi section with the selected MISI

    // Toggle the display of the Tujuan node's children
    var tujuanNode = $("#misiList").find("span:contains('TUJUAN')").parent().find(".nested");
    tujuanNode.toggleClass("active");
    tujuanNode.toggleClass("caret-down");
}

function sasaran() {
    var selectedSasaran = event.target.getAttribute('data-sasaran');

    $("#judul").html("Sasaran");
    $("#deskripsi").html(selectedSasaran);
    $('#tabel').show();
    $('#dataTable').DataTable();
}

function tujuanRenstra() {
    var selectedTujuanRenstra = event.target.textContent.replace('TUJUAN RENSTRA: ', ''); // Get the selected TUJUAN RENSTRA text

    $("#judul").html("Tujuan Renstra");
    $("#deskripsi").html(selectedTujuanRenstra); // Update the deskripsi section with the selected TUJUAN RENSTRA
    $('#tabel').show();
}

function program() {
    $("#judul").html("Program");
    $("#deskripsi").html($("#program").text());
    $('#tabel').show();
    $('#dataTable').DataTable();
}

function kegiatan() {
    $("#judul").html("Kegiatan");
    $("#deskripsi").html($("#kegiatan").text());
    $('#tabel').show();
    $('#dataTable').DataTable();
}

function subkegiatan() {
    $("#judul").html("Sub Kegiatan");
    $("#deskripsi").html($("#subkegiatan").text());
    $('#tabel').show();
    $('#dataTable').DataTable();
}


</script>

@endsection
