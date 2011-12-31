<?php /* Template Name: Sign In */ ?>

<?php
/**
 * The main template file for display page.
 *
 * @package WordPress
 * @subpackage Soomo
*/


/**
*	Get Current page object
**/
$page = get_page($post->ID);


/**
*	Get current page id
**/
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

/**
*	Check if contact page
**/
$mx_contact_page = get_option('mx_contact_page');
/**
*	if contact page
**/
if($current_page_id == $mx_contact_page)
{
    include (TEMPLATEPATH . "/template-contact.php");
    die;
}

/**
*	Check if Gallery page
**/
$mx_portfolio_page = get_option('mx_portfolio_page');
/**
*	Check if blog page
**/
$mx_blog_page = get_option('mx_blog_page');


/**
*	if Gallery page
**/
if($current_page_id == $mx_portfolio_page)
{
	$mx_portfolio_style = get_option('mx_portfolio_style');
	
	if(empty($mx_portfolio_style))
	{
		$mx_portfolio_style = 'slider';
	}
	
	include (TEMPLATEPATH . "/template-portfolio-".$mx_portfolio_style.".php");
    exit;
}
/**
*	if blog page
**/
else if($current_page_id == $mx_blog_page)
{
    include (TEMPLATEPATH . "/template-blog.php");
    exit;
}

else
{



get_header(); 
?>


					
</div>
</div>
</div>
<!-- End header -->
		
<br class="clear"/>

<!-- Begin content -->

<div id="content_wrapper_caption">

<div class="inner">

<div class="one_column">
				
<!-- Begin Main Content -->

<div class="<?php echo $page_class; ?>">	
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		

<?php the_content(); ?>

<?php endwhile; ?>
						
</div>
				
					
<!-- End Main Content -->
</div>		
</div>
</div>
<!-- End content -->
		
<br class="clear"/><br/><br/>


<?php get_footer(); ?>

<?php
}
//end if other page
?>