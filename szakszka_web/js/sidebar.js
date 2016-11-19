/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
    document.getElementById("stats").style.width = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("stats").style.width = "0";
}

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

	$('.sidenav').children().click(function(){
    $(this).children('.sub-menu').slideToggle('slow');     
	}).children('.sub-menu').click(function (event) {
		event.stopPropagation();
	});	
	getStats();
});
