<?php
/**
 * The main template file for display contact page.
 *
 * @package WordPress
 * @subpackage Soomo
*/


/**
*	if not submit form
**/
if(!isset($_POST['your_name']))
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

<div class="two_column_left">
				
						
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		

<?php the_content(); ?>

						<?php endwhile; ?>
						
						
						<form id="contact_form" method="post" action="<?php echo curPageURL(); ?>">
						    <p>
						    	<label for="your_name">Name</label><br/>
						    	<input id="your_name" name="your_name" type="text" style="width:94%"/>
						    </p>
						    <p style="margin-top:20px">
						    	<label for="email">Email</label><br/>
						    	<input id="email" name="email" type="text" style="width:94%"/>
						    </p>
						    <p style="margin-top:20px">
						    	<label for="message">Message</label><br/>
						    	<textarea id="message" name="message" rows="7" cols="10" style="width:94%"></textarea>
						    </p>
						    <p style="margin-top:20px">
						    	<input type="submit" value="Send Message"/>
						    </p>
						</form>
						<div id="reponse_msg"></div>
						
</div>
					
<!-- End Main Content -->
                
<div class="two_column_right">

<?php get_sidebar('contact'); ?>

</div>
					
<!-- End Sidebar -->
		
</div>
		
</div>

</div>
<!-- End content -->
		
<br class="clear"/><br/><br/>
				

<?php get_footer(); ?>
				
				
<?php
}

//if submit form
else
{

	/*
	|--------------------------------------------------------------------------
	| Mailer module
	|--------------------------------------------------------------------------
	|
	| These module are used when sending email from contact form
	|
	*/
	
	//Get your email address
	$contact_email = get_option('mx_contact_email');
	
	//Enter your email address, email from contact form will send to this addresss. Please enter inside quotes ('myemail@email.com')
	define('DEST_EMAIL', $contact_email);
	
	//Change email subject to something more meaningful
	define('SUBJECT_EMAIL', 'Email from contact form');
	
	//Thankyou message when message sent
	define('THANKYOU_MESSAGE', 'Thank you! We will get back to you as soon as possible');
	
	//Error message when message can't send
	define('ERROR_MESSAGE', 'Oops! something went wrong, please try to submit later.');
	
	
	/*
	|
	| Begin sending mail
	|
	*/
	
	$from_name = $_POST['your_name'];
	$from_email = $_POST['email'];
	
	$message = 'Name: '.$from_name.PHP_EOL;
	$message.= 'Email: '.$from_email.PHP_EOL.PHP_EOL;
	$message.= 'Message: '.PHP_EOL.$_POST['message'];
	    
	
	if(!empty($from_name) && !empty($from_email) && !empty($message))
	{
		mail(DEST_EMAIL, SUBJECT_EMAIL, $message);
	
		echo THANKYOU_MESSAGE;
		echo '</p>';
		
		exit;
	}
	else
	{
		echo ERROR_MESSAGE;
		
		exit;
	}
	
	/*
	|
	| End sending mail
	|
	*/
}

?>