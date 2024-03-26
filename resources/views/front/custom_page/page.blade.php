@extends('front.custom_page.layout')
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">

<style>

@media (min-width: 992px){
.navbar-custom .nav-item .nav-link {

    color: #151010;

}
.navbar-custom .nav-item .nav-link:hover,
    .navbar-custom .nav-item .nav-link.active {
        color: rgb(78, 67, 67);
        opacity: 1;
    }
}
</style>

@endpush
@section('content')


    <!-- Header -->
    <header id="header" class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{$post->title}}</h1>
                    @if ($post->type == 'blog')
                    <ul id="ket_post">
                        <li> <i class="fas fa-user "></i> {{$post->created_by }}</li>
                        <li> <i class="fas fa-clock "></i> {{$post->created_at }}</li>
                        <li> <i class="fas fa-folder "></i> {{$post->category->nama }}</li>
                    </ul>

                    @endif
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->


    <!-- Breadcrumbs -->
    <div class="ex-basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs">
                        <a href="{{URL::to('/')}}">Home</a>
                        <i class="fa fa-angle-double-right"></i>
                        <span>{{ ucfirst(Request::segment(1)) }}</span>
                        <i class="fa fa-angle-double-right"></i>
                        <span>{{$post->title}}</span>
                    </div> <!-- end of breadcrumbs -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of breadcrumbs -->


    <!-- Privacy Content -->
    <div class="ex-basic-2">
        <!-- <div class="container"> -->
            <div class="row mx-5">
                <div class="col-lg-12">
                    <center>
                        <img src="{{ $post->getImage()}}" alt="">
                    </center>
                    <br>
                    @switch($post->id)
                        @case(391)<object data="{{ url('storage/files/triwulan/Bapelitbangda.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(392)<object data="{{ url('storage/files/triwulan/bapenda.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(393)<object data="{{ url('storage/files/triwulan/bkad.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(394)<object data="{{ url('storage/files/triwulan/bkpsdm.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(395)<object data="{{ url('storage/files/triwulan/BPBD.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(396)<object data="{{ url('storage/files/triwulan/capil.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(397)<object data="{{ url('storage/files/triwulan/damkar.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(398)<object data="{{ url('storage/files/triwulan/dcktr.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(399)<object data="{{ url('storage/files/triwulan/dikbud.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(400)<object data="{{ url('storage/files/triwulan/dinkes.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(401)<object data="{{ url('storage/files/triwulan/dinkop.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(402)<object data="{{ url('storage/files/triwulan/dinsos.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(403)<object data="{{ url('storage/files/triwulan/dishub.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(404)<object data="{{ url('storage/files/triwulan/diskominfo.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(405)<object data="{{ url('storage/files/triwulan/disnaker.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(406)<object data="{{ url('storage/files/triwulan/dispar.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(407)<object data="{{ url('storage/files/triwulan/dkppp.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(408)<object data="{{ url('storage/files/triwulan/dlh.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(409)<object data="{{ url('storage/files/triwulan/dsdabmbk.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(410)<object data="{{ url('storage/files/triwulan/indag.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(411)<object data="{{ url('storage/files/triwulan/inspektorat.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(412)<object data="{{ url('storage/files/triwulan/kb.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(413)<object data="{{ url('storage/files/triwulan/kesbangpol.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(414)<object data="{{ url('storage/files/triwulan/kewilayahan1.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(415)<object data="{{ url('storage/files/triwulan/kewilayahan2.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(416)<object data="{{ url('storage/files/triwulan/perkimta.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(417)<object data="{{ url('storage/files/triwulan/perpus.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(418)<object data="{{ url('storage/files/triwulan/pora.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(419)<object data="{{ url('storage/files/triwulan/ptsp.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(420)<object data="{{ url('storage/files/triwulan/satpol.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break
                        
                        @case(421)<object data="{{ url('storage/files/triwulan/setda.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break

                        @case(422)<object data="{{ url('storage/files/triwulan/setwan.pdf') }}" type="application/pdf" width="100%" height="1140px"></object>@break

                        @default <!-- <center>Tidak ada data</center> -->
                    @endswitch
                   {!! $post->content !!}

                </div> <!-- end of col-->
            </div> <!-- end of row -->
        <!-- </div> end of container -->
    </div> <!-- end of ex-basic-2 -->
    <!-- end of privacy content -->


@endsection

@push('script')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> <!-- Custom scripts -->
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script> <!-- Custom scripts -->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script> <!-- Custom scripts -->

<script src="{{ asset('js/myScript.js') }}"></script>

@endpush
