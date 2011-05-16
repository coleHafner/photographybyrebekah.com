<?php
require_once ( 'pbr_base/Layout.php' );
$layout = new Layout( $_GET );
echo $layout->getHtmlHeadSection();
echo '
<body>
	<a href="/images/img_big.jpg" class="zoom">
		<img src="http://lh6.ggpht.com/_cttD_nCtI4o/TPXYV1TlkvI/AAAAAAAACdI/BD5ePGEipgk/s200/04_alert.jpg" class="thumb_dimmed">
	</a>
</body>

</html>';