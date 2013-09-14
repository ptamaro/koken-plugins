<?php

class KokenEmojis extends KokenPlugin {

	function __construct()
	{
		$this->register_filter('site.output', 'add_emoji');
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
	
	private function emoji_callback($strFound)
	{
		$size = ($this->size > 0) ? $this->size : 20;
		return '<img height="' . $size . '" width="' . $size . '" src="' . $this->emojis->{str_replace(':', '', $strFound[0])} . '" />';
	}
	
	function add_emoji($data)
	{
		$this->size = $this->data->size;
		$this->emojis = json_decode($this->curl('https://api.github.com/emojis'));
		$emojiPatterns = array();
		foreach($this->emojis as $emoji => $url) {
			array_push($emojiPatterns, '/:' . $emoji . ':/');
		}
		$data = preg_replace_callback($emojiPatterns, array(&$this, 'emoji_callback'), $data);
		return $data;
	}
	
}