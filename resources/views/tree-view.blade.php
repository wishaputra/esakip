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
        #myDiagramDiv {
            width: 100%;
            height: 800px;
            border: 1px solid black;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div id="myDiagramDiv"></div>

    <script src="{{ asset('js/treeview.js') }}"></script>   

    <script>
        // Ensure that the diagram is initialized only once
        var isDiagramInitialized = false;
        function initializeDiagram() {
            if (!isDiagramInitialized) {
                init(); // Call the function to initialize the diagram
                isDiagramInitialized = true;
            }
        }
        window.addEventListener('DOMContentLoaded', initializeDiagram);
    </script>
</body>
</html>
@endsection
