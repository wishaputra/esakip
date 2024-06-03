function init() {
  const $ = go.GraphObject.make;  
  myDiagram = new go.Diagram("myDiagramDiv", {
    validCycle: go.Diagram.CycleDestinationTree,
    maxSelectionCount: 1,
    layout: $(go.TreeLayout, {
      treeStyle: go.TreeLayout.StyleLastParents,
      arrangement: go.TreeLayout.ArrangementHorizontal,
      angle: 90,
      layerSpacing: 35,
      alternateAngle: 0,
      alternateLayerSpacing: 35,
      alternateAlignment: go.TreeLayout.AlignmentStart,
      alternateNodeIndent: 10,
      alternateNodeIndentPastParent: 1.0,
      alternateNodeSpacing: 10,
      alternateLayerSpacing: 30,
      alternateLayerSpacingParentOverlap: 1.0,
      alternatePortSpot: new go.Spot(0.01, 1, 10, 0),
      alternateChildPortSpot: go.Spot.Left
    }),
    "ChangedSelection": onSelectionChanged,
    "TextEdited": onTextEdited,
    "linkingTool.archetypeLinkData": { category: "Support", text: "100%" },
    "undoManager.isEnabled": true
  });

  myDiagram.addDiagramListener("Modified", e => {
    var button = document.getElementById("SaveButton");
    if (button) button.disabled = !myDiagram.isModified;
    var idx = document.title.indexOf("*");
    if (myDiagram.isModified) {
      if (idx < 0) document.title += "*";
    } else {
      if (idx >= 0) document.title = document.title.slice(0, idx);
    }
  });

  var graygrad = $(go.Brush, "Linear",
    { 0: "rgb(125, 125, 125)", 0.5: "rgb(86, 86, 86)", 1: "rgb(86, 86, 86)" });

  function mayWorkFor(node1, node2) {
    if (!(node1 instanceof go.Node)) return false;  
    if (node1 === node2) return false;  
    if (node2.isInTreeOf(node1)) return false;  
    return true;
  }

  function textStyle() {
    return { font: "9pt sans-serif", stroke: "white" };
  }

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
        if (shape) shape.fill = graygrad;
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
        fill: graygrad, stroke: "black",
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
      $(go.TextBlock, "Visi: ", textStyle(),
        { row: 2, column: 0, font: "bold 9pt sans-serif" },
        new go.Binding("text", "visi").makeTwoWay())
      )
    );

  myDiagram.linkTemplate =
    $(go.Link, go.Link.Orthogonal,
      { corner: 5 },
      $(go.Shape, { strokeWidth: 2 }));

  myDiagram.linkTemplateMap.add("Support",
    $(go.Link, go.Link.Bezier,
      { isLayoutPositioned: false, isTreeLink: false, curviness: -50 },
      { relinkableFrom: true, relinkableTo: true },
      $(go.Shape,
        { stroke: "green", strokeWidth: 2 }),
      $(go.Shape,
        { toArrow: "OpenTriangle", stroke: "green", strokeWidth: 2 }),
      $(go.TextBlock,
        new go.Binding("text").makeTwoWay(),
        {
          stroke: "green", background: "rgba(255,255,255,0.75)",
          maxSize: new go.Size(80, NaN), editable: true
        })));

  loadChart();
}

function onSelectionChanged(e) {
  var node = e.diagram.selection.first();
  if (node instanceof go.Node) {
    updateProperties(node.data);
  } else {
    updateProperties(null);
  }
}

function onTextEdited(e) {
  var tb = e.subject;
  if (tb === null || !tb.name) return;
  var node = tb.part;
  if (node instanceof go.Node) {
    updateData(tb.text, tb.name);
    updateProperties(node.data);
  }
}

function updateData(text, field) {
  var node = myDiagram.selection.first();
  var data = node.data;
  if (node instanceof go.Node && data !== null) {
    var model = myDiagram.model;
    model.startTransaction("modified " + field);
    model.setDataProperty(data, field, text);
    model.commitTransaction("modified " + field);
  }
}

function loadChart() {
  $.ajax({
    url: "/load-chart",
    type: 'GET',
    success: function(response) {
      console.log('Chart data loaded successfully', response);

      myDiagram.model = new go.GraphLinksModel(response.nodeDataArray, response.linkDataArray);

      myDiagram.nodes.each(function(node) {
        node.isTreeExpanded = false;
      });
    },
    error: function(xhr, status, error) {
      console.error('Failed to load chart data:', error);
    }
  });
}


function loadNodeData(node) {
  var nodeType = node.data.name.toLowerCase();
  var url = '/load-' + nodeType;

  $.ajax({
    url: url,
    type: 'GET',
    success: function(response) {
      myDiagram.startTransaction("load " + nodeType);
      response.forEach(function(data) {
        myDiagram.model.addNodeData(data);
        myDiagram.model.addLinkData({ from: node.data.key, to: data.key });
      });
      myDiagram.commitTransaction("load " + nodeType);
    },
    error: function(xhr, status, error) {
      console.error('Failed to load ' + nodeType + ' data:', error);
    }
  });
}

function save() {
  saveDiagramProperties();
  document.getElementById("mySavedModel").value = myDiagram.model.toJson();
  myDiagram.isModified = false;
}

function load() {
  myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
  loadDiagramProperties();
}

function updateProperties(data) {
  if (data) {
    document.getElementById("title").value = data.title || "";
    // Set other properties as needed
  } else {
    document.getElementById("title").value = "";
    // Clear other properties
  }
}

function saveDiagramProperties() {
  myDiagram.model.modelData.position = go.Point.stringify(myDiagram.position);
}

function loadDiagramProperties(e) {
  var pos = myDiagram.model.modelData.position;
  if (pos) myDiagram.position = go.Point.parse(pos);
}

window.addEventListener('DOMContentLoaded', init);
