@extends('front.custom_page.layout')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
<head>
  <!-- Include necessary styles and scripts -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://unpkg.com/gojs@2.3.14/release/go.js"></script>
  
</head>
<body>
  <header id="header" class="ex-header">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1>{{$title}}</h1>
              </div>
          </div>
      </div>
  </header>

  <form action="" class="form-inline mt-4 justify-content-center">
    <div class="form-group mb-3">
        <h5 class="ml-3">Pilih Periode Tahun</h5>
        <select name="periode" id="periode" class="form-control ml-3">
            <option value="">Pilih</option>
            @foreach ($visi as $item)
                <option value="{{ $item->tahun_awal }}-{{ $item->tahun_akhir }}">
                    {{ $item->tahun_awal }} - {{ $item->tahun_akhir }}
                </option>
            @endforeach
        </select>
    </div>
</form>

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

  <div id="myDiagramDiv" style="width: 100%; height: 600px; border: 1px solid black;"></div>

  <script>
      
function init() {
  const $ = go.GraphObject.make;
  myDiagram = new go.Diagram("myDiagramDiv", {
      validCycle: go.Diagram.CycleDestinationTree,
      maxSelectionCount: 1,
      allowDelete: false, // Add this line
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
      "linkingTool.archetypeLinkData": { category: "Support", text: "100%" },
      "undoManager.isEnabled": false
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
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "visi").makeTwoWay()),
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "misi").makeTwoWay()),
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "tujuan").makeTwoWay()),
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "sasaran").makeTwoWay()),
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "tujuanRenstra").makeTwoWay()),
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "sasaranRenstra").makeTwoWay()),
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "program").makeTwoWay()),
              $(go.TextBlock, textStyle(),
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "kegiatan").makeTwoWay()),
              $(go.TextBlock, textStyle(), // Add this part
                  { row: 5, column: 0, font: "bold 9pt sans-serif" },
                  new go.Binding("text", "sub_kegiatan").makeTwoWay())),

          $("TreeExpanderButton",
              {
                  alignment: go.Spot.BottomRight,
                  alignmentFocus: go.Spot.Center,
                  width: 15,
                  height: 15,
                  click: (e, button) => {
                      var node = button.part;
                      if (node.isTreeExpanded) {
                          node.collapseTree();
                      } else {
                          node.expandTree();
                      }
                  }
              })
      );

myDiagram.linkTemplate =
$(go.Link, go.Link.Orthogonal,
{ corner: 5 },
$(go.Shape, { strokeWidth: 2 }));

myDiagram.linkTemplateMap.add("Support",
$(go.Link, go.Link.Bezier,
{ isLayoutPositioned: false, isTreeLink: false, curviness: -50 },
{ relinkableFrom: false, relinkableTo: false },
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

loadChart(); // Load the initial chart data

}

function loadChart(tahun_awal, tahun_akhir) {
    console.log('Loading chart for tahun_awal:', tahun_awal, 'tahun_akhir:', tahun_akhir);
    if (!tahun_awal || !tahun_akhir) {
        return;
    }
    myDiagram.clear(); // Clear the chart data
    $.ajax({
        url: "/load-chart",
        type: 'GET',
        data: { tahun_awal: tahun_awal, tahun_akhir: tahun_akhir },
        success: function(response) {
            console.log('Chart data loaded successfully', response);

            var nodeDataArray = response.nodeDataArray.map(function(nodeData) {
                // If the key starts with 'visi', add a 'visi' property
                if (nodeData.key.startsWith('visi')) {
                    nodeData.visi = nodeData.visi;
                }
                // If the key starts with 'misi', add a 'misi' property and a 'parent' property
                else if (nodeData.key.startsWith('misi')) {
                    nodeData.misi = nodeData.misi;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                // If the key starts with 'tujuan', add a 'tujuan' property and a 'parent' property
                else if (nodeData.key.startsWith('tujuan')) {
                    nodeData.tujuan = nodeData.tujuan;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                // If the key starts with 'sasaran', add a 'sasaran' property and a 'parent' property
                else if (nodeData.key.startsWith('sasaran')) {
                    nodeData.sasaran = nodeData.sasaran;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                else if (nodeData.key.startsWith('tujuanRenstra')) {
                    nodeData.tujuanRenstra = nodeData.tujuanRenstra;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                else if (nodeData.key.startsWith('sasaranRenstra')) {
                    nodeData.sasaranRenstra = nodeData.sasaranRenstra;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                else if (nodeData.key.startsWith('program')) {
                    nodeData.program = nodeData.program;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                else if (nodeData.key.startsWith('kegiatan')) {
                    nodeData.kegiatan = nodeData.kegiatan;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                else if (nodeData.key.startsWith('sub_kegiatan')) {
                    nodeData.sub_kegiatan = nodeData.sub_kegiatan;
                    nodeData.parent = nodeData.parent; // This should already be correct
                }
                return nodeData;
            });

            myDiagram.model = new go.GraphLinksModel(nodeDataArray, response.linkDataArray);

            // Collapse all nodes except the root "visi" node
            myDiagram.nodes.each(function(node) {
                if (node.data.key!== "visi") {
                    node.isTreeExpanded = false;
                }
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to load chart data:', error);
        }
    });
}

function getPeriods() {
    $.ajax({
        url: "/get-periods",
        type: 'GET',
        success: function(response) {
            $('#periode').empty(); // Clear existing options
            $('#periode').append($('<option>').text('Pilih').attr('value', ''));
            response.forEach(function(period) {
                $('#periode').append($('<option>').text(period.tahun_awal + ' - ' + period.tahun_akhir).attr('value', period.tahun_awal + '-' + period.tahun_akhir));
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to load periods:', error);
        }
    });
}

// Call getPeriods to load the periods initially
getPeriods();


$('#periode').change(function() {
    let periode = $(this).val();
    if (periode) {
        let [tahun_awal, tahun_akhir] = periode.split("-");
        loadChart(tahun_awal, tahun_akhir);
    } else {
        // Clear the chart if no period is selected
        myDiagram.model = new go.GraphLinksModel([], []);
    }
});

    init(); // Call init to initialize the diagram

// ..

window.addEventListener('DOMContentLoaded', init);
  </script>
</body>
@endsection