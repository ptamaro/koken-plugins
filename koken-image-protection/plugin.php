<?php

class KokenImageProtection extends KokenPlugin {

	function __construct()
	{
		$this->require_setup = true;
		$this->register_hook('before_closing_head', 'render_into_head');
		$this->register_hook('before_closing_body', 'render_into_foot');
	}

	function render_into_head()
	{

		if ($this->data->pinterest) {
			$pinmsg = ($this->data->pinterest_msg !== '') ? $this->data->pinterest_msg : 'Sorry, this site does not allow pinning';
			echo <<<OUT
<meta name="pinterest" content="nopin" description="$pinmsg" />
OUT;
		}

	}
	
	function render_into_foot()
	{
	
		if ($this->data->events) {
			echo <<<OUT
<script type="text/javascript">
$(function() {
	var transparentImg = $('<img/>').attr('src','data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
	$('img[data-base]').each(function(i,img) {
		$(img).one('load', function() {
			var overlay = transparentImg.clone(),
				domImg = $(this),
				offsets = domImg.offset();
			overlay.width(domImg.width());
			overlay.height(domImg.height());
			overlay.css({
				position: 'absolute',
				top: ( offsets.top + ( parseInt( domImg.css('margin-top'), 10 ) + parseInt( domImg.css('padding-top'), 10 ) ) ) + 'px',
				left: ( offsets.left + ( parseInt( domImg.css('margin-left'), 10 ) + parseInt( domImg.css('padding-left'), 10 ) ) ) + 'px'
			});
			domImg.after(overlay);
		});
	});
});
</script>
OUT;
		
		}
	
	}
}