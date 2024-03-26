<!-- Blog -->
@if ($blogs->count() > 0)

@php
$txt = $textContent->where('id',8)->first();
$fr = $frontend->where('file_section','_blog')->first();
@endphp

<div id="Blog" class="basic-4" style="{{ ($fr->order % 2 != 0) ? 'background: url(front/evolo/images/contact-background.jpg) center center no-repeat;
    background-size: cover;'  : '' }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <a href="{{route('main.page.blog_all')}}">
                    <h2>{{ $txt->title }}</h2>
                </a>
                <p class="p-heading p-large">{{ $txt->description }}</p>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="tips-triks-area tips-padding">
            <div class="row">


                @foreach ($blogs as $blog)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="single-tips mb-50">
                        <div class="tips-img">
                            <a href="{{ route('main.page.blog',$blog->slug)}}"><img src="{{ $blog->getImage() }}"
                                    alt=""> </a>
                        </div>
                        <div class="tips-caption">
                            <h6><a href="{{ route('main.page.blog',$blog->slug)}}">{{ $blog->title }}</a></h6>

                            <p>{{$blog->created_at->isoFormat('D MMMM Y') }}</p>
                        </div>
                    </div>
                </div>
                @endforeach



            </div>
        </div>
        {{-- @if ($teams->count() > 4) --}}
        <div class="row mt-2">
            <a id="btnTeam" href="{{ route('main.page.blog_all')}}" class="btn btn-secondary">
                Lihat Semua
            </a>
        </div><!-- end of row -->
        {{-- @endif --}}
    </div> <!-- end of container -->
</div> <!-- end of basic-4 -->

@endif
