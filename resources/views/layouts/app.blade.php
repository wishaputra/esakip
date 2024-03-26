<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }} | {{ $title ?? ''}}</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/myStyle.css') }}">
    <link href="{{ asset('front/evolo/css/fontawesome-all.css')}}" rel="stylesheet">
    <link href="{{ asset('js/_datetimepicker/datetimepicker/css/jquery.datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/tooltipster.bundle.min.css') }}">
    @stack('style')
    
    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }

       
    </style>
</head>

<body class="light">
    <div id="loader" class="loader">
        <div class="plane-container">
            @include('layouts.preloader')
        </div>
    </div>
    <div id="app">
        <aside class="main-sidebar fixed offcanvas shadow" data-toggle='offcanvas'>
            <section class="sidebar">
                <div class="mt-1 mb-1 ml-4 d-flex justify-content-center">
                    <img src="{{ asset('img/logo_tangsel_f.png') }}" alt="" style="max-width:fit-content">
                </div>
                <div class="relative">
                    <a data-toggle="collapse" href="#userSettingsCollapse" role="button" aria-expanded="false"
                        aria-controls="userSettingsCollapse"
                        class="btn-fab btn-fab-sm absolute fab-right-bottom fab-top btn-primary shadow1 ">
                        <i class="icon icon-cogs"></i>
                    </a>
                    <div class="user-panel p-3 light mb-2">
                        <div>
                            <div class="float-left image">
                                @if(Auth::user()->pegawai)
                                <img src="{{ Auth::user()->pegawai->foto == '' ? asset('img/dummy/u1.png') : env('SFTP_SRC').'foto/'.Auth::user()->pegawai->foto }}"
                                    class="user_avatar" alt="User Image">
                                @else
                                <img src="{{ asset('img/dummy/u1.png') }}" class="user_avatar" alt="User Image">
                                @endif
                            </div>
                            <div class="float-left info">
                                <h6 class="font-weight-light mt-2 mb-1">{{ Auth::user()->tmpegawai->n_pegawai ?? Auth::user()->username }}</h6>
                                <a href="#"><i class="icon-circle text-primary blink"></i> Online</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="collapse multi-collapse" id="userSettingsCollapse">
                            <div class="list-group mt-3 shadow">
                                <a href="{{ route('account.profile') }}"
                                    class="list-group-item list-group-item-action"><i
                                        class="mr-2 icon-umbrella text-blue"></i>Profil</a>
                                <a href="{{ route('account.password') }}"
                                    class="list-group-item list-group-item-action"><i
                                        class="mr-2 icon-security text-purple"></i>Ganti Password</a>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="list-group-item list-group-item-action"><i
                                        class="mr-2 icon-power-off text-danger"></i>Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">@csrf</form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('layouts._navigation')
            </section>
        </aside>
        <div class="has-sidebar-left">
            <div class="sticky">
                <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar blue accent-3">
                        <div class="relative">
                                <a href="#" data-toggle="push-menu" class="paper-nav-toggle pp-nav-toggle">
                                    <i></i>
                                </a>
                            </div>
                    <div>

                        <div class="form-inline" id="slc_zonasi_menara" style=" display:none;">


                            {{-- <div class="form-check mb-2 mr-5 ml-4">
                                <form role="search" class="app-search" id="frm_search" method="POST">
                                    <input type="text" placeholder="Latitude,Longitude" class="form-control"
                                        id="id_search_str" style="width:250px;">
                                    <a href="#" onClick="$('#frm_search').submit();"><i
                                            class="icon icon-search"></i></a>
                                </form>

                            </div> --}}





                        </div>
                        <div class="form-inline" id="slc_zona_menara" style=" display:none;">
                            {{-- <div class="form-check mb-2 mr-5 ml-4">
                                        <button class="btn btn-primary" onClick="addDropMarker2();">Tambah</button>
                                    </div> --}}
                            {{-- <div class="form-check mb-2 mr-5">
                                <select name="sl_lyr_np_thn" id="sl_lyr_np_thn">
                                    <option value="2018" selected>2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>

                            </div> --}}


                            {{-- <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_micro">
                                <label class="form-check-label" for="cb_lyr_np_micro">
                                    New Micro

                                </label>
                            </div>

                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_macro">
                                <label class="form-check-label" for="cb_lyr_np_macro">
                                   New Macro
                                </label>
                            </div> --}}


                            {{-- <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_nw_macro">
                                <label class="form-check-label" for="cb_lyr_np_nw_macro">
                                    New Macro

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_nw_micro">
                                <label class="form-check-label" for="cb_lyr_np_nw_micro">
                                    New Micro

                                </label>
                            </div> --}}

                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_ex_macro">
                                <label class="form-check-label" for="cb_lyr_np_ex_macro">
                                    Existing Macro
                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_ex_micro">
                                <label class="form-check-label" for="cb_lyr_np_ex_micro">
                                    Existing Micro

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_nw_macro">
                                <label class="form-check-label" for="cb_lyr_np_nw_macro">
                                    New Macro

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_nw_micro">
                                <label class="form-check-label" for="cb_lyr_np_nw_micro">
                                    New Micro

                                </label>
                            </div>

                            {{-- <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_np_filter_tbg">
                                <label class="form-check-label" for="cb_lyr_np_filter_tbg">
                                    TBG

                                </label>
                            </div>

                            <div class="form-check mb-2 mr-5">
                                <select name="" id="dd_filter_tbg" disabled>
                                    <option value="">* Filter *</option>
                                    <option value="1">TBG</option>
                                    <option value="2">Potensi TBG</option>
                                    <option value="3">TBG + Potensi TBG</option>

                                </select>
                            </div> --}}









                        </div>
                        <div class="form-inline" id="slc_fiber_optik" style=" display:none;">

                            <div class="form-check mb-2 mr-3">
                                <select name="sl_lyr_fo_thn" id="sl_lyr_fo_thn">
                                    <option value="2018" selected>2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>

                            </div>
                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_fo_existing">
                                <label class="form-check-label" for="cb_lyr_fo_existing">
                                    Jalur FO

                                </label>
                            </div>
                            {{-- <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_fo_plan">
                                <label class="form-check-label" for="cb_lyr_fo_plan">
                                    Jalur FO Plan


                                </label>
                            </div> --}}





                        </div>


                        <div class="form-inline" id="slc_tower_existing" style=" display:none;">
                            {{-- <div class="form-check mb-2 mr-3 ml-2">
                                <button class="btn btn-primary" id="tambahTower"
                                    onClick="addDropMarker();">Tambah</button>

                            </div> --}}
                            {{-- <div class="form-check mb-2 mr-3">
                                <select name="sl_lyr_twr_thn" id="sl_lyr_twr_thn">
                                    <option value="2018" selected>2018</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                </select>

                            </div> --}}
                            <div class="form-check mb-2 mr-3 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_twr_tsel">
                                <label class="form-check-label" for="cb_lyr_twr_tsel">
                                    Telkomsel

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_twr_isat">
                                <label class="form-check-label" for="cb_lyr_twr_isat">
                                    Indosat


                                </label>
                            </div>
                            <div class="form-check mb-2 mr-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_twr_xl">
                                <label class="form-check-label" for="cb_lyr_twr_xl">
                                    XL


                                </label>
                            </div>
                            <div class="form-check mb-2 mr-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_twr_hcpt">
                                <label class="form-check-label" for="cb_lyr_twr_hcpt">
                                    H3I


                                </label>
                            </div>
                            <div class="form-check mb-2 mr-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_twr_sf">
                                <label class="form-check-label" for="cb_lyr_twr_sf">
                                    Smartfren


                                </label>
                            </div>
                            <div class="form-check mb-2 mr-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_twr_in">
                                <label class="form-check-label" for="cb_lyr_twr_in">
                                    Internux


                                </label>
                            </div>
                            <div class="form-check mb-2 mr-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_twr_tp">
                                <label class="form-check-label" for="cb_lyr_twr_tp">
                                    Tower Provider


                                </label>
                            </div>

                            <div class="form-check mb-2 mr-4">
                                <select name="" id="dd_flag_tipe_site">
                                    <option value="">* Flag Tipe Site *</option>
                                    <option value="2">Green Field</option>
                                    <option value="1">Rooftop</option>
                                    <option value="4">Unknown</option>

                                </select>
                            </div>




                        </div>

                        <div class="form-inline" id="slc_perbatasan" style=" display:none;">


                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_perbatasan_desa">
                                <label class="form-check-label" for="cb_lyr_perbatasan_desa">
                                    Desa

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_perbatasan_kec">
                                <label class="form-check-label" for="cb_lyr_perbatasan_kec">
                                    Kecamatan


                                </label>
                            </div>






                        </div>

                        <div class="form-inline" id="slc_coverage_plot" style=" display:none;">


                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_covplot_existing">
                                <label class="form-check-label" for="cb_lyr_covplot_existing">
                                    Existing

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_covplot_after_plan">
                                <label class="form-check-label" for="cb_lyr_covplot_after_plan">
                                    After Plan



                                </label>
                            </div>






                        </div>
                        <div class="form-inline" id="slc_jalan" style=" display:none;">


                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_jalan_provinsi">
                                <label class="form-check-label" for="cb_lyr_jalan_provinsi">
                                    Jalan Provinsi

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_jalan_nasional">
                                <label class="form-check-label" for="cb_lyr_jalan_nasional">
                                    Jalan Nasional



                                </label>
                            </div>

                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_jalan_pemkot">
                                <label class="form-check-label" for="cb_lyr_jalan_pemkot">
                                    Jalan Pemkot



                                </label>
                            </div>





                        </div>
                        <div class="form-inline" id="slc_aset_pemerintah" style=" display:none;">

                            {{-- <div class="form-check mb-2 mr-3 ml-2">
                                        <button class="btn btn-primary" id="tambahTower" onClick="addDropMarkerAset();">Tambah</button>
                                   
                                </div> --}}
                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_aset_kantor_pemerintah">
                                <label class="form-check-label" for="cb_lyr_aset_kantor_pemerintah">
                                    Kantor Pemerintah

                                </label>
                            </div>
                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_aset_sarana_kesehatan">
                                <label class="form-check-label" for="cb_lyr_aset_sarana_kesehatan">
                                    Sarana Kesehatan



                                </label>
                            </div>

                            <div class="form-check mb-2 mr-5">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_aset_sarana_pendidikan">
                                <label class="form-check-label" for="cb_lyr_aset_sarana_pendidikan">
                                    Sarana Pendidikan



                                </label>
                            </div>





                        </div>
                        <div class="form-inline" id="slc_imb" style=" display:none;">


                            <div class="form-check mb-2 mr-5 ml-4">
                                <input class="form-check-input" type="checkbox" id="cb_lyr_imb">
                                <label class="form-check-label" for="cb_lyr_imb">
                                    IMB

                                </label>
                            </div>






                        </div>


                        <div class="form-inline" id="div_src_zona" style=" display:none;">
                            <div class="form-check  mr-5 ml-4">
                                <input type='text' class='form-control' placeholder='Latitude,Longitude'
                                    id='frm_src_zona'>
                                    <button class='btn btn-md' style='background-color:transparent;color:white;' onclick="srcZona();">
                                            <i class='icon icon-search3 s-24'></i>
                                         </button>
                                    
                            </div>
                            
                        </div>








                    </div>

                    <!--Top Menu Start -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown custom-dropdown user user-menu ">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    @if(Auth::user()->pegawai)
                                    <img src="{{ Auth::user()->pegawai->foto == '' ? asset('img/dummy/u1.png') : env('SFTP_SRC').'foto/'.Auth::user()->pegawai->foto }}"
                                        class="user-image fotoLink" alt="User Image">
                                    @else
                                    <img src="{{ asset('img/dummy/u1.png') }}" class="user-image fotoLink"
                                        alt="User Image">
                                    @endif
                                    <i class="icon-more_vert "></i>
                                </a>
                                <div class="dropdown-menu p-4 dropdown-menu-right" style="width:255px">
                                    <div class="row box justify-content-between">
                                        <div class="col">
                                            <a href="{{ route('account.profile') }}">
                                                <i class="icon-user amber-text lighten-2 avatar  r-5"></i>
                                                <div class="pt-1">Profil</div>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route('account.password') }}">
                                                <i class="icon-user-secret pink-text lighten-1 avatar  r-5"></i>
                                                <div class="pt-1">Ganti Password</div>
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                class="list-group-item list-group-item-action mt-2"><i
                                                    class="mr-2 icon-power-off text-danger"></i>Logout</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">@csrf</form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{ $slot ?? '' }}
        @yield('content')
    </div>
    <!--/#app -->
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/').'/') !!}
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('js/jquery-fancybox.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/_datetimepicker/datetimepicker/js/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('js/tooltipster.bundle.min.js') }}"></script>
    <script src="{{ asset('js/myScript.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $(document).on("wheel", "input[type=number]", function (e) {
    $(this).blur();
});
    </script>
  
   
    @stack('script')
</body>

</html>