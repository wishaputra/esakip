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

        @forelse ($posts as $post)
        <article class="blog_item">
            <div class="blog_item_img">
                <img class="card-img rounded-0" src="{{$post->getImage()}}" alt="{{ $post->title }}">
                <a href="{{ route('main.page.blog',$post->slug)}}" class="blog_item_date">
                    <h3>{{ $post->created_at->isoFormat('D') }}</h3>
                    <p>{{ $post->created_at->isoFormat('MMM') }}</p>
                </a>
            </div>

            <div class="blog_details">
                <a class="d-inline-block" href="{{ route('main.page.blog',$post->slug)}}">
                    <h2>{{ $post->title }}</h2>
                </a>
                <p>{!! Str::words(trim(strip_tags($post->content)),40, ' ...')!!}</p>
                <ul class="blog-info-link">
                    <li><a href="#"><i class="fas fa-user"></i> {{$post->created_by }}</a></li>
                    <li><a href="#"><i class="fas fa-folder"></i> {{$post->category->nama }}</a></li>
                </ul>
            </div>
        </article>
        @empty
        <center>Tidak ada Post</center>
        @endforelse






        <div class="blog-pagination d-flex justify-content-center">
            {!! $posts->links() !!}
        </div>
    </div>

</div>
<!-- end of col-->
<div class="col-lg-4">
    @include('front.partials._category')
</div>
@endsection
@push('scripts')

@endpush
