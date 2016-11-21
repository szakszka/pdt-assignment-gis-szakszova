function getStats() {
  return $.ajax({
      url:"http://localhost/PDT/API/api.php",
	  success:function(data){
		 $('.the-return').html(data);
	  }
  });
}

$(document).ready(function() {
	$('.sub-menu').hide();
	$('.subsub-menu').hide();

	$('.sidenav').children().click(function(){
		$(this).children('.sub-menu').slideToggle('slow'); 		
	}).children('.sub-menu').click(function (event) {
		event.stopPropagation();
	});	
	
	$('.sub-menu').children().click(function(){
		$(this).find('.subsub-menu').slideToggle('slow'); 		
	}).children('.subsub-menu').click(function (event) {
		event.stopPropagation();
	});	
	
	getStats();
});
