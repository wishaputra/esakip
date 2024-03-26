@php
$txt = $textContent->where('id',12)->first();
$fr = $frontend->where('file_section','_cat_business')->first();
@endphp

<div id="category-businesses" class="basic-4" style="{{ ($fr->order % 2 != 0) ? 'background: url(front/evolo/images/contact-background.jpg) center center no-repeat;
    background-size: cover;'  : '' }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ $txt->title }}</h2>
                <p class="p-heading p-large">{{ $txt->description }}</p>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            @foreach ($cat_business as $cb)
            <div class="col-lg-2 col-sm-12">
                <div class="card card-b">

                    <div class="card-body-b">
                        <a href="{{ $cb->type == 'url' ? URL::to($cb->url) : route('main.page.category_business',$cb->slug)}}">
                            <i class="{{ $cb->icon }}  busines-icon"></i>
                            <h6>{{ $cb->name }}</h6>
                            {{-- <p>0 places</p> --}}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            @if ($cat_business->count() == 11)
            <div class="col-lg-2 col-sm-12">
                <div class="card card-b">

                    <div class="card-body-b">
                        <a href="{{ route('main.page.business_all') }}">
                            <i class="fas fa-align-justify  busines-icon"></i>
                            <h6>More Categories</h6>
                        </a>
                    </div>
                </div>
            </div>
            @endif



        </div>
        {{-- @if ($teams->count() > 4)
        <div class="row">
            <a id="btnTeam" href="{{ route('main.team')}}" class="btn btn-secondary">
        Lihat Selengkapnya
        </a>
    </div><!-- end of row -->
    @endif --}}

</div> <!-- end of container -->
</div> <!-- end of basic-4 -->
