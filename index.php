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
<!--
Questions? Write to spamhole@eebe.be 
Please include the word "AMHUMAN" in the email subject, otherwise I won't see it!
-->
</pre>

<?php if(isset($_GET['autoRefresh']) and !empty($_GET['autoRefresh'])) { ?>

<a href="?autoRefresh">Stop autorefresh</a>

<script>
'use strict';

var autoRefreshParameter = "<?php echo $_GET['autoRefresh'] ?>";
var defaultTimeout = 3000;
var minimumTimeout = 1000;

if(isNaN(autoRefreshParameter)) {
	var timeout = defaultTimeout;
} else {
	var timeout = (parseInt(autoRefreshParameter) * 1000);
	timeout = Math.max(timeout, minimumTimeout);
}

setTimeout(function(){
	location.reload();
}, timeout);

</script>

<?php } else { ?>

<a href="?autoRefresh=2">Automatically refresh this page</a>

<?php } ?>

</body>
</html>
