<?php // no caching for this page, ever!  (https://stackoverflow.com/questions/49547/how-to-control-web-page-caching-across-all-browsers)
header("Cache-Control: no-store, must-revalidate"); // HTTP 1.1.
header("Expires: 0"); // Proxies.
?>
<html>
<head>
<meta charset="UTF-8">
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
	border-radius: .22em;
	box-sizing: border-box;
	padding:.5em 1em .5em 1em;
	color:white;
	background-color:black;
	font-weight:bold;
	cursor: pointer;
}
#ping-result {
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


<pre id="ping-result"></pre>

<pre id="ping-status">Pull out your console</pre>

<script type="text/javascript">

	var p = new Ping();

	var pingRepeater;
	var pingResultMessage;
	var pingStatusMessage;
	var pingResultEl = document.getElementById("ping-result");
	var pingStatusEl = document.getElementById("ping-status");
	var latencyHistory = [];

	function pingCallback(err, data) {
		if (err) {
			console.log("error loading resource")
			pingStatusMessage = "Ping failed (" + err + ")";
			updatePingStatus();
		} else {
			newResponse(data);
		}
	}

	function newResponse(latency) {
		// record response
		latencyHistory.unshift(latency);
		if(latencyHistory.length > 20) {
			latencyHistory.pop();
		}

		// display results
	  	pingResultMessage  = asciichart.plot(latencyHistory, {
	  		height: 7,
	  		padding: '        '
	  	});
	  	updatePingResult();

		// Since we are getting a response, assume all OK and clear any error
		pingStatusMessage = "";
		updatePingStatus(); 
	}

	function updatePingResult() {
		pingResultEl.innerHTML = pingResultMessage;
	}

	function updatePingStatus() {
		pingStatusEl.innerHTML = pingStatusMessage;
	}

	function startPinging() {
		pingStatusMessage = "Starting";
		updatePingStatus();
		pingRepeater = setInterval(function(){
			p.ping('./', pingCallback);
		}, 1000);
	}

	function stopPinging() {
		clearInterval(pingRepeater);
		pingRepeater = false;
		pingStatusMessage = "Paused";
		updatePingStatus();
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
