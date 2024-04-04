@extends('front.custom_page.layout')
@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">

@endpush
@section('content')

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
    <div class="ex-basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs">
                        <a href="{{URL::to('/')}}">Home</a>

                    
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{URL::to('/treeview')}}">Tree</a>
                    </div> <!-- end of breadcrumbs -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://unpkg.com/gojs@2.3.16/release/go.js"></script>
    <style>
        /* Style for the diagram container */
        #myDiagramDiv {
            width: 50%; /* Adjust width as needed */
            height: 500px;
            border: 3px solid black;
            overflow: auto;
            float: left; /* Float left to position next to the description box */
        }
        
        /* Style for the description box */
        #descriptionBox {
            width: 50%; /* Adjust width as needed */
            height: 500px;
            border: 3px solid black;
            overflow: auto;
            padding: 50px;
        }

        /* Style for the text block */
        .go-TextBlock {
            white-space: normal;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Diagram container -->
    <div id="myDiagramDiv"></div>
    
    <!-- Description box -->
    <div id="descriptionBox">
        <h2>Description</h2>
        <p id="descriptionContent"></p>
    </div>

    <!-- Include your JavaScript file -->
    <script src="{{ asset('js/treeview.js') }}"></script>
        
</body>
</html>
@endsection