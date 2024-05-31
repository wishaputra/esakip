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
    <option value="{{ $item->id }}" 
            data-visi="{{ $item->visi }}" 
            data-misi="{{ json_encode($item->misi->map(function($misi) {
                return [
                    'id' => $misi->id,
                    'misi' => $misi->misi,
                    'tujuan' => $misi->tujuan->map(function($tujuan) {
                        return [
                            'id' => $tujuan->id,
                            'tujuan' => $tujuan->tujuan,
                            'sasaran' => $tujuan->sasaran->map(function($sasaran) {
                                return [
                                    'id' => $sasaran->id,
                                    'sasaran' => $sasaran->sasaran,
                                    'tujuanRenstra' => $sasaran->tujuanRenstra ? $sasaran->tujuanRenstra->map(function($tujuanRenstra) {
                                        return [
                                            'id' => $tujuanRenstra->id,
                                            'tujuan_renstra' => $tujuanRenstra->tujuan_renstra,
                                            'sasaranRenstra' => $tujuanRenstra->cascading_sasaran_renstra ? $tujuanRenstra->cascading_sasaran_renstra->map(function($sasaranRenstra) {
                                                return [
                                                    'id' => $sasaranRenstra->id,
                                                    'sasaran_renstra' => $sasaranRenstra->sasaran_renstra,
                                                    'program' => $sasaranRenstra->cascading_program ? $sasaranRenstra->cascading_program->map(function($program) {
                                                        return [
                                                            'id' => $program->id, 
                                                            'program' => $program->program, 
                                                            'kegiatan' => $program->cascading_kegiatan ? $program->cascading_kegiatan->map(function($kegiatan) {
                                                                return [
                                                                    'id' => $kegiatan->id, 
                                                                    'kegiatan' => $kegiatan->kegiatan, 
                                                                    'sub_kegiatan' => $kegiatan->cascading_sub_kegiatan ? $kegiatan->cascading_sub_kegiatan->pluck('sub_kegiatan') : collect()
                                                                ];
                                                            }) : collect()
                                                        ];
                                                    }) : collect()
                                                ];
                                            }) : collect()
                                        ];
                                    }) : collect()
                                ];
                            })
                        ];
                    })
                ];
            })) }}">
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
                                                <li><span class="caret" id="sasaran_renstra">SASARAN RENSTRA: </span>
                                                    <ul class="nested" id="sasaranRenstraList">
                                                        <!-- Sasaran Renstra items will be populated here dynamically -->
                                                        <li><span class="caret" id="program">PROGRAM: </span>
                                                            <ul class="nested" id="programList">
                                                                <!-- Program items will be populated here dynamically -->
                                                                <li><span class="caret" id="kegiatan">KEGIATAN: </span>
                                                                    <ul class="nested" id="kegiatanList">
                                                                <!-- Kegiatan items will be populated here dynamically -->
                                                                <li><span class="caret" id="sub_kegiatan">SUB KEGIATAN: </span></li>
                                                                    <ul class="nested" id="subKegiatanList">
                                                                        <!-- Sub Kegiatan items will be populated here dynamically -->
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
    <div id="tabel" class="table-responsive mx-3" style="display: none;">
        <table class="table table-bordered" id="dataTable">
            <thead class="card-header">
                <tr>
                    <th width="250px">Indikator</th>
                    <th width="90px">Satuan</th>
                    <th width="90px">Tahun </th>
                    <th width="90px">Target</th>
                    <th width="90px">Capaian</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be populated by JavaScript -->
            </tbody>
        </table>
    </div>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
