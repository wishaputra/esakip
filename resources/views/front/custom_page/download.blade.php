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
                    <h1>{{$title}}</h1>

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

                        @foreach ($breadcrumbs as $b)
                        <i class="fa fa-angle-double-right"></i>
                        <span>{!!$b !!}</span>
                        @endforeach
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
                    <table id="table"  class="table">
                        <thead>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>URL Download</th>
                        </thead>
                        <tbody>
                            @forelse ($files as $key=> $file)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{ $file->nama}}</td>
                                <td><a href="{{ $file->file}}"><i class="fas fa-download"></i></a></td>
                            </tr>
                            @empty
                            {{-- <td colspan="3">Tidak ada data.</td> --}}

                            @endforelse
                        </tbody>
                    </table>

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
