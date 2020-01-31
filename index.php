<?php
/**
 * @package WordPress
 * @subpackage weblider
 * @since 0.1.0
 * widok strony głównej
 */
get_header();

if(is_home() ) {
    
 $offers_args = array(
            'post_type' => 'offer',
            'order' => 'ASC',   
            'posts_per_page' => 5   
            );
               $ofers = new WP_Query( $offers_args );
               
     

?>
    <div class="slider_top row">
        <div class="slider col-12">   
         <?php echo wptuts_slider_template('top'); ?>
        </div>
    </div>
   <hr class="hr_top">
    <div class="offers row">
        <div class="title col-12"><h3><?php echo $GLOBALS['offers_title']; ?></h3></div>    
        <?php         
          
            if( $ofers->have_posts() ){
                  while( $ofers->have_posts() ) {
                    $ofers->the_post();
        ?>
        
    <div class="post col-sm-12 col-md-2dot4">
     <a href="<?php echo $GLOBALS['offers_title'] ?>/<?php  the_title();  ?>">  
	 <?php the_post_thumbnail( 'large' ); ?> 
       <div class="post_tite"><?php   echo  substr(the_title(),0,50);  ?></div>
       <div class="post_disc"><?php echo  substr($post->post_excerpt,0,250); ?></div>
	 </a>  
    </div>  
	
 <?php 
  }
} 
?>
                
    </div>
<div class="row calender_blog">
        <div class="calender col-sm-12 col-md-4">
            <div class="title">
                <h3><?php echo $GLOBALS['calender']; ?></h3>
            </div>    
                
                <div class="calender">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/kalendarz.png">
                      <?php 
                $blogs_args = array(
            'post_type' => 'post',   
            'posts_per_page' => 2   
            );
            
               $blogs = new WP_Query( $blogs_args );
               ?>
                
                <?php         
          
            if( $blogs->have_posts() ){
                  while( $blogs->have_posts() ) {
                    $blogs->the_post();
                    ?>
                <p class="disct">
                    <strong> <?php echo get_the_date(); ?> </strong> <a href="<?php echo $post->guid ; ?>" class="calender_post_title"><?php echo  substr(the_title(),0,50); ?></a> <br>
                    <span><?php if(!empty($post->post_content)) {  echo substr(strip_tags($post->post_content),0,100) . '...'; } ?></span>
                </p>    
                   
          <?php 
  }
} 
?>       
            <span class="blog_post_title"> <?php echo $GLOBALS['show_more']; ?> </span>                    
            </div>    
          
        </div>
        <div class="blog col-sm-12 col-md-4">
          <div class="title">
              <h3><?php echo $GLOBALS['blog']; ?></h3>
          </div>    
              <div class="blog">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/blog.png">
                       
                <?php         
          
            if( $blogs->have_posts() ){
                  while( $blogs->have_posts() ) {
                    $blogs->the_post();
                    ?>
                <p class="disct">
                    <a  href="# <?php echo $post->guid ; ?>" class="blog_post_title"><?php echo  substr(the_title(),0,50); ?></a> <br>
                    <strong> <?php echo get_the_date(); ?> </strong> <br>
                    <span><?php if(!empty($post->post_content)) {  echo substr(strip_tags($post->post_content),0,100) . '...'; } ?></span>
                </p>    
                   
          <?php 
  }
} 
?>       
                <span class="blog_post_title"> <?php echo $GLOBALS['show_more']; ?> </span>
                </div>
          </div>  
       
	
    <div class="megers col-sm-12 col-md-3 ml-auto">
            <div class="megers_top"><h3><?php echo $GLOBALS['megers_top'] ; ?></h3></div>
            <div class="megers_disc">
           <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('megers-sidebar') ) : 
           endif; ?>
            </div>
    </div>
    
    
</div>
   <div class="row">
       <div class="col-sm-12 col-md-3 ml-auto megers_button"><?php echo $GLOBALS['become_member']; ?> <button><i class="material-icons">arrow_forward</i></button></div>
   </div>  
<?php
} else {
    include('page.php');
}
get_footer();
