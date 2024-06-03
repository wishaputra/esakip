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
                </div>
            </div>
        </div>
    </header>

    <div class="ex-basic-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs">
                        <a href="{{URL::to('/')}}">Home</a>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{URL::to('/struktur')}}">Cascading Struktur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Organization Chart container -->
    <div id="myDiagramDiv" style="background-color: white; border: 1px solid black; height: 550px; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); cursor: auto;"></div>

    <script>
        var myDiagram;

        function init() {
            var $ = go.GraphObject.make;  // for conciseness in defining templates

            myDiagram = $(go.Diagram, "myDiagramDiv",
                {
                    initialContentAlignment: go.Spot.Center,
                    "undoManager.isEnabled": true,
                    layout: $(go.TreeLayout, { angle: 90, layerSpacing: 80 })
                });

            // Define the node template
            myDiagram.nodeTemplate =
                $(go.Node, "Auto",
                    {
                        mouseDragEnter: (e, node, prev) => {
                            var diagram = node.diagram;
                            var selnode = diagram.selection.first();
                            if (!mayWorkFor(selnode, node)) return;
                            var shape = node.findObject("SHAPE");
                            if (shape) shape.fill = "darkred";
                        },
                        mouseDragLeave: (e, node, next) => {
                            var shape = node.findObject("SHAPE");
                            if (shape) shape.fill = "lightgray";
                        },
                        mouseDrop: (e, node) => {
                            var diagram = node.diagram;
                            var selnode = diagram.selection.first();
                            if (mayWorkFor(selnode, node)) {
                                var link = selnode.findTreeParentLink();
                                if (link !== null) {
                                    link.fromNode = node;
                                } else {
                                    diagram.toolManager.linkingTool.insertLink(node, node.port, selnode, selnode.port);
                                }
                            }
                        }
                    },
                    new go.Binding("layerName", "isSelected", sel => sel ? "Foreground" : "").ofObject(),
                    $(go.Shape, "RoundedRectangle",
                        {
                            name: "SHAPE",
                            fill: "lightgray", stroke: "black",
                            portId: "", fromLinkable: true, toLinkable: true, cursor: "pointer",
                            width: 250, height: 90
                        }),
                    $(go.Panel, "Table",
                        {
                            maxSize: new go.Size(150, 999),
                            margin: new go.Margin(3, 3, 0, 3),
                            defaultAlignment: go.Spot.Left
                        },
                        $(go.RowColumnDefinition, { column: 2, width: 4 }),
                        $(go.TextBlock, textStyle(),
                            new go.Binding("text", "type", function(t) { return t === "visi" ? "Visi: " : "Misi: "; }),
                            { row: 0, column: 0, font: "bold 9pt sans-serif" }),
                        $(go.TextBlock, textStyle(),
                            new go.Binding("text", "visi").makeTwoWay(),
                            new go.Binding("visible", "type", function(t) { return t === "visi"; }),
                            { row: 1, column: 0 }),
                        $(go.TextBlock, textStyle(),
                            new go.Binding("text", "misi").makeTwoWay(),
                            new go.Binding("visible", "type", function(t) { return t === "misi"; }),
                            { row: 1, column: 0 })
                    )
                );

            // Define the link template
            myDiagram.linkTemplate =
                $(go.Link,
                    $(go.Shape)
                );

            // Load chart data
            loadChart();
        }

        // Function to load chart data from the server
        function loadChart() {
            $.ajax({
                url: "/load-chart",
                type: 'GET',
                success: function(response) {
                    myDiagram.model = new go.GraphLinksModel(response.nodeDataArray, response.linkDataArray);

                    // Collapse all nodes after the diagram model is set
                    myDiagram.nodes.each(function(node) {
                        node.isTreeExpanded = false;
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Failed to load chart data:', error);
                }
            });
        }

        // Call init function on page load
        $(document).ready(function() {
            init();
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/gojs@2.3.14/release/go.js"></script>
    <script src="{{ asset('js/orgchart2.js') }}"></script>  
@endsection
