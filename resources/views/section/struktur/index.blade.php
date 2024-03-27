@extends('layouts.app')
@section('title')
{{ $title }}
@endsection

@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
@endpush

@section('content')

<div class="page has-sidebar-left bg-light">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon-box"></i>
                        {{ $title}}
                    </h4>
                </div>
            </div>
            <div class="row">
                <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                    <li>
                        <a class="nav-link " target="_blank" href="{{ route('main.struktur') }}">
                            <i class="icon icon-eye"></i>treeview</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3 mt-3 shadow r-0">
                            <div class="card-header white"></div>
                            <div class="card-body">
                                <div id="tree"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="form-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form-modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="alert"></div>
                <form class="needs-validation" id="form" method="POST" autocomplete="off" novalidate>
                    {{ method_field('POST') }}
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">No Urut</label>
                        <input type="number" name="order" id="order" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="" class="col-form-label">File</label>
                        <a id="frm_file" style="display: none" href="" target="_blank"> FILE</a>
                        <input type="file" name="file" id="file" placeholder="" class="form-control">
                        <small class="text-danger" id="ket_photo" style="display: none">*Abaikan jika tidak ingin mengganti file</small>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" id="action" class="btn btn-primary tButton">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection


<script>
        var orgChartData = [];
        var myDiagram = null;

        // Function to initialize the diagram
        function init() {
            myDiagram =
                go.GraphObject.make(go.Diagram, "myDiagramDiv", {
                    initialContentAlignment: go.Spot.Center,
                    "undoManager.isEnabled": true,
                    layout: go.GraphObject.make(go.TreeLayout, { angle: 90, layerSpacing: 80 })
                });

            // Define the template for a simple node
            // Define the template for a simple node
            myDiagram.nodeTemplate =
    go.GraphObject.make(go.Node, "Auto",
        go.GraphObject.make(go.Shape, "RoundedRectangle",
            {
                fill: "white", // Background color of node
                portId: "", // Important for linking
                cursor: "pointer" // Cursor style
            }
        )
        // No TextBlock included here means no text will be displayed within the node
    );



            // Define the template for a link
            myDiagram.linkTemplate =
                go.GraphObject.make(go.Link,
                    go.GraphObject.make(go.Shape));

            // Load chart data
            loadChart();
        }

        // Function to add a new node to the organization chart 
        function addNode() {
        var nextKey = (myDiagram.model.nodeDataArray.length + 1).toString();
        var newNodeData = { key: nextKey, name: "", title: "" };
        myDiagram.model.addNodeData(newNodeData);

        // Find the currently selected node
        var selectedNode = myDiagram.selection.first();
        if (selectedNode !== null) {
            // Add a new link between the selected node and the newly created node
            var newLinkData = { from: selectedNode, to: myDiagram.model.findNodeDataForKey(nextKey) };
            myDiagram.model.addLinkData(newLinkData);

            // Add a new link between the parent node and the newly created node
            var parentNode = myDiagram.model.findParentNodeForKey(selectedNode.data.key);
            if (parentNode) {
                var newParentLinkData = { from: parentNode, to: myDiagram.model.findNodeDataForKey(nextKey) };
                myDiagram.model.addLinkData(newParentLinkData);
            }
        }

        // Save the chart data after adding the new node and link
        saveChart();
    }   

        // Function to remove a node from the organization chart
        

        // Function to save the organization chart data
        // Function to save the organization chart data
        function saveChart() {
    var chartData = { nodeDataArray: myDiagram.model.nodeDataArray, linkDataArray: myDiagram.model.linkDataArray };
    var jsonData = JSON.stringify({ chartData: chartData });

    $.ajax({
        type: "POST", // Ensure you're using POST method
        url: "/save-chart", // Adjust the URL to match your route
        data: jsonData,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(response) {
            console.log('Chart data saved successfully:', response);
        },
        error: function(xhr, status, error) {
            console.error('Error saving chart data:', error);
        }
    });
}




function loadChart() {
    $.ajax({
        url: "/load-chart",
        type: 'GET',
        success: function(response) {
            console.log('Chart data loaded successfully', response);
            // Assuming response is the object with nodeDataArray and linkDataArray
            myDiagram.model = new go.GraphLinksModel(response.nodeDataArray, response.linkDataArray);
        },
        error: function(xhr, status, error) {
            console.error('Error loading chart data:', error);
        }
    });
}




        // Load chart data when the page loads
        window.onload = function() {
        loadChart();
    };
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/gojs@2.3.14/release/go.js"></script>
    <script src="{{ asset('js/orgchart.js') }}"></script>   

