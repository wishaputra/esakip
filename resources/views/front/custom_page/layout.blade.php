@php
    $textContent = App\Models\TextContent::all();
@endphp

@include('front.partials._head_tag')

<body data-spy="scroll" data-target=".fixed-top">

    <!-- Preloader -->
	<div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->


  @include('front.partials._navigation')

@yield('content')





    @include('front.partials._footer')



