<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-header">
        <p></p>

        
        <h3><?php the_title(); ?></h3>
        <div class="entry-meta">
            <?php the_tags('<span> <i class="fa fa-tag"></i> ', '<i class="fa fa-tag"></i> ', '</span>'); ?>
        </div>
    </div>	
    <div class="entry-post">
        <?php the_content(); ?>
    </div>
    
    <?php
    $aboutauthorstatus = get_option('aboutauthorstatus', FALSE);
    if ($aboutauthorstatus == 'show'):
        ?>
        <div class="media author-details">
            <h2>ABOUT AUTHOR</h2>
            <a class="pull-left" href="#">
                <?php echo get_avatar(get_the_author_meta('ID')); ?>
            </a>
            <div class="media-body">							
                <p><?php echo get_user_meta(get_the_author_meta('ID'), 'description', true); ?></p>
                <div class="author-social">
                    <span><a href="#"><i class="fa fa-facebook"></i></a></span>
                    <span><a href="#"><i class="fa fa-twitter"></i></a></span>
                    <span><a href="#"><i class="fa fa-pinterest"></i></a></span>
                </div>
            </div>
        </div><!--author-details-->
    <?php endif; ?>
    <div class="wp_page_links">
        <?php
        wp_link_pages(array(
            'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'doors') . '</span>',
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>',
        ));
        ?>
    </div>
</article><!-- #post-## -->
