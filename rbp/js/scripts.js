$(function() {
  // Self-labeled form fields
	$("input[title], textarea[title]").each(function() {
		if($(this).val() === "") {
			$(this).val($(this).attr("title"));	
		}

		$(this).focus(function() {
			if($(this).val() == $(this).attr("title")) {
				$(this).val("").addClass("focused");	
			}
		});
		
		$(this).blur(function() {
			if($(this).val() === "") {
				$(this).val($(this).attr("title")).removeClass("focused");	
			}
		});
	});
  
  // Meta Bar - User Menu slider
  var user_button = $("#user-button a");
  var user_menu = $("#user-menu");
  
  user_button.click(function(){
    user_menu.slideToggle("fast","swing");
    $(this).toggleClass("active");
    return false;
  });
  
  // jQuery Tools - Tooltips
  $(".cell a").tooltip({ position: "top right", offset: [-14,-12], relative: true}).dynamic({ });
  $(".checkmark").tooltip({ position: "top right", offset: [3,-2], relative: true}).dynamic({ });
  
  // Table row hover
  $("#content.toc tr").hover(function() {
      $(this).addClass("hover");
  }, function() {
      $(this).removeClass("hover");
  });

});	 
