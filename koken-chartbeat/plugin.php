<?php

class KokenChartbeat extends KokenPlugin {

	function __construct()
	{
		$this->register_hook('before_closing_head', 'render_head');
		$this->register_hook('before_closing_body', 'render_body');
	}

	function render_head()
	{

		echo <<<OUT
<script type="text/javascript">var _sf_startpt=(new Date()).getTime()</script>
OUT;

	}
	
	function render_body()
	{
		$host = $_SERVER["HTTP_HOST"];
		echo <<<OUT
<script type="text/javascript">
  var _sf_async_config = { uid: 50757, domain: '$host', useCanonical: true };
  (function() {
    function loadChartbeat() {
      window._sf_endpt = (new Date()).getTime();
      var e = document.createElement('script');
      e.setAttribute('language', 'javascript');
      e.setAttribute('type', 'text/javascript');
      e.setAttribute('src','//static.chartbeat.com/js/chartbeat.js');
      document.body.appendChild(e);
    };
    var oldonload = window.onload;
    window.onload = (typeof window.onload != 'function') ?
      loadChartbeat : function() { oldonload(); loadChartbeat(); };
  })();
</script>
OUT;

	}
}