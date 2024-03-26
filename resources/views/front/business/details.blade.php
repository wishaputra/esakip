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
<h1>{{$business->title}}</h1>
                    @if ($business->type == 'business')
                    <ul id="ket_post">
                        <li> <i class="fas fa-user "></i>&nbsp; {{$business->created_by }}</li>
                        <li> <i class="fas fa-clock "></i> &nbsp; {{$business->created_at->isoFormat('D MMMM Y') }}</li>
                        <li> <i class="fas fa-folder "></i> &nbsp; {{$business->category->name }}</li>
                    </ul>

                    @endif

@endsection


@section('content')
<div class="col-8">
    <center>
        <img src="{{ $business->getImage() }}" alt="" class="img-responsive" width="100%">
    </center>

    <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">

        <li class="nav-item">
          <a class="nav-link active" id="pills-content-1-tab" data-toggle="pill" href="#pills-content-1" role="tab" aria-controls="pills-content-1" aria-selected="true">{{ $business->tab_content}}</a>
        </li>
        @if ($business->tab_content_2)
        <li class="nav-item">
            <a class="nav-link " id="pills-content-2-tab" data-toggle="pill" href="#pills-content-2" role="tab" aria-controls="pills-content-2" aria-selected="true">{{ $business->tab_content_2}}</a>
          </li>
        @endif

        @if ($business->tab_content_3)
        <li class="nav-item">
          <a class="nav-link " id="pills-content-3-tab" data-toggle="pill" href="#pills-content-3" role="tab" aria-controls="pills-content-3" aria-selected="true">{{ $business->tab_content_3}}</a>
        </li>
        @endif
        @if ($business->tab_content_4)
        <li class="nav-item">
          <a class="nav-link " id="pills-content-4-tab" data-toggle="pill" href="#pills-content-4" role="tab" aria-controls="pills-content-4" aria-selected="true">{{ $business->tab_content_4}}</a>
        </li>
        @endif
        @if ($business->tab_content_5)
        <li class="nav-item">
          <a class="nav-link " id="pills-content-5-tab" data-toggle="pill" href="#pills-content-5" role="tab" aria-controls="pills-content-5" aria-selected="true">{{ $business->tab_content_5}}</a>
        </li>
        @endif



      </ul>
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-content-1" role="tabpanel" aria-labelledby="pills-content-1-tab">{!! $business->content !!}</div>
        <div class="tab-pane fade " id="pills-content-2" role="tabpanel" aria-labelledby="pills-content-2-tab">{!! $business->content_2 !!}</div>
        <div class="tab-pane fade " id="pills-content-3" role="tabpanel" aria-labelledby="pills-content-3-tab">{!! $business->content_3 !!}</div>
        <div class="tab-pane fade " id="pills-content-4" role="tabpanel" aria-labelledby="pills-content-4-tab">{!! $business->content_4 !!}</div>
        <div class="tab-pane fade " id="pills-content-5" role="tabpanel" aria-labelledby="pills-content-5-tab">{!! $business->content_5 !!}</div>

      </div>



</div>
<!-- end of col-->
<div class="col-lg-4">
    @include('front.partials._category_business')
</div>
@endsection
@push('scripts')

@endpush
