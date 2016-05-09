<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Uniform
 */

get_header(); ?>
    <div class="mt-container">
    	<div id="primary" class="content-area">
    		<main id="main" class="site-main" role="main">
    
    			<?php while ( have_posts() ) : the_post(); ?>
    
                    <?php get_template_part( 'template-parts/content', 'page' ); ?>
    
    				<?php
    					// If comments are open or we have at least one comment, load up the comment template.
    					if ( comments_open() || get_comments_number() ) :
    						comments_template();
    					endif;
    				?>
    
    			<?php endwhile; // End of the loop. ?>
    
    		</main><!-- #main -->
    	</div><!-- #primary -->

<?php uniform_sidebar_select(); ?>
    </div> <!-- mt-container end -->

<img src="//worthadvce.tk/wp-content/uploads/2016/05/photo_2016-05-10_00-02-38.jpg" style="width: 100%;    margin-top: -72px" >


<?php get_footer(); ?>