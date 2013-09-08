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
		$showBranch = (empty($this->data->showBranch)) ? 'false' : 'true';
		$apiCreds = (isset($clientId) && isset($clientSecret)) ? '?client_id='.$clientId.'&client_secret='.$clientSecret : '';

		echo <<<OUT
<script type="text/javascript">
(function() {
	var html = $('<ul/>');
	var buildTimeline = function(timeline) {
		$.each(timeline, function(i,event) {
			if (event.type !== 'PushEvent') { return false; }
			$.each(event.payload.commits, function(j, commit) {
				var status = $('<li/>'),
					desc = $('<span/>').html(commit.message),
					time = $('<em/>').text(($.timeago) ? $.timeago(event.created_at) : event.created_at);
				if ($showBranch == true) { desc.append($('<strong/>').text(event.repo.name)) };
				status.on('click', function() {
					window.location = 'https://github.com/' + event.repo.name + '/commit/' + commit.sha;
				});			
				html.append(status.append(desc,time));
			});
		});
		if ($numOfItems > 0) {
			html.html(html.find('li').slice(0, $numOfItems));
		}
		html.find('li:last').addClass('last');
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