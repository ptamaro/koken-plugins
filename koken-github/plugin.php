<?php

class KokenGithub extends KokenPlugin {

	function __construct()
	{
		$this->require_setup = true;
		$this->register_hook('before_closing_body', 'render');
	}

	function render()
	{
	
		$clientId = $this->data->client_id;
		$clientSecret = $this->data->client_secret;
		$username = $this->data->username;
		$element = '"' . $this->data->element . '"';
		$numOfItems = intval($this->data->numOfItems);
		
		$apiCreds = (isset($clientId) && isset($clientSecret)) ? '?client_id='.$clientId.'&client_secret='.$clientSecret : '';

		echo <<<OUT
<script type="text/javascript">
(function() {
	var html = $('<ul/>');
	var buildTimeline = function(timeline) {
		var loop = 0;
		$.each(timeline, function(i,commit) {
			if (loop >= $numOfItems) { return false; }
			loop++;
			if (commit.type !== 'PushEvent') { return false; }
			var status = $('<li/>'),
				desc = $('<span/>').text(commit.payload.commits[0].message),
				time = $('<em/>').text(($.timeago) ? $.timeago(commit.created_at) : commit.created_at);				
			status.on('click', function() {
				window.location = 'https://github.com/' + commit.repo.name + '/commit/' + commit.payload.commits[0].sha;
			});			
			html.append(status.append(desc,time));
			
		});
		$(html).find('li:last').addClass('last');
		$((($element !== "") ? $element: 'body')).append(html);
	}
	$.ajax({
		type: 'GET',
		dataType: 'jsonp',
		url: 'https://api.github.com/users/$username/events$apiCreds',
		success: function(commits) {
			buildTimeline(commits.data);
		}
	});
})();
</script>
OUT;

	}
}