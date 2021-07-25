$(document).ready(() => {
	$('.col').matchHeight();

});

nav=(btn)=> {
	$pid = $(btn).attr('pid');
	$url = $BASE + 'products/' + $pid;
	window.location.assign($url);
}
