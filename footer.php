<?php
/**
 * @package WordPress
 * @subpackage weblider
 * @since 0.1.0
 */
?>

</div> <!-- .contener -->
<div class="logo_slider">
     <?php echo wptuts_slider_template('bottom'); ?>
    <div class="move_top"><a href="#top"><i class="material-icons">arrow_upward</i><span><?php echo $GLOBALS['footer-move_to_top']; ?></span></a></div>
</div>
    <footer id="site-footer" role="contentinfo" class="header-footer">
        <div class="container section-inner">
            <div class="footer-credits">
                    <p class="footer-copyright">
                    <?php echo $GLOBALS['footer-copyright_1']; ?>  
                    </p>
                    <p class="footer-copyright">
                      <?php echo $GLOBALS['footer-copyright_2']; ?>    
                    </p>

		</div><!-- .footer-credits -->
				
	</div><!-- .section-inner -->

    </footer>

<?php wp_footer(); ?>
     <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/gallery/js/lightbox.js"></script>
</body>
</html>
