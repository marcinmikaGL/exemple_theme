<?php
/**
/**
 * @package WordPress
 * @subpackage weblider
 * @since 0.1.0
 */

//import słownika 
include_once('translate.php');

// wymiary logotypu 
$GLOBALS['logo_width']  = 115;
$GLOBALS['logo_height'] = 76; 

// kolor tła
$GLOBALS['gackground_color'] = 'f5efe0'; 

// ilość slidów na stronie głównej
$GLOBALS['posts_per_page'] = 5;


// funkcja konfiguracyjna
function weblider_setup() {
    
    load_theme_textdomain( 'weblider' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support(
        'custom-background', array(
	'default-color' => $GLOBALS['gackground_color'] ,
		)
    );

   
    add_theme_support(
	'custom-logo', array(
	 'height'      => $GLOBALS['logo_height'],
	 'width'       => $GLOBALS['logo_width'],
	 'flex-height' => true,
	 'flex-width'  => true,
	 )
    );
    add_theme_support(
	'html5',
	array(
            'search-form',
	    'comment-form',
	    'comment-list',
	    'gallery',
            'caption',
            'script',
            'style',
	)
    );
}

// Slider
require( get_template_directory() . '/slider/slider_post_type.php' );
require( get_template_directory() . '/slider/slider.php' );


// dodanie obsługi ofert
function post_type() {
    $labels = array(
        'name'                => $GLOBALS['offer_title'],
        'singular_name'       => $GLOBALS['offer_title'],
        'menu_name'           => $GLOBALS['offer_title'],
        'parent_item_colon'   => $GLOBALS['parent_item_colon'],
        'all_items'           => $GLOBALS['all_items'],
        'view_item'           => $GLOBALS['view_item'],
        'add_new_item'        => $GLOBALS[' add_new_item'],
        'add_new'             => $GLOBALS['add_new'],
        'edit_item'           => $GLOBALS['edit_item'],
        'update_item'         => $GLOBALS['update_item'],
        'search_items'        => $GLOBALS['search_items'],
        'not_found'           => $GLOBALS['not_found'],
        'not_found_in_trash'  => $GLOBALS['not_found']
    ); 
    
    $args = array(
        'label' => 'offer',
        'rewrite' => array(
            'slug' => 'oferty'
        ),
        'description'         => $GLOBALS['offer_title'],
        'labels'              => $labels,
        'supports'            => array( 'title', 'thumbnail'),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true, 
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-id-alt',
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'supports'           => array( 'title', 'editor','excerpt', 'author', 'thumbnail' ),
        'capability_type'     => 'post',
    );
    register_post_type( 'offer', $args );
} 

// dodanie logotypu	
function themename_weblider_logo_setup() {
    $defaults = array(
        'height'      => $GLOBALS['logo_height'],
        'width'       => $GLOBALS['logo_width'],
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}

// dodanie obsługi menu
register_nav_menus( array(
    'primary' => __( 'Primary Navigation', 'weblider' ),
) );


// obsługa wigetów 
function megers_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Megers Wiget', 'smallenvelop' ),
        'id' => 'megers-sidebar',
        'before_widget' => '<div class="megers_wiget">',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );
}



function  weblider_gallery($attr) {
   

    $post = get_post();

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	
	$output = apply_filters( 'post_gallery', '', $attr, $instance );

	if ( ! empty( $output ) ) {
		return $output;
	}

	$html5 = current_theme_supports( 'html5', 'gallery' );
	$atts  = shortcode_atts(
		array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => $html5 ? 'figure' : 'dl',
			'icontag'    => $html5 ? 'div' : 'dt',
			'captiontag' => $html5 ? 'figcaption' : 'dd',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			'link'       => '',
		),
		$attr,
		'gallery'
	);

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts(
			array(
				'include'        => $atts['include'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'exclude'        => $atts['exclude'],
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	} else {
		$attachments = get_children(
			array(
				'post_parent'    => $id,
				'post_status'    => 'inherit',
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'order'          => $atts['order'],
				'orderby'        => $atts['orderby'],
			)
		);
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) {
			$output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
		}
		return $output;
	}

	$itemtag    = tag_escape( $atts['itemtag'] );
	$captiontag = tag_escape( $atts['captiontag'] );
	$icontag    = tag_escape( $atts['icontag'] );
	$valid_tags = wp_kses_allowed_html( 'post' );
	if ( ! isset( $valid_tags[ $itemtag ] ) ) {
		$itemtag = 'dl';
	}
	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
		$captiontag = 'dd';
	}
	if ( ! isset( $valid_tags[ $icontag ] ) ) {
		$icontag = 'dt';
	}

	$columns   = intval( $atts['columns'] );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float     = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = '';


	if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
		$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';

		$gallery_style = "
		<style{$type_attr}>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
			/* see gallery_shortcode() in wp-includes/media.php */
		</style>\n\t\t";
	}

	$size_class  = sanitize_html_class( $atts['size'] );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";


	$output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

	$i = 0;

	foreach ( $attachments as $id => $attachment ) {

		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';

		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
                
                $image_output = str_replace('<a','<a data-lightbox="serek" ',$image_output);
                        
		$image_meta = wp_get_attachment_metadata( $id );

		$orientation = '';

		if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
			$orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
		}

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon {$orientation}'>
				$image_output
			</{$icontag}>";

		if ( $captiontag && trim( $attachment->post_excerpt ) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
				" . wptexturize( $attachment->post_excerpt ) . "
				</{$captiontag}>";
		}

		$output .= "</{$itemtag}>";

		if ( ! $html5 && $columns > 0 && ++$i % $columns === 0 ) {
			$output .= '<br style="clear: both" />';
		}
	}

	if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
		$output .= "
			<br style='clear: both' />";
	}

	$output .= "
		</div>\n";

	return $output;
    
}



remove_shortcode('gallery');
add_shortcode('gallery', 'weblider_gallery');
add_action( 'widgets_init', 'megers_widgets_init' );


add_theme_support('post-thumbnails');
add_action( 'after_setup_theme', 'weblider_setup' );
add_filter('the_content', 'do_shortcode');
//wp_enqueue_style( 'style', get_stylesheet_uri() );
add_action( 'init', 'post_type', 0 );
add_action( 'after_setup_theme', 'themename_weblider_logo_setup' );