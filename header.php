<?php
/**
 * @package WordPress
 * @subpackage weblider
 * @since 0.1.0
 */
?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_template_directory_uri(); ?>/gallery/css/lightbox.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap-grid.css" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_template_directory_uri(); ?>/css/style.css" />
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/gallery/js/lightbox.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-3.4.1.min.js"></script>
        <?php wp_head(); ?>

    </head>

    <body class="body_content">
    <div class="container">    
    <div id="top" class="top_header">    
        <div class="logo_header"> <?php if ( function_exists( 'the_custom_logo' ) ) { the_custom_logo(); } ?> </div>
        <div class="lang_header">
            <input type="text" class="find_input" placeholder="szukaj">
            <input class="submit_button" type="image" src="<?php echo get_template_directory_uri(); ?>/img/szukaj.png" alt="Submit" width="30" height="30">
            <button class="lang_button">EN</button>
            <button class="lang_button">PL</button>
        </div>
       
    </div>
  
   
        <div class="hamburger_top" id="menu_top row">
         <input type="radio" name="m1" id="main-menu-toggle-ch1" class="menu-toggle-btn-ch" checked>
         <label id="hamburger" for="main-menu-toggle-ch2" class="menu-toggle-btn-label"><i class="material-icons md-48">menu</i></label>
         <input type="radio" name="m1" id="main-menu-toggle-ch2" class="menu-toggle-btn-ch">
        
          
         <?php 
         $menu  = wp_nav_menu( array( 
             'theme_location' => 'primary',
             'container_class' => 'nav-menu', 
             'menu_class' => 'nav-menu', 
             'menu_id' => 'primary-menu', 
             'echo'           => FALSE,
             'sort_column' => 'menu_order,
              post_title' ) );
         // rozwiążanie mało eleganckie ale szybkie i działa :-) 
         if(!empty($menu)) {
            $menu = str_replace('<div class="nav-menu">', '<div class="nav-menu"> <label for="main-menu-toggle-ch1" class="menu-toggle-btn-label"> <i class="material-icons">close</i></label>',$menu);
             echo $menu;
             
         } else {
           echo  $GLOBALS['menu_error'];
         }
         
         ?>
        
        </div>    
 
