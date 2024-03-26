@extends('layouts.app')
@section('content')


    @section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Organization Chart</title>
    </head>
    <body>
    <div id="allSampleContent" class="p-4 w-full">
    <!-- Organization Chart container -->
    <div id="myDiagramDiv" style="background-color: white; border: 1px solid black; height: 550px; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); cursor: auto;"></div>

        <!-- Buttons -->
         <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
        <button onclick="addNode()" style="margin-right: 5px;">Add Node</button>
        <button onclick="saveChart()">Save Chart</button>
    </div>

        <!-- Properties Panel -->
        <div id="propertiesPanel" style="display: none; background-color: aliceblue; border: solid 1px black">
            <b>Properties</b><br>
            Name: <input type="text" id="name" value="" onchange="updateData(this.value, 'name')"><br>
            Title: <input type="text" id="title" value="" onchange="updateData(this.value, 'title')"><br>
            Comments: <input type="text" id="comments" value="" onchange="updateData(this.value, 'comments')"><br>
        </div>

        <!-- Instructions -->
        <p>Double click on a node in order to add a person. Drag a node onto another in order to change relationships.</p>
    </div>

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
    
    </body>
    </html>
    @endsection