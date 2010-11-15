
function sparktick(data) {
  var w = data.length * 2,
      h = 15;

  var vis = new pv.Panel()
      .width(w)
      .height(h);

  vis.add(pv.Rule)
      .bottom(h / 2)
      .strokeStyle("#6600FF")
    .add(pv.Rule)
      .data(data)
      .left(function() 2 * this.index)
      .bottom(function(d) d ? h / 2 : 0)
      .height(h / 2);

	vis.canvas(document.getElementById("sparkline"));	
		
  vis.render();
}