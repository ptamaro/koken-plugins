<?php

class KokenTwitterTimeline extends KokenPlugin {

	function __construct()
	{
		$this->require_setup = true;
		$this->register_hook('before_closing_body', 'render');
	}

	function render()
	{

		$username = $this->data->username;
		$element_id = (!empty($this->data->element_id)) ? str_replace( '#', '', $this->data->element_id ) : 'body';
		$footer = $this->data->footer;
		$theme = '{' . $this->data->theme . '}';
		$loop = $this->data->loop;
		$live = $this->data->live;
		$height = (!empty($this->data->height)) ? $this->data->height : 0;
		$width =  (!empty($this->data->width)) ? $this->data->width : 0;
		$behavior = $this->data->behavior;
		$minimal = ($this->data->minimal == 'true') ? '<style type="text/css">.twtr-hd, .twtr-user, .twtr-ft {display: none;}</style>' : '';

		if ( $this->data->exclude_replies == 'true' ) {
			$username .= '&exclude_replies=true';
		}

		echo <<<OUT
<script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
$minimal
<script type="text/javascript">
(function() {
	var element = '$element_id',
		height = ($height > 0) ? $height : 'auto',
		width = ($width > 0) ? $width : 'auto';
	new TWTR.Widget({
		version: 2,
		id: (element !== 'body') ? element : '',
		type: 'profile',
		rpp: 12,
		interval: 30000,
		width: width,
		height: height,
		footer: '$footer',
		theme: !$.isEmptyObject($theme) && $theme,
		features: {
			loop: $loop,
			live: $live,
			behavior: '$behavior'
		}
	}).render().setUser('$username').start();
})();
</script>
OUT;

	}
}