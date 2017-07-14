<?php

/*
 Plugin Name: Product Gallery
 Plugin URI: http://pietaslabs.com
 Description: Product gallery horizontal slider
 Author: Subhransu (Pietas)
 Version: 1.0
 Author URI: http://pietaslabs.com
 */

add_action('init', 'product_gallery_script');


function product_gallery_script() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', WP_PLUGIN_URL . '/product-gallery/product-gallery.js');
	wp_enqueue_script( 'jquery' );
	wp_register_script('product_gallery', WP_PLUGIN_URL . '/product-gallery/product-gallery.js');
	wp_enqueue_script('product_gallery');

	wp_register_style('product_gallery', WP_PLUGIN_URL . '/product-gallery/product-gallery.css');
	wp_enqueue_style('product_gallery');

}

function show_product_gallery() {
	?>
<div class="infiniteCarousel">
<div class="gallery">
<ul>
<?php
global $wp_query;
$args = array_merge( $wp_query->query, array( 'post_type' => 'product' ) );
query_posts( $args );
if( have_posts() ) : while( have_posts() ) : the_post(); ?>

<?php if(has_post_thumbnail()) : ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('product-slider'); ?></a></li>
	<?php endif; ?>
	<?php endwhile; endif;?>
	<?php wp_reset_query();?>
</ul>
</div>
</div>

	<?php
}
?>