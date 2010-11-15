<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>brooklyn.whichhood.org</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="frank">
	
	<LINK href="/style.css" rel="stylesheet" type="text/css"></LINK>
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="ol/OpenLayers.js"></script>
	<script src="protovis-d3.2.js"></script>	
	<script src="map.js"></script>	
	
	<script src="charts.js"></script>
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-19558271-1']);
	  _gaq.push(['_setDomainName', '.whichhood.org']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	
</head>

<body>
	
	<h1><a name="top"></a>Which neighborhood is this block in?</h1>
<div id="map"></div>
<div id="overlay_map"></div>
<form id="add-block" action="new.php" enctype="multipart/form-data" method="POST" name="addform">
<p><input type="text" name="neighborhood" value="neighborhood" class="bigtext" onFocus="this.value='';"></input></p>
<input  type="hidden" name="lng" value="" ></input>
<input type="submit" value="Name it!" style="background: white; color: black; font-size: 1.2em">
<input type="button" id="skip" value="Not sure, skip it." style="background: white; color: black; font-size: 1.2em">

<span id=sparkline></span>

</form>

<p><a href="https://whichhood.uservoice.com/" onclick="UserVoice.Popin.show(uservoiceOptions); return false;">Feedback / ideas</a>
 | <a href="http://brooklyn.whichhood.org/name/Greenpoint">View results</a>.</p>

<div id=about>
<p>WhichHood.org is an experimental sketch for a collaborative neighborhood mapping tool.</p>
<p>High-quality neighborhood boundaries could form the basis for many civic apps -- news, issue reporting, local retail, planning, etc. But those maps don't exist. Any available data typically represent an administrative or real estate focused view. The "official" boundaries don't adapt and grow as rapidly as neighborhoods do in our daily use. What if a community data source existed, generated from thousands of individual contributions? What if adding data to that resource was kinda fun? Maybe a bit competitive? A game?</p>

<p>Drawing actual boundaries for neighborhoods is hard: you don't always know the other side of a neighborhood edge, only the one closest to you. Instead, whichhood.org asks you to identify neighborhoods block by block.</p>

<p>Missing right now, but definitely needed, is a way to export the results as points or calculated polygons. And some way to bias the area you focus on, so that you can contribute to the places you know best. What else? <a href="http://whichhood.uservoice.com/">Contribute your feature ideas, or vote on existing ones.</a>
	
<p>whichhood.org was created by <a href="http://holobiont.org">Holobiont</a> at the Great Urban Hack, November 6/7, 2010.
</div>

<script type="text/javascript">
  var uservoiceOptions = {
    key: 'whichhood',
    host: 'whichhood.uservoice.com', 
    forum: '86245',
    alignment: 'right',
    background_color:'#FF0000', 
    text_color: 'white',
    hover_color: '#0066CC',
    lang: 'en',
    showTab: true
  };
  function _loadUserVoice() {
    var s = document.createElement('script');
    s.src = ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js";
    document.getElementsByTagName('head')[0].appendChild(s);
  }
  _loadSuper = window.onload;
  window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
</script>
</body>
</html>
                                                                       	