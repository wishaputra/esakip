@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gojs/2.2.8/go.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gojs/2.2.8/goui.js"></script>
    <style>
        /* Style for the diagram container */
        #myDiagramDiv {
            width: 50%; /* Adjust width as needed */
            height: 500px;
            border: 1px solid black;
            overflow: auto;
            float: left; /* Float left to position next to the description box */
        }
        
        /* Style for the description box */
        #descriptionBox {
            width: 50%; /* Adjust width as needed */
            height: 500px;
            border: 1px solid black;
            overflow: auto;
            padding: 10px;
        }
    </style>
</head>
<body>
    <!-- Diagram container -->
    <div id="myDiagramDiv"></div>
    
    <!-- Description box -->
    <div id="descriptionBox">
        <h2>Descriptionnnnn</h2>
        <p id="descriptionContent"></p>
    </div>

    <!-- Include your JavaScript file -->
    <script src="{{ asset('js/treeview.js') }}"></script>   

</body>
</html>
@endsection
