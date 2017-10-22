<?php
/**
 * @package WordPress
 * @subpackage Jungle WordPress
 */
?>  
    <footer class="primary-footer">
    	

		<?php if (ot_get_option('copyright_text') != '' || ot_get_option('footer_social_icons') == 'enabled') { ?>
    	
    	<div class="footer-bottom">
    	
    		<div class="container">
    	
    			<div class="sixteen columns">
    				
    				<small class="copyright">
    					<?php echo ot_get_option('copyright_text'); ?>
    				</small><!-- End of copyright notice -->

    				<?php if(ot_get_option('footer_social_icons') != 'disabled') { ?>
    				<?php 
    				$socials = array('twitter' => ot_get_option("twitter"),'facebook' => ot_get_option("facebook"),'googleplus' => ot_get_option("googleplus"), 'flickr' => ot_get_option("flickr"), 'pinterest' => ot_get_option("pinterest"), 'dribbble' => ot_get_option("dribbble"),'youtube' => ot_get_option("youtube"), 'vimeo' => ot_get_option("vimeo"), 'linkedin' => ot_get_option("linkedin"),'tumblr' => ot_get_option("tumblr")); ?>
    				<nav class="social-links">


						                    
                      　<a href="http://socialcore.jp/site-map/">SITE MAP</a>&nbsp;│&nbsp;
                        <a href="http://socialcore.jp/privacy/">PRIVACY PORICY</a>
                    
                    

					</nav><!-- End of social links -->
					
					<?php } ?>
    			
    			</div><!-- End of sixteen -->
    		
    		</div><!-- End of container -->
		
		</div><!-- End of footer bottom -->
		
		<?php } ?>
    
    </footer>

    <?php if(ot_get_option('boxed') == 'boxy') { ?></div><?php } else { } ?><!-- End of inner -->

<?php if (ot_get_option('google_analytics') != '') { ?>
	<?php echo ot_get_option('google_analytics') ?><!-- GOOGLE ANALYTICS CODE IS INSERTED HERE -->
<?php } ?>                                              

<?php wp_footer(); ?>

</body>
</html>