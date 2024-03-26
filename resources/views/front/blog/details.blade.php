@extends('front.basic')

@push('styles')
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

@section('header')
<h1>{{$post->title}}</h1>
                    @if ($post->type == 'blog')
                    <ul id="ket_post">
                        <li> <i class="fas fa-user "></i>&nbsp; {{$post->created_by }}</li>
                        <li> <i class="fas fa-clock "></i> &nbsp; {{$post->created_at->isoFormat('D MMMM Y') }}</li>
                        <li> <i class="fas fa-folder "></i> &nbsp; {{$post->category->nama }}</li>
                    </ul>

                    @endif

@endsection


@section('content')
<div class="col-8">
    <center>
        <img src="{{ $post->getImage()  }}" alt="" class="img-responsive" width="100%">
    </center>
    <br>
    {!! $post->content !!}

</div>
<!-- end of col-->
<div class="col-lg-4">
    @include('front.partials._category')
</div>
@endsection
@push('scripts')

@endpush
