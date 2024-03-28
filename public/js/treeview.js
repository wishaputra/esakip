function init() {
  const $ = go.GraphObject.make;

  myDiagram =
    new go.Diagram("myDiagramDiv",
      {
        allowMove: false,
        allowCopy: false,
        allowDelete: false,
        allowHorizontalScroll: true,
        layout:
          $(go.TreeLayout,
            {
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

  myDiagram.nodeTemplate =
    $(go.Node,
      { // no Adornment: instead change panel background color by binding to Node.isSelected
        selectionAdorned: false,
        // a custom function to allow expanding/collapsing on double-click
        // this uses similar logic to a TreeExpanderButton
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
      },
      $("TreeExpanderButton",
        {
          "_treeExpandedFigure": "LineDown",
          "_treeCollapsedFigure": "LineRight",
          "ButtonBorder.fill": "whitesmoke",
          "ButtonBorder.stroke": null,
          "_buttonFillOver": "rgba(0,128,255,0.25)",
          "_buttonStrokeOver": null
        }),
      $(go.Panel, "Horizontal",
        { position: new go.Point(18, 0) },
        new go.Binding("background", "isSelected", s => s ? "lightblue" : "white").ofObject(),
        $(go.TextBlock,
          {
            font: '9pt Verdana, sans-serif',
            editable: true,
            textAlign: "left",
            margin: new go.Margin(0, 2, 0, 2),
            stretch: go.GraphObject.Horizontal
          },
          new go.Binding("text", "name").makeTwoWay())
      )  // end Horizontal Panel
    );  // end Node

 
  // with lines
      myDiagram.linkTemplate =
        $(go.Link,
          { selectable: false,
            routing: go.Link.Orthogonal,
            fromEndSegmentLength: 4,
            toEndSegmentLength: 4,
            fromSpot: new go.Spot(0.001, 1, 7, 0),
            toSpot: go.Spot.Left },
          $(go.Shape,
            { stroke: 'gray', strokeDashArray: [1,2] }));


  var nodeDataArray = [
    { key: 0, name: "VISI : TERWUJUDNYA TANGSEL UNGGUL, MENUJU KOTA LESTARI, SALING TERKONEKSI, EFEKTIF DAN EFISIEN", isTreeLeaf: false },
    { key: 1, name: "MISI : PEMBANGUNAN SUMBER DAYA MANUSIA (SDM) YANG UNGGUL", parent: 0 },
    { key: 2, name: "Meningkatkan Sumber Daya Manusia yang berkualitas dan berdaya saing", parent: 1 },
    { key: 3, name: "Meningkatnya kualitas layanan dan akses pendidikan", parent: 2 },
    { key: 4, name: "Meningkatnya Derajat Kesehatan Masyarakat", parent: 2 },
    { key: 5, name: "Meningkatnya Kesejahteraan Keluarga", parent: 2 },
    { key: 6, name: "Meningkatkan Daya Saing Pemuda", parent: 2 },
    { key: 7, name: "Meningkatkan Kualitas Pembangunan Berbasis Gender", parent: 2 },
    { key: 8, name: "MISI : PEMBANGUNAN INFRASTRUKTUR YANG SALING TERKONEKSI", parent: 0 },
    { key: 9, name: "Meningkatkan Konektivitas dan Aksesibilitas Infrastruktur Transportasi", parent: 8 },
    { key: 10, name: "Meningkatnya Kinerja Transportasi dan Jaringan Jalan Perkotaan", parent: 9 },
    { key: 11, name: "MISI : MEMBANGUN KOTA YANG LESTARI", parent: 0 },
    { key: 12, name: "Meningkatkan Kualitas Kota Sebagai Kota Layak Huni", parent: 11 },
    { key: 13, name: "Meningkatnya Kualitas Lingkungan Perkotaan", parent: 12 },
    { key: 14, name: "Meningkatnya Ketentraman dan Ketertiban Umum, Pendidikan Politik, Serta Wawasan Kebangsaan", parent: 12 },
    { key: 14, name: "Meningkatnya Pencegahan dan Penanganan Bencana Alam dan Non Alam", parent: 12 },
    { key: 15, name: "MISI : MENINGKATKAN EKONOMI BERBASIS NILAI TAMBAH TINGGI DI SEKTOR EKONOMI KREATIF", parent: 0 },
    { key: 16, name: "Meningkatkan Perekonomian dan Daya Saing Ekonomi Daerah", parent: 15 },
    { key: 17, name: "Meningkatnya Sektor Ekonomi Kreatif", parent: 16 },
    { key: 18, name: "Meningkatnya Investasi", parent: 16 },
    { key: 19, name: "Meningkatnya Produktifitas Tenaga Kerja", parent: 16 },
    { key: 20, name: "MISI : MEMBANGUN BIROKRASI YANG EFEKTIF DAN EFISIEN", parent: 0 },
    { key: 21, name: "Mewujudkan Birokrasi Yang Efektif dan Efisien", parent: 20 },
    { key: 22, name: "Meningkatnya Kinerja Penyelenggaraan Pemerintah Daerah", parent: 21 },


  ];

  myDiagram.model = new go.TreeModel(nodeDataArray);


}

function makeTree(level, count, max, nodeDataArray, parentdata) {
  var numchildren = Math.floor(Math.random() * 10);
  for (var i = 0; i < numchildren; i++) {
    if (count >= max) return count;
    count++;
    var childdata = { key: count, parent: parentdata.key };
    nodeDataArray.push(childdata);
    if (level > 0 && Math.random() > 0.5) {
      count = makeTree(level - 1, count, max, nodeDataArray, childdata);
    }
  }
  return count;
}


function imageConverter(prop, picture) {
  var node = picture.part;
  if (node.isTreeLeaf) {
    return "images/document.svg";
  } else {
    if (node.isTreeExpanded) {
      return "images/openFolder.svg";
    } else {
      return "images/closedFolder.svg";
    }
  }
}


window.addEventListener('DOMContentLoaded', init);
