<?php 
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

<div id="sidebar">

<!--Begin 250x250 Ad Block-->
<?php if (get_option('artsee_twofifty') == 'Enable') { ?>
<?php include(TEMPLATEPATH . '/includes/250x250.php'); ?>
<?php } else { echo ''; } ?>
<!--End 250x250 Ad Block-->

<!--Begin 125x125 Ad Block-->
<?php if (get_option('artsee_ads') == 'Disable') { ?>
<?php { echo ''; } ?>
<?php } else { include(TEMPLATEPATH . '/includes/ads.php'); } ?>
<!--End 125x125 Ad Block-->

<div class="sidebar-box">
<h2>about us</h2>
<p>This is PoliSilo: a storehouse for web-based political science teaching resources since 2009. New links harvested weekly, hand picked by the free-ranging publishers at Soomo Publishing and their favorite instructors. To learn more about Soomo, visit <a href="http://soomopublishing.com" target="_blank">our site</a>.</p>
</div>

<div class="sidebar-box">
<!--<form style="border:1px solid #ccc;padding:3px;text-align:center;" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=Polisilo', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><p>Signup to get email alerts.<br/>Enter your email address:</p><p><input type="text" style="width:140px" name="email"/></p><input type="hidden" value="Polisilo" name="uri"/><input type="hidden" name="loc" value="en_US"/><input type="submit" value="Subscribe" /><p>Delivered by <a href="http://feedburner.google.com" target="_blank">FeedBurner</a></p></form>-->

<form action="http://app.nouri.sh/campaigns/4635/subscribe" method="post" style="border:1px solid #ccc;padding:3px;text-align:center">
  <input type="hidden" name="redirect_to" value="http://polisilo.com"/>
  <input type="hidden" name="notify_me" value="1"/>
  <input type="hidden" name="notify_them" value="1"/>
  
  <p>Signup to get email alerts.<br/>Enter your email address:</p>
  <p>
   <input id="subscriber[email]" name="subscriber[email]" type="text" style="width:140px" /><br />
   <input name="commit" type="submit" value="Subscribe" />
  </p>
</form>
</div>

<div class="sidebar-box">
<h2>Search</h2>
<div style="margin-left: 20px;">
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>
</div>

<?php if (get_option('artsee_posttabs') == 'Hide') { ?>
<?php { echo ''; } ?>
<?php } else { include(TEMPLATEPATH . '/includes/post-tabs.php'); } ?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?> 
		       
<div class="sidebar-box">
<h2>Archives</h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</div>

<div class="sidebar-box">
<h2>Categories</h2>
<ul>
<?php wp_list_categories('show_count=0&title_li='); ?>
</ul>
</div>

<div class="sidebar-box">           
<h2>Blogroll</h2>
<ul>
<?php get_links(-1, '<li>', '</li>', ''); ?>
</ul> 
</div>

<div class="sidebar-box">   
<h2>Meta</h2>
<ul>
<?php wp_register(); ?>
<!--<li><?php wp_loginout(); ?></li>-->
<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
<?php wp_meta(); ?>
</ul>
</div>

<?php endif; ?>

<div class="sidebar-box">
<h2>Subscribe</h2>
<ul>
<li><a href="http://feeds2.feedburner.com/Polisilo">Polisilo RSS Feed</a></li>
<li><a href="http://twitter.com/polisilo" target="_blank">Follow Polisilo on Twitter</a></li>
</ul>
</div>
                
</div>        
</div>