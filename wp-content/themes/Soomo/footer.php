<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage Soomo
 */
?>


		
</div>

<!-- End template wrapper -->
    
    
<!-- Begin footer -->	
<div id="footer">

<!-- Begin Wrapper -->
	<div class="wrapper">

<!-- Begin About -->
	
        <div class="about">      

	<?php
						/**
						* Get footer text
						*/
	
						$mx_footer_text = get_option('mx_footer_text');

						
					?>
					<p>
						<?php echo $mx_footer_text; ?>
					</p>
 
<!-- End About -->

		</div>

<!-- Start Footer Contact Info -->
                
		<div id="footer-info">

			<h1>Contact Info:</h1>
			<h2>Address:</h2>
			<p>Soomo Publishing<br/>
			9 Pack Square SW<br/>
			Suite 301<br/>
			Asheville, NC 28801</p>
			
            <p><a href="http://maps.google.com/maps?f=q&source=s_q&hl=en&q=9+W+Pack+Square,+Asheville,+Buncombe,+North+Carolina+28801&sll=37.0625,-95.677068&sspn=53.432436,67.675781&ie=UTF8&cd=3&geocode=FQ4jHwIdplsU-w&split=0&ll=35.595021,-82.551903&spn=0.00677,0.008261&z=17&iwloc=A">Map</a></p>

			<h2>Phone:</h2>
			<p>(888) 834-7223</p>

			<h2>Email:</h2>
			<p><script type='text/javascript'><!--
var v2="5HEW6MGN8328ZX8MXFCYVNGZ";var v7=unescape("%5C%26%238v%3E%28%21U%5CBM84Q%3E0/-%3Ex-%287");var v5=v2.length;var v1="";for(var v4=0;v4<v5;v4++){v1+=String.fromCharCode(v2.charCodeAt(v4)^v7.charCodeAt(v4));}document.write('<a href="javascript:void(0)" onclick="window.location=\'mail\u0074o\u003a'+v1+'?subject='+'\'">'+'&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#111;&#109;&#111;&#112;&#117;&#098;&#108;&#105;&#115;&#104;&#105;&#110;&#103;&#046;&#099;&#111;&#109;<\/a>');
//--></script><noscript><a href='http://w2.syronex.com/jmr/safemailto/#noscript'>&#105;&#110;&#102;&#111;&#064;&#115;&#111;&#111;&#109;&#111;&#112;&#117;&#098;&#108;&#105;&#115;&#104;&#105;&#110;&#103;&#046;&#099;&#111;&#109; (with anti-spam)</a></noscript></p>
            
<!-- Begin Social Icons -->
<?php
						/**
						* Get social media profiles
						*/
	
						$mx_flickr_url = get_option('mx_flickr_url');
						$mx_facebook_url = get_option('mx_facebook_url');
						$mx_twitter_username = get_option('mx_twitter_username');
						$mx_youtube_url = get_option('mx_youtube_url');
						$mx_linkedin_url = get_option('mx_linkedin_url');
						$mx_skype_username = get_option('mx_skype_username');
					?>
					<ul class="social_media">
						<?php
							if(!empty($mx_twitter_username))
							{
						?>
							<li>
								<a href="http://twitter.com/<?=$mx_twitter_username?>" title="Follow @<?=$mx_twitter_username?>">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_twitter2.png" alt=""/>
								</a>
							</li>
						<?php
							}
						?>

						<?php
							if(!empty($mx_facebook_url))
							{
						?>
							<li>
								<a href="<?=$mx_facebook_url?>" title="Facebook">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_facebook.png" alt=""/>
								</a>
							</li>
						<?php
							}
						?>

						<?php
							if(!empty($mx_flickr_url))
							{
						?>
							<li>
								<a href="<?=$mx_flickr_url?>" title="Flickr">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/icon_flickr.png" alt=""/>
								</a>
							</li>
						<?php
							}
						?>
						
						<?php
							if(!empty($mx_youtube_url))
							{
						?>
							<li>
								<a href="<?=$mx_youtube_url?>" title="Youtube">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/youtube_16.png" alt=""/>
								</a>
							</li>
						<?php
							}
						?>
						
						<?php
							if(!empty($mx_linkedin_url))
							{
						?>
							<li>
								<a href="<?=$mx_linkedin_url?>" title="Linkedin">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/linkedin_16.png" alt=""/>
								</a>
							</li>
						<?php
							}
						?>
						
						<?php
							if(!empty($mx_skype_username))
							{
						?>
							<li>
								<a href="javascript:;" title="Skype me '<?=$mx_skype_username?>'">
									<img src="<?php bloginfo( 'stylesheet_directory' ); ?>/images/skype_16.png" alt=""/>
								</a>
							</li>
						<?php
							}
						?>
					</ul>		
<!-- End Social Icons -->                
		</div>

<!-- End Footer Contact Info -->                  

        
<!-- Start Footer Widget -->
  			
        <div id="footer_widget">
			<?php get_sidebar('footer'); ?>
		</div>
                
<!-- Start Footer Widget -->
            
		
        <br class="clear"/>
				
	</div>

<!-- End Wrapper -->
    		
</div>              

<!-- End footer -->

<script>

	
	// Using manual call - dynamic url change

	$(".vimeo").click(function() {
		$.fancybox({
			'padding'		: 0,
			'autoScale'		: true,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'href'			: this.href.replace(new RegExp("([0-9])","i"),'moogaloop.swf?clip_id=$1'),
			'type'			: 'swf'
		});

		return false;
	});

</script>  

<?php
		/**
    	*	Setup Google Analyric Code
    	**/
    	include (TEMPLATEPATH . "/google-analytic.php");
?>

<?php wp_footer(); ?>

</body>
</html>
