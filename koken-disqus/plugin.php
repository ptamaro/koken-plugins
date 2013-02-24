<?php

class KokenDisqus extends KokenPlugin {

	function __construct()
	{
		$this->require_setup = true;
		$this->register_hook('before_closing_body', 'render');
	}

	function render()
	{
		
		$shortname = "'" . $this->data->shortname . "'";
		
		echo <<<OUT
<script type="text/javascript">
(function() {
	if (document.body.className === 'k-source-essay') {
		(function() {
	        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	        dsq.src = 'http://' + $shortname + '.disqus.com/embed.js';
	        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	    })();
	}
})();
$(function() {
	if (document.body.className === 'k-source-essay') {
		$('article').after('<div id="disqus_thread"></div>');
	}
});
</script>
OUT;

	}
}