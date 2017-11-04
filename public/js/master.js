$(document).ready(function() {
	$("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
	});

	$(".sidebar-element-toggle").click(function(e) {
		$(".sidebar-element-toggle").removeClass("active");
		$(this).addClass("active");
		//$("#wrapper").toggleClass("active");
	});

});