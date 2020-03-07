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
<h1>Hi</h1>
<pre>
Your IP is <?php echo $_SERVER['REMOTE_ADDR'] ?> 
Page loaded at <?php echo time() ?> 

<span id="ping-status">Initializing ping</span>

<script type="text/javascript">
	
	var p = new Ping();
	var pingRepeater;

	function ping(statusCallback) {
		p.ping('./', function(err, data) {
		  // Also display error if err is returned.
		  var msg;
		  if (err) {
		    console.log("error loading resource")
		    msg = "Ping failed (" + err + ")";
		  } else {
		  	msg = "Ping is " + data + " ms";
		  }
		  statusCallback(msg);
		});
	}

	function updatePingStatus(msg) {
		document.getElementById("ping-status").innerHTML = msg;		
	}

	function startPinging() {
		pingRepeater = setInterval(function(){
			ping(updatePingStatus);
		}, 1000);
	}

	function stopPinging() {
		clearInterval(pingRepeater);	
	}

	console.log("You can use startPinging() and stopPinging() to pause live checks.")
	startPinging();

</script>

</body>
</html>
