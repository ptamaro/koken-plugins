<?php

class KokenFontLoader extends KokenPlugin {

	function __construct()
	{
		$this->require_setup = true;
		$this->register_hook('before_closing_head', 'render');
	}

	function render()
	{
	
		$output = (object) array();
	
		if (isset($this->data->typekit)) {
			$output->typekit = (object) array('id' => $this->data->typekit);
		}
		
		if (isset($this->data->google)) {
			$families = array();
			$parts = explode(',',$this->data->google);
			foreach($parts as $family) {
				array_push($families,$family);
			}
			$output->google = (object) array('families' => $families);
		}
		
		if (isset($this->data->fontdeck)) {
			$output->fontdeck = (object) array('id' => $this->data->fontdeck);
		}
		
		if (isset($this->data->fontscom)) {
			$output->monotype = (object) array('projectId' => $this->data->fontscom);
		}
		
		$output = json_encode($output);
		
		echo <<<OUT
<script src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
<script type="text/javascript">WebFont.load($output);</script>
OUT;

	}
}