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
		$widgetId = $this->data->widgetId;
		$element = '"' . $this->data->element . '"';
		$theme = $this->data->theme;
		$linkColor = ($this->data->linkColor !== '') ? $this->data->linkColor : '';
		$width = ($this->data->width !== '') ? $this->data->width : '';
		$height = ($this->data->height !== '') ? $this->data->height : '';
		$borderColor = ($this->data->borderColor !== '') ? $this->data->borderColor : '';
		$limit = ($this->data->limit !== '') ? $this->data->limit : '';
		$chrome = '';
		if ($this->data->noheader) {
			$chrome .= 'noheader ';
		}
		if ($this->data->nofooter) {
			$chrome .= 'nofooter ';
		}
		if ($this->data->noborders) {
			$chrome .= 'noborders ';
		}
		if ($this->data->noscrollbar) {
			$chrome .= 'noscrollbar ';
		}
		if ($this->data->transparent) {
			$chrome .= 'transparent ';
		}

		echo <<<OUT
<script>
$(function() {
	var widget = $('<a/>').addClass('twitter-timeline').attr({
		'href': 'https://twitter.com/$username',
		'data-link-color': "$linkColor",
		'width': "$width",
		'height': "$height",
		'data-theme': "$theme",
		'data-border-color': "$borderColor",
		'data-tweet-limit': "$limit",
		'data-chrome': "$chrome",
		'data-widget-id': "$widgetId"
	}).text('Tweets by @$username');
	$((($element !== "") ? $element: 'body')).append(widget);
});
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
</script>
OUT;

	}
}