function init() {

  // Since 2.2 you can also author concise templates with method chaining instead of GraphObject.make
  // For details, see https://gojs.net/latest/intro/buildingObjects.html
  const $ = go.GraphObject.make;  // for conciseness in defining templates
  

  myDiagram =
    new go.Diagram("myDiagramDiv", // must be the ID or reference to div
      {
        // make sure users can only create trees
        validCycle: go.Diagram.CycleDestinationTree,
        // users can select only one part at a time
        maxSelectionCount: 1,
        layout:
          $(go.TreeLayout,
            {
              treeStyle: go.TreeLayout.StyleLastParents,
              arrangement: go.TreeLayout.ArrangementHorizontal,
              // properties for most of the tree:
              angle: 90,
              layerSpacing: 35,
              // properties for the "last parents":
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
        // support editing the properties of the selected person in HTML
        "ChangedSelection": onSelectionChanged,
        "TextEdited": onTextEdited,
        // newly drawn links are of type "Support" -- not a regular boss-employee relationship
        "linkingTool.archetypeLinkData": { category: "Support", text: "100%" },
        // enable undo & redo
        "undoManager.isEnabled": true
      });

  // when the document is modified, add a "*" to the title and enable the "Save" button
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

  // when a node is double-clicked, add a child to it
  function nodeDoubleClick(e, obj) {
    var clicked = obj.part;
    if (clicked !== null) {
      var thisemp = clicked.data;
      myDiagram.startTransaction("add employee");
      var nextkey = (myDiagram.model.nodeDataArray.length + 1).toString();
      var newemp = { key: nextkey, name: "()", title: "" };
      myDiagram.model.addNodeData(newemp);
      myDiagram.model.addLinkData({ from: thisemp.key, to: nextkey });
      myDiagram.commitTransaction("add employee");
    }
  }

  // this is used to determine feedback during drags
  function mayWorkFor(node1, node2) {
    if (!(node1 instanceof go.Node)) return false;  // must be a Node
    if (node1 === node2) return false;  // cannot work for yourself
    if (node2.isInTreeOf(node1)) return false;  // cannot work for someone who works for you
    return true;
  }

  // This function provides a common style for most of the TextBlocks.
  // Some of these values may be overridden in a particular TextBlock.
  function textStyle() {
    return { font: "9pt sans-serif", stroke: "white" };
  }

  // define the Node template
  // define the Node template
// define the Node template
myDiagram.nodeTemplate =
$(go.Node, "Auto",
  // { doubleClick: nodeDoubleClick },
  { // handle dragging a Node onto a Node to (maybe) change the reporting relationship
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
      var selnode = diagram.selection.first();  // assume just one Node in selection
      if (mayWorkFor(selnode, node)) {
        // find any existing link into the selected node
        var link = selnode.findTreeParentLink();
        if (link !== null) {  // reconnect any existing link
          link.fromNode = node;
        } else {  // else create a new link
          diagram.toolManager.linkingTool.insertLink(node, node.port, selnode, selnode.port);
        }
      }
    }
  },
  // bind the Part.layerName to control the Node's layer depending on whether it isSelected
  new go.Binding("layerName", "isSelected", sel => sel ? "Foreground" : "").ofObject(),
  // define the node's outer shape
  $(go.Shape, "RoundedRectangle",
    {
      name: "SHAPE",
      fill: graygrad, stroke: "black",
      portId: "", fromLinkable: true, toLinkable: true, cursor: "pointer",
      width: 250, height: 90 // Adjust width and height as desired
    }),
  // define the panel where the text will appear
  $(go.Panel, "Table",
    {
      maxSize: new go.Size(150, 999),
      margin: new go.Margin(3, 3, 0, 3),
      defaultAlignment: go.Spot.Left
    },
    $(go.RowColumnDefinition, { column: 2, width: 4 }),
    $(go.TextBlock, "Title: ", textStyle(),
      {
        row: 0, column: 0,
        font: "bold 9pt sans-serif",
        editable: true, isMultiline: false,
        stroke: "white", minSize: new go.Size(80, 24), // Adjust minimum size as desired
        name: "title"
      },
      new go.Binding("text", "title").makeTwoWay()),
    $("TreeExpanderButton",
      { row: 1, columnSpan: 99, alignment: go.Spot.Center })
  )  // end Table Panel
);  // end Node


  // define the Link template
  myDiagram.linkTemplate =
    $(go.Link, go.Link.Orthogonal,
      { corner: 5 },
      $(go.Shape, { strokeWidth: 2 }));  // the link shape

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

  myDiagram.linkTemplateMap.add("Motion",
    $(go.Link, go.Link.Bezier,
      { isLayoutPositioned: false, isTreeLink: false, curviness: -50 },
      { relinkableFrom: true, relinkableTo: true },
      $(go.Shape,
        { stroke: "orange", strokeWidth: 2 }),
      $(go.Shape,
        { toArrow: "OpenTriangle", stroke: "orange", strokeWidth: 2 }),
      $(go.TextBlock,
        new go.Binding("text").makeTwoWay(),
        {
          stroke: "orange", background: "rgba(255,255,255,0.75)",
          maxSize: new go.Size(80, NaN), editable: true
        })));

  // read in the JSON-format data from the "mySavedModel" element
  load();
}

// Allow the user to edit text when a single node is selected
function onSelectionChanged(e) {
  var node = e.diagram.selection.first();
  if (node instanceof go.Node) {
    updateProperties(node.data);
  } else {
    updateProperties(null);
  }
}

// Update the HTML elements for editing the properties of the currently selected node, if any
// function updateProperties(data) {
//   if (data === null) {
//     document.getElementById("propertiesPanel").style.display = "none";
//     document.getElementById("name").value = "";
//     document.getElementById("title").value = "";
//     document.getElementById("comments").value = "";
//   } else {
//     document.getElementById("propertiesPanel").style.display = "block";
//     document.getElementById("name").value = data.name || "";
//     document.getElementById("title").value = data.title || "";
//     document.getElementById("comments").value = data.comments || "";
//   }
// }

// This is called when the user has finished inline text-editing
function onTextEdited(e) {
  var tb = e.subject;
  if (tb === null || !tb.name) return;
  var node = tb.part;
  if (node instanceof go.Node) {
    updateData(tb.text, tb.name);
    updateProperties(node.data);
  }
}

// Update the data fields when the text is changed
function updateData(text, field) {
  var node = myDiagram.selection.first();
  // maxSelectionCount = 1, so there can only be one Part in this collection
  var data = node.data;
  if (node instanceof go.Node && data !== null) {
    var model = myDiagram.model;
    model.startTransaction("modified " + field);
    if (field === "name") {
      model.setDataProperty(data, "name", text);
    } else if (field === "title") {
      model.setDataProperty(data, "title", text);
    } else if (field === "comments") {
      model.setDataProperty(data, "comments", text);
    }
    model.commitTransaction("modified " + field);
  }
}

// Show the diagram's model in JSON format
function save() {
  document.getElementById("mySavedModel").value = myDiagram.model.toJson();
  myDiagram.isModified = false;
}
function load() {
  myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
}
window.addEventListener('DOMContentLoaded', init);



