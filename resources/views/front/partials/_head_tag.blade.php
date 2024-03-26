<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ config('app.name', 'Portal TPAKD Kota Tangerang Selatan') }}">
    <meta name="author" content="zhafran">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
    <meta property="og:site_name" content="" /> <!-- website name -->
    <meta property="og:site" content="" /> <!-- website link -->
    <meta property="og:title" content="" /> <!-- title shown in the actual shared post -->
    <meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
    <meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
    <meta property="og:url" content="" /> <!-- where do you want your post to link to -->
    <meta property="og:type" content="article" />

    <!-- Website Title -->
    <title>{{ config('app.name', 'Laravel') }} {{  $title ?? ''}}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,600,700,700i&amp;subset=latin-ext"
        rel="stylesheet">
    <link href="{{ asset('front/evolo/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{ asset('front/evolo/css/fontawesome-all.css')}}" rel="stylesheet">
    <link href="{{ asset('front/evolo/css/swiper.css')}}" rel="stylesheet">
    <link href="{{ asset('front/evolo/css/magnific-popup.css')}}" rel="stylesheet">
    <link href="{{ asset('front/evolo/css/styles.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery-confirm.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/owl/assets/owl.carousel.min.css') }}">

    <!-- Favicon  -->
    <link rel="icon" href="{{ $logo->getImage(2) }}">
    @stack('styles')
    {{-- @yield('styles') --}}
</head>
