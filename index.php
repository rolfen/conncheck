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
                                position:       relative;
                                display:        inline-block;
                        }

                        .error-light:before {
                                content: "e";
                        }

                        .ping-light:before {
                                content: "p";
                        }

                        .light {
                                overflow: hidden;
                                text-align: center;
                                border-radius: 200%;
                                display: inline-block;
                                width:1em;
                                height: 1em;
                                line-height: .9em;
                                font-size: 1em;
                                color: black;
                                padding: 0;
                                margin: 0;
                                border: 1px solid black;
                        }

                        .ping-light.on {
                                color:white;
                                background-color: green;
                        }

                        .error-light.on {
                                color:white;
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
                        <!-- <?php echo " --".">" ?>
                        <pre>
Page loaded on <?php echo time() ?>
Client IP is <?php echo $_SERVER['REMOTE_ADDR'] ?>
                        </pre>
                        <?php echo "<!"."-- " ?> -->

                        <p>
                                <span class="btn" onclick="togglePinging()">Ping &#9199;</span>
                                <span class="light error-light" id="error-light"></span>
                                <span class="light ping-light" id="ping-light"></span>
                        </p>

                        <div class="ping-result-container">
                                        <pre id="ping-result"></pre>
                        </div>

                        <pre id="ping-status"></pre>

                </div>

                <script type="text/javascript">

                        var p = new Ping({timeout: 5000});

                        var pingRepeater;
                        var pingResultMessage;
                        var pingStatusMessage;
                        var errors = {};
                        var pingResultEl = document.getElementById("ping-result");
                        var pingStatusEl = document.getElementById("ping-status");
                        var errorLightEl = document.getElementById("error-light");
                        var pingLightEl = document.getElementById("ping-light");
                        var latencyHistory = [];

                        function pingCallback(err, data) {
                                if (err) {
                                        console.log("error loading resource")
                                        pingStatusMessage = "Ping failed (" + JSON.stringify(err) + ")";
                                        if(errors[err]) {
                                                errors[err] ++;
                                        } else {
                                                errors[err] = 1;
                                        }
                                        blinkError();
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
                                pingStatusEl.innerHTML = pingStatusMessage + "\n";
                                if(Object.keys(errors).length > 0) {
                                        pingStatusEl.innerHTML += JSON.stringify(errors)
                                }
                        }

                        function startPinging() {
                                pingStatusMessage = "Starting";
                                updatePingStatus();
                                pingRepeater = setInterval(function(){
                                        p.ping('./', pingCallback);
                                        blinkPing();
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

                        function blinkError() {
                                errorLightEl.classList.add("on");
                                setTimeout(() => {
                                        errorLightEl.classList.remove("on");
                                }, 900)
                        }

                        function blinkPing() {
                                pingLightEl.classList.add("on");
                                setTimeout(() => {
                                        pingLightEl.classList.remove("on");
                                }, 150)
                        }

                        console.log("You can use startPinging() and stopPinging() for live checks.");

                </script>

        </body>
</html>
