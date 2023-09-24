<?php // no caching for this page, ever!  (https://stackoverflow.com/questions/49547/how-to-control-web-page-caching-across-all-browsers)
header("Cache-Control: no-store, must-revalidate"); // HTTP 1.1.
header("Expires: 0"); // Proxies.
?>
<html>
<head>
<title>ping</title>
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
.ping-result-container {
	position: 	relative;
	display: 	inline-block;	
}

.error-light:before {
	content: "E";
}
.error-light {
	display: block;
	width:1em;
	height: 1em;
	line-height: 1em;
	font-size: 1em;
	color: black;
	padding: 0;
	margin: 0;
	position: absolute;
	top: 1em;
	right: -1em;
	border: 1px solid black;
}

.error-light.on {
	background-color: red;
}

.btn {
	display: inline-block;
	min-width: 1em;
	min-height: 1em;
	border-radius: .22em;
	border: 1px solid black;
	box-sizing: border-box;
	padding:.33em .66em .33em .66em;
	color:white;
	text-decoration: none;
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
	<div>
		<!-- <?php echo  "-->" ?>
		<pre>
Page loaded on <?php echo time() ?> 
Client IP is <?php echo $_SERVER['REMOTE_ADDR'] ?>
		</pre>
		<?php echo  "<!--" ?> -->

		<p>
		<span class="btn" onclick="togglePinging()">Ping &#9199;</span>
		</p>

		<div class="ping-result-container">
				<div class="error-light" id="error-light"></div>
				<pre id="ping-result"></pre>
		</div>

		<pre id="ping-status"></pre>


	</div>

	<script type="text/javascript">

		var p = new Ping();

		var pingRepeater;
		var pingResultMessage;
		var pingStatusMessage;
		var pingResultEl = document.getElementById("ping-result");
		var pingStatusEl = document.getElementById("ping-status");
		var errorLightEl = document.getElementById("error-light");
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

		function blinkError() {
			errorLightEl.classList.add("on");
			setTimeout(() => {
				errorLightEl.classList.remove("on");
			}, 900)
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