<script>
$(document).ready(function() {
    $('#periode').change(function() {
        var selectedOption = $('#periode').find(":selected");
        var visiText = selectedOption.data('visi');
        var misiData = selectedOption.data('misi');
        var periodeText = selectedOption.text();

        $("#textPeriode").html("Periode " + periodeText);
        $("#visi").html("VISI: " + visiText);

        // Update the MISI list
        var misiList = $("#misiList");
        misiList.empty();

        console.log(misiData); // Debugging statement

        misiData.forEach(function(misiItem) {
            var misi = misiItem.misi;
            var tujuan = misiItem.tujuan;
            var li = $("<li><span class='caret misi'>MISI: " + misi + "</span><ul class='nested'></ul></li>");
            var tujuanList = li.find('.nested');

            tujuan.forEach(function(tujuanItem) {
            var tujuanText = tujuanItem.tujuan;
            var sasaran = tujuanItem.sasaran;
            var tujuanLi = $("<li><span class='caret tujuan' data-id='" + tujuanItem.id + "'>TUJUAN: " + tujuanText + "</span><ul class='nested'></ul></li>");
            var sasaranList = tujuanLi.find('.nested');

                sasaran.forEach(function(sasaranItem) {
                    var sasaranText = sasaranItem.sasaran;
                    var tujuanRenstra = sasaranItem.tujuanRenstra;
                    var sasaranLi = $("<li><span class='caret sasaran' data-id='" + sasaranItem.id + "'>SASARAN: " + sasaranText + "</span><ul class='nested'></ul></li>");
                    var tujuanRenstraList = sasaranLi.find('.nested');

                    tujuanRenstra.forEach(function(tujuanRenstraItem) {
                        var tujuanRenstraText = tujuanRenstraItem.tujuan_renstra;
                        var sasaranRenstra = tujuanRenstraItem.sasaranRenstra;
                        var tujuanRenstraLi = $("<li><span class='caret tujuanRenstra' data-id='" + tujuanRenstraItem.id + "'>TUJUAN RENSTRA: " + tujuanRenstraText + "</span><ul class='nested'></ul></li>");
                        var sasaranRenstraList = tujuanRenstraLi.find('.nested');

                        sasaranRenstra.forEach(function(sasaranRenstraItem) {
                            var sasaranRenstraText = sasaranRenstraItem.sasaran_renstra;
                            var program = sasaranRenstraItem.program;
                            var sasaranRenstraLi = $("<li><span class='caret sasaranRenstra' data-id='" + sasaranRenstraItem.id + "'>SASARAN RENSTRA: " + sasaranRenstraText + "</span><ul class='nested'></ul></li>");
                            var programList = sasaranRenstraLi.find('.nested');

                        
                            program.forEach(function(programItem) {
                                var programText = programItem.program;
                                var kegiatan = programItem.kegiatan;
                                var programLi = $("<li><span class='caret program' data-id='" + programItem.id + "'>PROGRAM: " + programText + "</span><ul class='nested'></ul></li>");
                                var kegiatanList = programLi.find('.nested');

                                kegiatan.forEach(function(kegiatanItem) {
                                    var kegiatanText = kegiatanItem.kegiatan;
                                    var sub_kegiatan = kegiatanItem.sub_kegiatan;
                                    var kegiatanLi = $("<li><span class='caret kegiatan' data-id='" + kegiatanItem.id + "'>KEGIATAN: " + kegiatanText + "</span><ul class='nested'></ul></li>");
                                    var subKegiatanList = kegiatanLi.find('.nested');

                                    sub_kegiatan.forEach(function(subKegiatanItem) {
                                        var subKegiatanLi = $("<li><span class='caret sub_kegiatan'>SUB KEGIATAN: " + subKegiatanItem + "</span></li>");
                                        subKegiatanList.append(subKegiatanLi);
                                    });

                                    kegiatanList.append(kegiatanLi);
                                });

                                programList.append(programLi);
                            });
                    

                            sasaranRenstraList.append(sasaranRenstraLi);
                        });

                        tujuanRenstraList.append(tujuanRenstraLi);
                    });

                    sasaranList.append(sasaranLi);
                });

                tujuanList.append(tujuanLi);
            });

            misiList.append(li);
        });
    });

    $('#myUL').on('click', 'span.caret', function() {
        $(this).siblings(".nested").toggleClass("active");
        $(this).toggleClass("caret-down");
    });

    $('#myUL').on('click', 'span.misi', function() {
        var selectedMisi = $(this).text().replace('MISI: ', '');
        $("#judul").html("Misi");
        $("#deskripsi").html(selectedMisi);
    });

    $('#myUL').on('click', 'span.tujuan', function() {
    var selectedTujuan = $(this).text().replace('TUJUAN: ', '');
    var tujuanId = $(this).data('id');  // Assume you store the ID as a data attribute
    $("#judul").html("Tujuan");
    $("#deskripsi").html(selectedTujuan);
    $('#tabel').show();

    var indikatorData = [];
    var nilaiData = [];

    // Fetch Indikator data
    $.ajax({
        url: '/getTujuanIndikator/' + tujuanId,
        method: 'GET',
        success: function(response) {
            indikatorData = response;
            populateTable(indikatorData, nilaiData);
        },
        error: function() {
            console.log('Error fetching indikator data');
        }
    });

    // Fetch Nilai data
    $.ajax({
        url: '/getTujuanNilai/' + tujuanId,
        method: 'GET',
        success: function(response) {
            nilaiData = response;
            populateTable(indikatorData, nilaiData);
        },
        error: function() {
            console.log('Error fetching nilai data');
        }
    });

    function populateTable(indikators, nilais) {
        var tableBody = $('#dataTable tbody');
        tableBody.empty(); // Clear existing rows

        var nilaiMap = {}; // Create a map for quick lookup of nilai data by indikator ID
        nilais.forEach(function(nilai) {
            nilaiMap[nilai.id_indikator_tujuan] = nilai;
        });

        indikators.forEach(function(indikator) {
            var nilai = nilaiMap[indikator.id] || {}; // Get the corresponding nilai or default to empty
            var row = '<tr>' +
                '<td>' + indikator.indikator + '</td>' +
                '<td>' + (nilai.satuan || '') + '</td>' +
                '<td>' + (nilai.tahun || '') + '</td>' +
                '<td>' + (nilai.target || '') + '</td>' +
                '<td>' + (nilai.capaian || '') + '</td>' +
                '</tr>';
            tableBody.append(row);
        });
    }
});



$('#myUL').on('click', 'span.sasaran', function() {
    var selectedSasaran = $(this).text().replace('SASARAN: ', '');
    var sasaranId = $(this).data('id');  // Assume you store the ID as a data attribute
    $("#judul").html("Sasaran");
    $("#deskripsi").html(selectedSasaran);
    $('#tabel').show();

    var indikatorData = [];
    var nilaiData = [];

    // Fetch Indikator data
    $.ajax({
        url: '/getSasaranIndikator/' + sasaranId,
        method: 'GET',
        success: function(response) {
            indikatorData = response;
            populateTable(indikatorData, nilaiData);
        },
        error: function() {
            console.log('Error fetching indikator data');
        }
    });

    // Fetch Nilai data
    $.ajax({
        url: '/getSasaranNilai/' + sasaranId,
        method: 'GET',
        success: function(response) {
            nilaiData = response;
            populateTable(indikatorData, nilaiData);
        },
        error: function() {
            console.log('Error fetching nilai data');
        }
    });

    function populateTable(indikators, nilais) {
        var tableBody = $('#dataTable tbody');
        tableBody.empty(); // Clear existing rows

        var nilaiMap = {}; // Create a map for quick lookup of nilai data by indikator ID
        nilais.forEach(function(nilai) {
            nilaiMap[nilai.id_indikator_sasaran] = nilai;
        });

        indikators.forEach(function(indikator) {
            var nilai = nilaiMap[indikator.id] || {}; // Get the corresponding nilai or default to empty
            var row = '<tr>' +
                '<td>' + indikator.indikator + '</td>' +
                '<td>' + (nilai.satuan || '') + '</td>' +
                '<td>' + (nilai.tahun || '') + '</td>' +
                '<td>' + (nilai.target || '') + '</td>' +
                '<td>' + (nilai.capaian || '') + '</td>' +
                '</tr>';
            tableBody.append(row);
        });
    }
});

$('#myUL').on('click', 'span.tujuanRenstra', function() {
        var selectedTujuanRenstra = $(this).text().replace('TUJUAN RENSTRA: ', '');
        var tujuanRenstraId = $(this).data('id');  // Assume you store the ID as a data attribute
        $("#judul").html("Tujuan Renstra");
        $("#deskripsi").html(selectedTujuanRenstra);
        $('#tabel').show();

        var indikatorData = [];
        var nilaiData = [];

        // Fetch Indikator data
        $.ajax({
            url: '/getTujuanRenstraIndikator/' + tujuanRenstraId,
            method: 'GET',
            success: function(response) {
                indikatorData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching indikator data');
            }
        });

        // Fetch Nilai data
        $.ajax({
            url: '/getTujuanRenstraNilai/' + tujuanRenstraId,
            method: 'GET',
            success: function(response) {
                nilaiData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching nilai data');
            }
        });

        function populateTable(indikators, nilais) {
            var tableBody = $('#dataTable tbody');
            tableBody.empty(); // Clear existing rows

            var nilaiMap = {}; // Create a map for quick lookup of nilai data by indikator ID
            nilais.forEach(function(nilai) {
                nilaiMap[nilai.id_indikator_tujuan_renstra] = nilai;
            });

            indikators.forEach(function(indikator) {
                var nilai = nilaiMap[indikator.id] || {}; // Get the corresponding nilai or default to empty
                var row = '<tr>' +
                    '<td>' + indikator.indikator + '</td>' +
                    '<td>' + (nilai.satuan || '') + '</td>' +
                    '<td>' + (nilai.tahun || '') + '</td>' +
                    '<td>' + (nilai.target || '') + '</td>' +
                    '<td>' + (nilai.capaian || '') + '</td>' +
                    '</tr>';
                tableBody.append(row);
            });
        }
    });

   
    $('#myUL').on('click', 'span.sasaranRenstra', function() {
        var selectedSasaranRenstra = $(this).text().replace('SASARAN RENSTRA: ', '');
        var sasaranRenstraId = $(this).data('id');  // Assume you store the ID as a data attribute
        $("#judul").html("Sasaran Renstra");
        $("#deskripsi").html(selectedSasaranRenstra);
        $('#tabel').show();

        var indikatorData = [];
        var nilaiData = [];

        // Fetch Indikator data
        $.ajax({
            url: '/getSasaranRenstraIndikator/' + sasaranRenstraId,
            method: 'GET',
            success: function(response) {
                indikatorData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching indikator data');
            }
        });

        // Fetch Nilai data
        $.ajax({
            url: '/getSasaranRenstraNilai/' + sasaranRenstraId,
            method: 'GET',
            success: function(response) {
                nilaiData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching nilai data');
            }
        });

        function populateTable(indikators, nilais) {
            var tableBody = $('#dataTable tbody');
            tableBody.empty(); // Clear existing rows

            var nilaiMap = {}; // Create a map for quick lookup of nilai data by indikator ID
            nilais.forEach(function(nilai) {
                nilaiMap[nilai.id_indikator_sasaran_renstra] = nilai;
            });

            indikators.forEach(function(indikator) {
                var nilai = nilaiMap[indikator.id] || {}; // Get the corresponding nilai or default to empty
                var row = '<tr>' +
                    '<td>' + indikator.indikator + '</td>' +
                    '<td>' + (nilai.satuan || '') + '</td>' +
                    '<td>' + (nilai.tahun || '') + '</td>' +
                    '<td>' + (nilai.target || '') + '</td>' +
                    '<td>' + (nilai.capaian || '') + '</td>' +
                    '</tr>';
                tableBody.append(row);
            });
        }
    });


    $('#myUL').on('click', 'span.program', function() {
        var selectedProgram = $(this).text().replace('PROGRAM: ', '');
        var programId = $(this).data('id');
        $("#judul").html("Program");
        $("#deskripsi").html(selectedProgram);
        $('#tabel').show();

        var indikatorData = [];
        var nilaiData = [];

        // Fetch Indikator data
        $.ajax({
            url: '/getProgramIndikator/' + programId,
            method: 'GET',
            success: function(response) {
                indikatorData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching indikator data');
            }
        });

        // Fetch Nilai data
        $.ajax({
            url: '/getProgramNilai/' + programId,
            method: 'GET',
            success: function(response) {
                nilaiData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching nilai data');
            }
        });

        function populateTable(indikators, nilais) {
            var tableBody = $('#dataTable tbody');
            tableBody.empty();

            var nilaiMap = {};
            nilais.forEach(function(nilai) {
                nilaiMap[nilai.id_indikator_program] = nilai;
            });

            indikators.forEach(function(indikator) {
                var nilai = nilaiMap[indikator.id] || {};
                var row = '<tr>' +
                    '<td>' + indikator.indikator + '</td>' +
                    '<td>' + (nilai.satuan || '') + '</td>' +
                    '<td>' + (nilai.tahun || '') + '</td>' +
                    '<td>' + (nilai.target || '') + '</td>' +
                    '<td>' + (nilai.capaian || '') + '</td>' +
                    '</tr>';
                tableBody.append(row);
            });
        }
    });

    
    $('#myUL').on('click', 'span.kegiatan', function() {
        var selectedKegiatan = $(this).text().replace('KEGIATAN: ', '');
        var kegiatanId = $(this).data('id');
        $("#judul").html("Kegiatan");
        $("#deskripsi").html(selectedKegiatan);
        $('#tabel').show();

        var indikatorData = [];
        var nilaiData = [];

        // Fetch Indikator data
        $.ajax({
            url: '/getKegiatanIndikator/' + kegiatanId,
            method: 'GET',
            success: function(response) {
                indikatorData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching indikator data');
            }
        });

        // Fetch Nilai data
        $.ajax({
            url: '/getKegiatanNilai/' + kegiatanId,
            method: 'GET',
            success: function(response) {
                nilaiData = response;
                populateTable(indikatorData, nilaiData);
            },
            error: function() {
                console.log('Error fetching nilai data');
            }
        });

        function populateTable(indikators, nilais) {
            var tableBody = $('#dataTable tbody');
            tableBody.empty();

            var nilaiMap = {};
            nilais.forEach(function(nilai) {
                nilaiMap[nilai.id_indikator_kegiatan] = nilai;
            });

            indikators.forEach(function(indikator) {
                var nilai = nilaiMap[indikator.id] || {};
                var row = '<tr>' +
                    '<td>' + indikator.indikator + '</td>' +
                    '<td>' + (nilai.satuan || '') + '</td>' +
                    '<td>' + (nilai.tahun || '') + '</td>' +
                    '<td>' + (nilai.target || '') + '</td>' +
                    '<td>' + (nilai.capaian || '') + '</td>' +
                    '</tr>';
                tableBody.append(row);
            });
        }
    });
    

    $('#myUL').on('click', 'span.sub_kegiatan', function() {
        var selectedSubKegiatan = $(this).text().replace('SUB KEGIATAN: ', '');
        $("#judul").html("Sub Kegiatan");
        $("#deskripsi").html(selectedSubKegiatan);
        $('#tabel').show();
    });
});


</script>

@endsection
