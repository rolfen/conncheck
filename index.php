<?php // no caching for this page, ever!  (https://stackoverflow.com/questions/49547/how-to-control-web-page-caching-across-all-browsers)
header("Cache-Control: no-store, must-revalidate"); // HTTP 1.1.
header("Expires: 0"); // Proxies.
?>
<html>
<head>
<meta name="viewport" content="width=device-width">

<script src="node_modules/ping.js/dist/ping.min.js" type="text/javascript"></script>
<script src="node_modules/asciichart/asciichart.js" type="text/javascript"></script>


<style>
body {
	font-family: monospace;
	font-size: 1.4em;
	color:#272822;
}
pre {
	white-space: pre-wrap;
}
.btn {
	display: inline-block;
	min-width: 1em;
	min-height: 1em;
	box-sizing: border-box;
	padding:.33em;
	color:white;
	background-color:black;
	font-weight:bold;
	cursor: pointer;
}
#ping-status {
	white-space: pre;
}
</style>
</head>
<body>
<h1>Hi</h1>
<pre>
Your IP is <?php echo $_SERVER['REMOTE_ADDR'] ?> 
Page loaded at <?php echo time() ?> 

</pre>

<p><span class="btn" onclick="togglePinging()">Toggle Ping</span></p>

<pre id="ping-status">Pull out your console</pre>

<script type="text/javascript">

	var p = new Ping();

	var pingRepeater;
	var pingStatusMessage;
	var latencyHistory = [];

	function ping(statusCallback) {
		p.ping('./', function(err, data) {
		  // Also display error if err is returned.
		  if (err) {
		    console.log("error loading resource")
		    pingStatusMessage = "Ping failed (" + err + ")";
		  } else {
		  	newResponse(data);
		  	pingStatusMessage  = asciichart.plot(latencyHistory, {
		  		height: 7,
		  		padding: '        '
		  	});
		  }
		  statusCallback();
		});
	}

	function newResponse(latency) {
		latencyHistory.unshift(latency);
		if(latencyHistory.length > 20) {
			latencyHistory.pop();
		}
	}

	function updatePingStatus() {
		document.getElementById("ping-status").innerHTML = pingStatusMessage;
	}

	function startPinging() {
		pingStatusMessage = "init";
		updatePingStatus();
		pingRepeater = setInterval(function(){
			ping(updatePingStatus);
		}, 1000);
	}

	function stopPinging() {
		clearInterval(pingRepeater);
		pingRepeater = false;
	}

	function togglePinging() {
		if(pingRepeater) {
			stopPinging();
		} else {
			startPinging();
		}
	}

	console.log("You can use startPinging() and stopPinging() for live checks.");

</script>

</body>
</html>
