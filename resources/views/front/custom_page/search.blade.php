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
                    <h1>Hasil Pencarian</h1>

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
                        <span>Hasil Pencarian</span>
                    </div> <!-- end of breadcrumbs -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of breadcrumbs -->


    <!-- Privacy Content -->
    <div class="ex-basic-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <!-- <table id="table"  class="table"> -->
                        @if($hasil->count() != 0)
                            <h3>Ditemukan {{ $hasil->count() }} data untuk pencarian "{{ $cari }}" </h3><br><br>
                            @foreach($hasil as $item)
                                {{ $item->date }} <br>
                                {{ $item->title }} <br>
                                <a href="http://103.146.182.171/portal_tpakd/public/page/s/{{ $item->slug }}"><span style="color: blue">Lihat postingan</span></a> <br><br>
                            @endforeach
                        @else
                            Tidak ada data
                        @endif
                    <!-- </table> -->

                </div> <!-- end of col-->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-2 -->
    <!-- end of privacy content -->

@endsection

@push('script')

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> <!-- Custom scripts -->
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script> <!-- Custom scripts -->
<script src="https://cdn.datatables.net/responsive/2.2.7/js/responsive.bootstrap4.min.js"></script> <!-- Custom scripts -->


<script>
    $(document).ready(function() {
    $('#table').DataTable();
} );
</script>

@endpush
