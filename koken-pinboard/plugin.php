<?php

class KokenPinboard extends KokenPlugin {

	function __construct()
	{
		$this->require_setup = true;
		$this->register_hook('before_closing_body', 'render');
	}
	
	function isJson($str)
	{
 		json_decode($str);
 		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	private function curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function render()
	{
	
		$token = $this->data->api_token;
		$element = '"' . $this->data->element . '"';
		$numOfItems = $this->data->numOfItems;
		$filterBy = $this->data->filterBy;
		$date = ($this->data->showDate) ? 1 : 0;
		
		$apiUrl = 'https://api.pinboard.in/v1/posts/all?auth_token=' . $token . '&format=json';
		if ($filterBy != '') {
			$apiUrl .= '&tag=' . $filterBy;
		}
		$data = $this->curl($apiUrl);
		
		if ($this->isJson($data)) {
			echo <<<OUT
<script type="text/javascript">
(function() {
	var items = $('<ul/>').addClass('koken-pinboard'),
		data = ("$numOfItems" != "") ? $data.slice(0,$numOfItems) : $data;
	$.each(data, function(i, item) {
		var _wrap = $('<span/>'),
			_link = $('<a/>').text(item.description),
			_date = $('<em/>'),
			_list = $('<li/>');
		_wrap.append(_link);
		if ($date === 1 && $.timeago) { _date.text($.timeago(item.time)); _wrap.append(_date);  }
		items.append(_list.append(_wrap));
		_list.on('click', function() {
			window.location = item.href;
		});
	});
	$(items).find('li:last').addClass('last');
	$((($element !== "") ? $element: 'body')).append(items);
})();
</script>
OUT;
		} else {
			// Pinboard API is down or returning malformed json so we'll just hide the element
			echo <<<OUT
<script type="text/javascript">$(function() { $('$element').hide(); });</script>
OUT;
		}

	}
}