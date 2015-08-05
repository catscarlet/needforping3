<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Need For Ping 3</title>
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />

	<script type="text/javascript" src="jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/getquery.js"></script>
	<script type="text/javascript" src="js/draw_LOSS.js"></script>
	<script type="text/javascript" src="js/draw_LATENCY.js"></script>
	<script type="text/javascript" src="js/draw_charts.js"></script>
	<script src="js/highcharts/highcharts.js"></script>
	<script src="js/highcharts/modules/exporting.js"></script>

</head>

<body>


	<?php
//echo "php";

require 'query_pinglist.php'

?>



		<div id="LOSS_container" style="min-width: 310px; height: 400px; margin: 0 auto">丢包率图表</div>
		<div id="LATENCY_container" style="min-width: 310px; height: 400px; margin: 0 auto">延迟图表</div>

		<p>博客地址：<a href="http://blog.catscarlet.com"> http://blog.catscarlet.com</a></p>


</body>

</html>
