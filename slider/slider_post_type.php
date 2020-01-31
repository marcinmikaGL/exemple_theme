<?php
// Create Custom Post Type dla zakładki slider 
     
    function register_slides_posttype() {
        $labels = array(
            'name'              => _x( 'Slides', 'post type general name' ),
            'singular_name'     => _x( 'Slide', 'post type singular name' ),
            'add_new'           => __( $GLOBALS['slider_add_new'] ),
            'add_new_item'      => __( $GLOBALS['slider_add_new'] ),
            'edit_item'         => __( $GLOBALS['slider_edit_item'] ),
            'new_item'          => __( $GLOBALS['slider_new_item'] ),
            'view_item'         => __( $GLOBALS['slider_view_item']  ),
            'search_items'      => __($GLOBALS['slider_search_items']  ),
            'not_found'         => __( $GLOBALS['slider_not_found'] ),
            'not_found_in_trash'=> __( $GLOBALS['slider_not_found'] ),
            'parent_item_colon' => __( $GLOBALS['slider_parent_item_colon'] ),
            'menu_name'         => __( $GLOBALS['slider_parent_item_colon'] )
        );
 
        $taxonomies = array();
 
        $supports = array('title','thumbnail','page-attributes','custom-fields');
 
        $post_type_args = array(
            'labels'            => $labels,
            'singular_label'    => __('Slide'),
            'public'            => true,
            'show_ui'           => true,
            'publicly_queryable'=> true,
            'query_var'         => true,
            'capability_type'   => 'post',
            'has_archive'       => false,
            'hierarchical'      => false,
            'rewrite'           => array( 'slug' => 'slides', 'with_front' => false ),
            'supports'          => $supports,
            'menu_position'     => 7,
            'menu_icon'           => 'dashicons-id-alt',
            'taxonomies'        => $taxonomies
        );
        register_post_type('slides',$post_type_args);
    }
    add_action('init', 'register_slides_posttype');
    
    
    function wptuts_slider_template($typ) {
 
        // Query Arguments
        $args = array(
            'post_type' => 'slides',
            'posts_per_page' => 20
        );  
 
        
        $the_query = new WP_Query( $args );
   
        if ( $the_query->have_posts() ) {
 
            // Start the Slider 
            ?>
            <div class="flexslider_<?php echo $typ; ?>">
                <ul class="slides">
 
                    <?php
                    while ( $the_query->have_posts() ) : $the_query->the_post(); 
                   if(strstr(strval(get_post_meta( get_the_id(), 'slider_typ')[0]), $typ) == true ) {
                     ?>
                        <li>
 
                        <?php 
                        // sprawdzanie czy slide jest podlinkowany
                        if ( get_post_meta( get_the_id(), 'wptuts_slideurl', true) != '' ) { ?>
                            <a href="<?php echo esc_url( get_post_meta( get_the_id(), 'wptuts_slideurl', true) ); ?>">
                        <?php }
 
                        // miniaturki slidów
                        echo the_post_thumbnail();
 
                        // guzik zamknięcia
                        if ( get_post_meta( get_the_id(), 'wptuts_slideurl', true) != '' ) { ?>
                            </a>
                        <?php } ?>
 
                        </li>
                    <?php } ?>
                    <?php endwhile; ?>
 
                </ul><!-- .slides -->
            </div><!-- .flexslider -->
 <?php if($typ =='bottom') { ?>        
        <div class="custom-navigation-bottom">
            <a href="#" class="flex-prev"><img src="<?php echo get_template_directory_uri(); ?>/img/strzalka_zaokraglona-lewa.png"></a>
            <a href="#" class="flex-next"><img src="<?php echo get_template_directory_uri(); ?>/img/strzalka_zaokraglona-prawa.png"></a>
        </div>
    <?php } ?>
        <?php }
 
        // Reset Post Data
        wp_reset_postdata();
    }
    
        function wptuts_slider_scripts() {
        wp_enqueue_script( 'jquery' );
 
        wp_enqueue_style( 'flex-style', get_template_directory_uri() . '/slider/css/flexslider.css' );
 
        wp_enqueue_script( 'flex-script', get_template_directory_uri() .  '/slider/js/jquery.flexslider-min.js', array( 'jquery' ), false, true );
    }
    add_action( 'wp_enqueue_scripts', 'wptuts_slider_scripts' );
    
    function wptuts_slider_initialize() { ?>
        <script type="text/javascript" charset="utf-8">
   
            jQuery(window).load(function() {
                <?php  
                   // nie mas potrzeby ładowanie tego kodu po za główną stroną 
                if(is_home() ) { 
                    ?>
                jQuery('.flexslider_top').flexslider({
                    animation: "slider",
                    direction: "horizontal",
                    controlsContainer: $(".custom-controls-container"),
                    customDirectionNav: $(".custom-navigation a"),
                    slideshowSpeed: 5000,
                    animationSpeed: 600
                });
            <?php } ?> 
               jQuery('.flexslider_bottom').flexslider({
                 animation: "slide",
                 animationLoop: true,
                 controlNav: false,
                 itemWidth: 210,
                 itemMargin: 8,
               
                 customDirectionNav: $(".custom-navigation-bottom a")
                });
         
 
 });
        </script>
    <?php }
    add_action( 'wp_head', 'wptuts_slider_initialize' );
    
    ?>