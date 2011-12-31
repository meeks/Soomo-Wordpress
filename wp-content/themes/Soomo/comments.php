<?php
if ( post_password_required() ) { ?>
	<p>This post is password protected. Enter the password to view comments.</p>
<?php
	return;
}

if( have_comments() ) : ?> 
					
					<h5><?php comments_number('No comment', 'Comment', '% Comments'); ?> for <?php the_title(); ?></h5><br/><br/>

					<?php wp_list_comments( array('callback' => 'soomo_comment', 'avatar_size' => '40') ); ?>
					
					<!-- End of thread -->  
					<br class="clear"/><br/>
<?php endif; ?>  


<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

<div class="pagination">

<p><?php previous_comments_link(); ?> <?php next_comments_link(); ?></p>

</div>

<br class="clear"/>
            
</div><br/><br/>
<?php endif; // check for comment navigation ?>


<?php if ('open' == $post->comment_status) : ?> 

		<div id="respond">
			<?php include(TEMPLATEPATH . '/comments-form.php'); ?>
		</div>
			
<?php endif; ?> 