@extends('front.basic')

@push('styles')
<style>
    .basic-4{
        padding-top: 0;
        padding-bottom: 0;
    }
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

@section('header')
<h1>{{$title}}</h1>


@endsection


@section('content')


    <div id="about" class="basic-4">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    @foreach ($teams as $team)
                    <div class="team-member">
                        <div class="image-wrapper">
                            <img class="img-fluid" src="{{ asset($team->poto)}}" alt="alternative">
                        </div> <!-- end of image-wrapper -->
                        <p class="p-large"><strong>{{ $team->nama}}</strong></p>
                        <p class="job-title">{{ $team->jabatan}}</p>
                        <span class="social-icons">
                            @if ($team->facebook_link)
                            <span class="fa-stack">
                                <a href="{{$team->facebook_link}}">
                                    <i class="fas fa-circle fa-stack-2x facebook"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x"></i>
                                </a>
                            </span>
                            @endif
                            @if ($team->twitter_link)
                            <span class="fa-stack">
                                <a href="{{$team->twitter_link}}">
                                    <i class="fas fa-circle fa-stack-2x twitter"></i>
                                    <i class="fab fa-twitter fa-stack-1x"></i>
                                </a>
                            </span>
                            @endif


                        </span> <!-- end of social-icons -->
                    </div>
                    @endforeach




                </div> <!-- end of col -->
            </div>


        </div> <!-- end of container -->
    </div>


@endsection
@push('scripts')

@endpush
