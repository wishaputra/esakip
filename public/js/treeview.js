function init() {
  const $ = go.GraphObject.make;

  let myDiagram = new go.Diagram("myDiagramDiv", {
    allowMove: false,
    allowCopy: false,
    allowDelete: false,
    allowHorizontalScroll: true,
    layout: $(go.TreeLayout, {
      alignment: go.TreeLayout.AlignmentStart,
      angle: 0,
      compaction: go.TreeLayout.CompactionNone,
      layerSpacing: 16,
      layerSpacingParentOverlap: 1,
      nodeIndentPastParent: 1.0,
      nodeSpacing: 0,
      setsPortSpot: false,
      setsChildPortSpot: false
    })
  });

  myDiagram.nodeTemplate = $(go.Node, {
    selectionAdorned: false,
    doubleClick: (e, node) => {
      var cmd = myDiagram.commandHandler;
      if (node.isTreeExpanded) {
        if (!cmd.canCollapseTree(node)) return;
      } else {
        if (!cmd.canExpandTree(node)) return;
      }
      e.handled = true;
      if (node.isTreeExpanded) {
        cmd.collapseTree(node);
      } else {
        cmd.expandTree(node);
      }
    }
  }, $("TreeExpanderButton", {
    "_treeExpandedFigure": "LineDown",
    "_treeCollapsedFigure": "LineRight",
    "ButtonBorder.fill": "whitesmoke",
    "ButtonBorder.stroke": null,
    "_buttonFillOver": "rgba(0,128,255,0.25)",
    "_buttonStrokeOver": null
  }), $(go.Panel, "Horizontal", {
    position: new go.Point(18, 0)
  }, new go.Binding("background", "isSelected", s => s ? "lightblue" : "white").ofObject(), $(go.Picture, {
    width: 18,
    height: 18,
    margin: new go.Margin(0, 4, 0, 0),
    imageStretch: go.GraphObject.Uniform
  }, new go.Binding("source", "isTreeExpanded", imageConverter).ofObject(), new go.Binding("source", "isTreeLeaf", imageConverter).ofObject()), $(go.Panel, "Vertical", {
    margin: new go.Margin(0, 0, 0, 4)
  }, $(go.TextBlock, {
    font: '9pt Verdana, sans-serif',
    margin: new go.Margin(0, 0, 0, 4)
  }, new go.Binding("text", "visi")), $(go.TextBlock, {
    font: '9pt Verdana, sans-serif',
    margin: new go.Margin(0, 0, 0, 4)
  }, new go.Binding("text", "misi")), $(go.TextBlock, {
    font: '9pt Verdana, sans-serif',
    margin: new go.Margin(0, 0, 0, 4)
  }, new go.Binding("text", "tujuan")))));

  // New node template for "tujuan" nodes
  

  myDiagram.linkTemplate = $(go.Link, {
    selectable: false,
    routing: go.Link.Orthogonal,
    fromEndSegmentLength: 4,
    toEndSegmentLength: 4,
    fromSpot: new go.Spot(0.001, 1, 7, 0),
    toSpot: go.Spot.Left
  }, $(go.Shape, {
    stroke: 'gray',
    strokeDashArray: [1, 2]
  }));

  fetch('/tree-data')
    .then(response => response.json())
    .then(data => {
      myDiagram.model = new go.TreeModel(data);
      myDiagram.layoutDiagram(true); // Update layout after adding nodes
    })
    .catch(error => {
      console.error('Error fetching tree data:', error);
    });

  fetch('/child-nodes')
    .then(response => response.json())
    .then(childData => {
      childData.forEach(childNode => {
        addChildNode(myDiagram, childNode); // Pass myDiagram as a parameter
      });
    })
    .catch(error => {
      console.error('Error fetching child node data:', error);
    });

  fetch('/tujuan-nodes')
    .then(response => response.json())
    .then(tujuanData => {
      tujuanData.forEach(tujuanNode => {
        addTujuanNode(myDiagram, tujuanNode); // Pass myDiagram as a parameter
      });
    })
    .catch(error => {
      console.error('Error fetching tujuan node data:', error);
    });
}

function addChildNode(diagram, childNodeData) {
  diagram.startTransaction('add node');
  diagram.model.addNodeData(childNodeData);

  var parentKey = childNodeData.parent_id; // Assuming 'parent_id' is the new column in 'cascading_misi'
  var parentNode = diagram.findNodeForKey(parentKey);
  if (parentNode !== null) {
    var linkData = { from: parentKey, to: childNodeData.key };
    diagram.model.addLinkData(linkData);
  }

  diagram.commitTransaction('add node');
}

function addTujuanNode(diagram, tujuanNodeData) {
  diagram.startTransaction('add node');
  diagram.model.addNodeData(tujuanNodeData);

  var parentKey = tujuanNodeData.id_misi; // Assuming 'id_misi' is the parent id in 'cascading_tujuan'
  var parentNode = diagram.findNodeForKey(parentKey);
  if (parentNode !== null) {
    var linkData = { from: parentKey, to: tujuanNodeData.key };
    diagram.model.addLinkData(linkData);
  }

  diagram.commitTransaction('add node');
}

function imageConverter(prop, picture) {
  var node = picture.part;
  if (node.isTreeLeaf) {
    return "img/document.svg";
  } else {
    if (node.isTreeExpanded) {
      return "img/openFolder.svg";
    } else {
      return "img/closedFolder.svg";
    }
  }
}

window.addEventListener('DOMContentLoaded', init);
