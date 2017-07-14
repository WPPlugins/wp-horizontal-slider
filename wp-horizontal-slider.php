<?php
/*
 Plugin Name: WP Horizontal Slider
 Plugin URI: http://pietaslabs.com
 Description: A plugin that allows you to show the featured images of the available posts. 
 Author: Subhransu Sekhar
 Version: 1.0
 Author URI: http://pietaslabs.com
 */
add_theme_support('post-thumbnails');
add_action('admin_menu', 'wphs_add_menu');
add_action('admin_init', 'wphs_reg_function' );

register_activation_hook( __FILE__, 'wphs_activate' );



function wphs_add_menu() {
	$page = add_options_page('WP Horizontal Slider', 'WP Horizontal Slider', 'administrator', 'wphs_menu', 'wphs_menu_function');
}

function wphs_reg_function() {
	register_setting( 'wphs-settings-group', 'wphs_category' );
	register_setting( 'wphs-settings-group', 'wphs_post_type' );
}

function wphs_activate() {
	add_option('wphs_category','1');
	add_option('wphs_post_type','post');
}

add_action('init', 'wp_horizontal_slider_script');


function wp_horizontal_slider_script() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', WP_PLUGIN_URL . '/wp-horizontal-slider/jquery.min.js');
	wp_enqueue_script( 'jquery' );
	wp_register_script('wp_horizontal_slider', WP_PLUGIN_URL . '/wp-horizontal-slider/wp-horizontal-slider.js');
	wp_enqueue_script('wp_horizontal_slider');

	wp_register_style('wp_horizontal_slider', WP_PLUGIN_URL . '/wp-horizontal-slider/wp-horizontal-slider.css');
	wp_enqueue_style('wp_horizontal_slider');

}
function show_wp_horizontal_slider() {
	?>
<div class="infiniteCarousel">
<div class="gallery">
<ul>
<?php
global $wp_query;
$category=get_option('wphs_category');
$post_type=get_option('wphs_post_type');
$args = array_merge( $wp_query->query, array( 'post_type' => $post_type,'cat'	=>	$category,'posts_per_page'	=> 5) );
query_posts( $args );
if( have_posts() ) : while( have_posts() ) : the_post(); ?>

<?php if(has_post_thumbnail()) : ?>
	<li><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></li>
	<?php endif; ?>
	<?php endwhile; endif;?>
	<?php wp_reset_query();?>
</ul>
</div>
</div>

	<?php
}

function wphs_menu_function() {

	?>

<div class="wrap">
<h2>WP Horizontal Slider</h2>

<form method="post" action="options.php"><?php settings_fields( 'wphs-settings-group' ); ?>
<table class="form-table">

	<tr valign="top">
        <th scope="row">Category</th>
        <td>
        <select name="wpns_category" id="wpns_category"> 
			 <option value="">Select a Category</option> 
 			<?php 
 				$category = get_option('wphs_category');
  				$categories=  get_categories(); 
  				foreach ($categories as $cat) {
  					$option = '<option value="'.$cat->term_id.'"';
  					if ($category == $cat->term_id) $option .= ' selected="selected">';
  					else { $option .= '>'; }
					$option .= $cat->cat_name;
					$option .= ' ('.$cat->category_count.')';
					$option .= '</option>';
					echo $option;
  				}
 			?>
		</select>

        </tr>
	<tr valign="top">
		<th scope="row">Post Type</th>
		<td><label> <input type="text" name="wphs_post_type"
			id="wphs_post_type" size="7"
			value="<?php echo get_option('wphs_post_type'); ?>" /> </label>
	
	</tr>

</table>

<p class="submit"><input type="submit" class="button-primary"
	value="<?php _e('Save Changes') ?>" /></p>

</form>
</div>

			<?php } ?>
