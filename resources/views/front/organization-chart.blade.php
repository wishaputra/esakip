<!-- Start of Organization Chart Content -->
<div id="allSampleContent" class="p-4 w-full">
    <!-- Organization Chart container -->
    <div id="myDiagramDiv" style="background-color: white; border: 1px solid black; height: 550px; position: relative; cursor: auto;"></div>

    <!-- Additional UI elements specific to the chart, like buttons -->
    
    

<!-- Include the GoJS library and your chart's specific JavaScript -->
<script src="https://unpkg.com/gojs/release/go.js"></script>
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
        url: "/public/save-chart", // Adjust the URL to match your route
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
        url: '/public/load-chart',
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
    <script src="{{ asset('js/orgchart2.js') }}"></script>   