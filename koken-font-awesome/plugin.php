<?php

class KokenFontAwesome extends KokenPlugin {

	function __construct()
	{
		$this->register_hook('before_closing_head', 'render');
	}

	function render()
	{
		$path = $this->get_path();
		echo <<<OUT
<link rel="stylesheet" href="{$path}/font-awesome/css/font-awesome.min.css">
OUT;
	}
}