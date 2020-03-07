<?php // no caching for this page, ever!  (https://stackoverflow.com/questions/49547/how-to-control-web-page-caching-across-all-browsers)
header("Cache-Control: no-store, must-revalidate"); // HTTP 1.1.
header("Expires: 0"); // Proxies.
?>
<html>
<head>
<meta name="viewport" content="width=device-width">

<script src="node_modules/ping.js/dist/ping.min.js" type="text/javascript"></script>

<style>
body {
	font-family: monospace;
	font-size: 1.4em;
	color:#272822;
}
pre {
	white-space: pre-wrap;
}
</style>
</head>
<body>
<h1>Hi!</h1>
<pre>

You: <?php echo $_SERVER['REMOTE_ADDR'] ?> 
Time: <?php echo time() ?> 

</pre>

<p>Response latency for this page (ms): <span id="ping-latency">...</span></p>

<script type="text/javascript">
	
	var p = new Ping();

	function refreshLatency() {
		p.ping('./', function(err, data) {
		  // Also display error if err is returned.
		  if (err) {
		    console.log("error loading resource")
		    data = data + " " + err;
		  }
		  document.getElementById("ping-latency").innerHTML = data;
		});		
	}

	var refresher = setInterval(refreshLatency, 1000);

</script>

</body>
</html>
