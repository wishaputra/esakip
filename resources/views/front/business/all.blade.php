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
<h1>{{$title}}</h1>


@endsection


@section('content')
<div class="col-8">
    <div class="blog_left_sidebar">

        @forelse ($businesses as $b)
        <article class="blog_item">
            <div class="blog_item_img">
                <img class="card-img rounded-0" src="{{ $b->getImage() }}" alt="{{ $b->title }}">
                <a href="{{ route('main.page.business',$b->slug)}}" class="blog_item_date">
                    <h3>{{ $b->created_at->isoFormat('D') }}</h3>
                    <p>{{ $b->created_at->isoFormat('MMM') }}</p>
                </a>
            </div>

            <div class="blog_details">
                <a class="d-inline-block" href="{{ route('main.page.business',$b->slug)}}">
                    <h2>{{ $b->title }}</h2>
                </a>
                <p>{!! Str::words(trim(strip_tags($b->content)),40, ' ...')!!}</p>
                <ul class="blog-info-link">
                    <li><a href="#"><i class="fas fa-user"></i> {{$b->created_by }}</a></li>
                    <li><a href="{{ route('main.page.category_business',$b->category->slug)}}"><i class="fas fa-folder"></i> {{$b->category->name }}</a></li>
                </ul>
            </div>
        </article>
        @empty
        <center>Tidak ada data</center>
        @endforelse






        <div class="blog-pagination d-flex justify-content-center">
            {!! $businesses->links() !!}
        </div>
    </div>

</div>
<!-- end of col-->
<div class="col-lg-4">
    @include('front.partials._category_business')
</div>
@endsection
@push('scripts')

@endpush
