/*
	Easy plugin to get element index position
*/

$.fn.getIndex = function(){
	var $p=$(this).parent().children();
    return $p.index(this);
}

/*
	Portfolio plugin to setup initial effects for portfolio page
*/
$.fn.portfolioInit = function(){
	$(this).each(function(){ 
		$(this).hover(function(){  
 			$(this).find('.hover_content:first').fadeIn();
 		}  
  		, function(){  
  		
  			$(this).find('.hover_content:first').fadeOut();
  		}  
  		
		);
	});
	
	$(this).click(function(){
 		$(this).find('a:first').click();
 		return false;
 	});
 	
 	// Setup vimeo video modal window for portfolio
	$('.portfolio_vimeo').fancybox({ 
		padding: 10,
		overlayColor: '#000000', 
		overlayOpacity: .7
	});
	
	$('.portfolio_youtube').fancybox({ 
		padding: 10,
		overlayColor: '#000000', 
		overlayOpacity: .7
	}); 
	
	$('.portfolio_image').fancybox({ 
		padding: 0,
		overlayColor: '#000000', 
		overlayOpacity: .7
	});
}

$(function(){ 

	$('#searchform label').html('Search');

	$('#main_menu li').each(function(){ 
		var navChildren = $(this).find('ul.sub-menu');
		
		//if has submenu
		if(navChildren.length > 0)
		{
			var childrenHTML = navChildren.html();
			navChildren.remove();
			
			var styleSubNav = '<div class="popup">';
			styleSubNav += '<div class="top"></div>';
			styleSubNav += '<div class="content"><ul class="submenu">'+childrenHTML+'</ul><br class="clear"/></div>';
			styleSubNav += '<div class="footer"></div>';
			
			$(this).append(styleSubNav);
		}
	});
	
	// Setup main navigation menu
	$('#main_menu li a').each(function(){ 
		$(this).click(function(){
			
			$(this).parent('li').find('ul').css('display', 'block');
			$('.nav li a').removeClass('selected');
			$('.popup').css('display', 'none');
				
			$(this).addClass('selected');
				
			var popup = $(this).parent().find('.popup');
				
			//if has submenu
			if(popup.length > 0)
			{
				//get the position of the placeholder element
  				var pos = $(this).parent().offset();
  				var width = $(this).parent().width();
  				var popupPos = pos.left-80+(width/2)+1;

  				//show the menu directly over the placeholder
  				popup.css( { "left": popupPos + "px", "top":pos.top + 45 + "px" } );
  				popup.show();
  					
  				return false;
			}
		});
	});
	$(document).click(function(){
		$('.popup').css('display', 'none');
		$('.popup').parent().find('a').removeClass('selected');
	});
	
	// Setup testimonials content
	$('.testimonials_owner li a').each(function(){
		$(this).click(function(){
			var currentPos = $(this).parent().getIndex();

			if($(this).find('img').css('width') != '40px')
			{
				var calPos = (currentPos*95)+45 + "px 0";
			}
			else
			{
				var calPos = (currentPos*55)+45 + "px 0";
			}
						
			$('#testimonials_triangle').animate({ 
    	    	backgroundPosition: calPos
    	  	}, 300 );
		
			$('.testimonials p').hide();
			$($(this).attr('href')).fadeIn();
			
			return false;
		});
	});
	

	
	// Setup portfolio annimation
	var $preferences = {
    	duration: 800,
    	adjustHeight: false,
    	easing: 'easeInOutQuad',
    	useScaling: false
  	};					
				
	// clone applications to get a second collection
	var $data = $(".portfolio_container ul.portfolio_photos").clone();
				
	$('ul.portfolio_tab li').click(function(e) {
		$('ul.portfolio_tab li').removeClass('active');

		var filterClass=$(this).attr('class').split(' ').slice(-1)[0];
					
		if (filterClass == 'all') {
			var $filteredData = $data.find('li');
		} else {
			var $filteredData = $data.find('li[data-type=' + filterClass + ']');
		}
					
		$(".portfolio_container ul.portfolio_photos").quicksand($filteredData, $preferences, function(){
						
			$('ul.portfolio_photos li .wrapper').portfolioInit();
							
		});
					
		$(this).addClass('active');
						
		return false;
	});
	
	// Setup portfolio image preview link
	$('.portfolio_one_column .image').hover(function(){  
 			$(this).parent().find('.hover_content').fadeIn();
 			
 			$(this).click(function(){
 				$(this).find('a').click();
 			});
 		}  
  		, function(){  
  		
  			$(this).parent().find('.hover_content').fadeOut();
  		}  
  		
	);

});

$(document).ready(function(){ 

	$('ul.portfolio_photos li .wrapper').portfolioInit();
	
	// Setup skin switcher
	$('#nav_skin li a').click(function(){
		var skin = $(this).attr('href').substr(1);
		$.cookie("skin", skin);
		location.href = location.href;
		
		return false;
	});
	
	// Setup content slider
	//$('#content_slider').children('div').css('display', 'none');
	
	
	$('a.comment-reply-link').click(function(){
		var targetDiv = $(this).parent('div');
	
		$('#comment_form').clone().appendTo(targetDiv);

		return false;
	});
	
	
	// Preload images
	$.preloadCssImages();
	
	// Setup contact form
	$.validator.setDefaults({
		submitHandler: function() { 
		    var actionUrl = $('#contact_form').attr('action');
		    
		    $.ajax({
  		    	type: 'POST',
  		    	url: actionUrl,
  		    	data: $('#contact_form').serialize(),
  		    	success: function(msg){
  		    		$('#contact_form').hide();
  		    		$('#reponse_msg').html(msg);
  		    	}
		    });
		    
		    return false;
		}
	});
		    
		
	$('#contact_form').validate({
		rules: {
		    your_name: "required",
		    email: {
		    	required: true,
		    	email: true
		    },
		    message: "required"
		},
		messages: {
		    your_name: "Please enter your name",
		    email: "Please enter a valid email address",
		    agree: "Please enter some message"
		}
	});	
	
	
	$('.social_media li a').tipsy({gravity: 's'});
	
	$('.soomo_gallery a').attr('rel', 'slide');
	$('.soomo_gallery a[rel=slide]').fancybox({ 
		padding: 0,
		overlayColor: '#000000', 
		overlayOpacity: .7
	});
	
	
	$(".accordion").accordion({ collapsible: true });
	
	$(".tabs").tabs();

});