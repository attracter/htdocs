<?php
/******************************************
/* Flickr Widget
******************************************/

class jungle_flickr extends WP_Widget {
	
	function jungle_flickr() {
		
		// define widget title and description
		$widget_ops = array('classname' => 'flickr_widget',
							'description' => __( 'Grabs the images from your Flickr account.','Jungle'));
		// register the widget
		$this->WP_Widget('jungle_flickr', __('Jungle - Flickr', 'Jungle'), $widget_ops);
	
	}
	
	// display the widget in the theme
	function widget( $args, $instance ) {
		extract($args);
		
		$title = apply_filters('widget_title', $instance['title']);
		$number = (int) strip_tags($instance['number']);
		$id = strip_tags($instance['id']);
		
		echo $before_widget; ?>
				  <?php if ( $title )
						echo $before_title . $title . $after_title; ?>
				<div class="flickr-stream-widget">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
				</div>
			<?php
			
		echo $after_widget;
		
		//end
	}
	
	// update the widget when new options have been entered
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) strip_tags($new_instance['number']);
		$instance['id'] = strip_tags($new_instance['id']);

		return $instance;
	}
	
	// print the widget option form on the widget management screen
	function form( $instance ) {

	// combine provided fields with defaults
	$instance = wp_parse_args( (array) $instance, array( 'title' => 'Flickr Feed', 'id' => '', 'number'=> 6 ) );
	$id = strip_tags($instance['id']);
	$number = strip_tags($instance['number']);
	$title = strip_tags($instance['title']);
	
	// print the form fields
	?>

	<p><label for="<?php echo $this->get_field_id('title'); ?>">
	<?php _e('Title:', 'Jungle'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo
		esc_attr($title); ?>" /></p>
	
	<p><label for="<?php echo $this->get_field_id('id'); ?>">Flickr ID</label>
	<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo
		esc_attr($id); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('number'); ?>">
	<?php _e('Number:', 'Jungle'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo
		esc_attr($number); ?>" /></p>

	<?php
	}
}
// register Flickr widget
add_action('widgets_init', create_function('', 'return register_widget("jungle_flickr");'));	

/******************************************
/* Recent posts with thumbs
******************************************/

class Recentposts_thumbnail extends WP_Widget {

	function Recentposts_thumbnail() {
		parent::WP_Widget(false, $name = 'Jungle - Thumbnail Recent Posts');
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
?>
<?php echo $before_widget; ?>
<?php
		if ($title)
			echo $before_title . $title . $after_title; else
			echo '<div class="notitle"></div>';
?>

<?php
	global $post;
	if (get_option('numberofrecent'))
		$numberofrecent = get_option('numberofrecent'); else
		$numberofrecent = 5;
		$q_args = array(
		'numberposts' => $numberofrecent,
	);
	$numberofrecent_posts = get_posts($q_args);
	foreach ($numberofrecent_posts as $post) :
	setup_postdata($post);
?>

<?php if (has_post_thumbnail()) { ?>
	<ul class="blog-posts-widget">
		<li>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail('blog_footer');  ?>
			</a>
		
			<p><a href="<?php the_permalink(); ?>"><?php echo limit_excerpt_length(get_the_excerpt(), '6'); ?></a></p>
		
			<span class="blog-post-widget-meta"><?php the_time(__('M j, Y', 'Jungle')) ?></span>
		</li>
	</ul>
	<?php } else { } ?>

<?php endforeach; ?>

<?php echo $after_widget; ?>
<?php
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			update_option('numberofrecent', $_POST['numberofrecent']);
			return $instance;
		}

		function form($instance) {
			$title = strip_tags($instance['title']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'Jungle'); ?>  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="numberofrecent"><?php _e('Number of posts:', 'Jungle'); ?>  </label><input type="text" name="numberofrecent" id="numberofrecent" size="2" value="<?php echo get_option('numberofrecent'); ?>"/></p>
<?php
		}

	}

	add_action('widgets_init', create_function('', 'return register_widget("Recentposts_thumbnail");'));
?>
<?php 
/******************************************
/* Popular posts with thumbs
******************************************/

class Popularposts_thumbnail extends WP_Widget {

	function Popularposts_thumbnail() {
		parent::WP_Widget(false, $name = 'Jungle - Thumbnail Popular Posts');
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
?>
<?php echo $before_widget; ?>
<?php
		if ($title)
			echo $before_title . $title . $after_title; else
			echo '<div class="notitle"></div>';
?>

<?php
	global $post;
	if (get_option('numberofposts'))
		$numberofposts = get_option('numberofposts'); else
		$numberofposts = 5;

	$popular_posts = new WP_Query('showposts='.$numberofposts.'&orderby=comment_count&order=DESC');

?>

<?php $popular_posts = new WP_Query('showposts='.$numberofposts.'&orderby=comment_count&order=DESC');
			  if($popular_posts->have_posts()) { ?>
				<ul class="blog-posts-widget">	
				<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>				
					<li>
					<?php if(has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog_footer'); ?></a>
						<p><a href="<?php the_permalink(); ?>"><?php echo limit_excerpt_length(get_the_excerpt(), '6'); ?></a></p>
						<span class="blog-post-widget-meta">Posted by <?php the_author_posts_link(); ?></span>
					<?php } elseif(!has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<span class="blog-post-widget-meta-nothumb">Posted by <?php the_author_posts_link(); ?></span>
					<?php } else { } ?>
					</li>
				<?php endwhile; ?>				
				</ul><!-- End of blog posts module-->
			  <?php } ?>

<?php echo $after_widget; ?>
<?php
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			update_option('numberofposts', $_POST['numberofposts']);
			return $instance;
		}

		function form($instance) {
			$title = strip_tags($instance['title']);
?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'Jungle'); ?>  <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="numberofposts"><?php _e('Number of posts:', 'Jungle'); ?>  </label><input type="text" name="numberofposts" id="numberofposts" size="2" value="<?php echo get_option('numberofposts'); ?>"/></p>
<?php
		}

	}

	add_action('widgets_init', create_function('', 'return register_widget("Popularposts_thumbnail");'));
?>
<?php
/*****************************************************
 * Recent, Popular and latest comments tabs widget
*****************************************************/

//Load the tabs widget
add_action('widgets_init', 'Jungle_Tabs_Widget'); 
function Jungle_Tabs_Widget() 
{ 
	register_widget('Jungle_Tabs');  
}  
class Jungle_Tabs extends WP_Widget {
	
	function Jungle_Tabs() {
		// widget actual processes
		// widget settings  
		$widget_ops = array( 'classname' => 'jungle_tabs', 'description' => 'Displays latest popular or recent posts and latest comments.' );
		// widget control settings
		$control_ops = array( 'id_base' => 'jungle_tabs', 'width' => 250, 'height' => 350 );
		// create the widget
		$this->WP_Widget( 'jungle_tabs', 'Jungle - Tabs', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
	//output the contents of the widget
	global $post;
	extract( $args );

	/* User-selected settings. */
	$popular = $instance['popular'];
	$recent = $instance['recent'];
	$comments = $instance['comments'];

	echo $before_widget; ?>
	
	<div class="featured-posts-tab">
			<ul class="nav-tabs" id="featured-tab">
			  <?php if($popular) { ?><li><a href="#popular"><?php _e('Popular', 'Jungle'); ?></a></li><?php } ?>
			  <?php if($recent) { ?><li><a href="#recent"><?php _e('Recent', 'Jungle'); ?></a></li><?php } ?>
			  <?php if($comments) { ?><li><a href="#comments"><?php _e('Comments', 'Jungle'); ?></a></li><?php } ?>
			</ul>
			<div class="tab-content" id="popular">
			<?php if($popular != '') { ?>
			  <?php $popular_posts = new WP_Query('showposts='.$popular.'&orderby=comment_count&order=DESC');
			  if($popular_posts->have_posts()) { ?>
				<ul class="blog-posts-widget">	
				<?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>				
					<li>
					<?php if(has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog_footer'); ?></a>
						<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
						<span class="blog-post-widget-meta"><?php the_time('F j Y'); ?></span>
					<?php } elseif(!has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<span class="blog-post-widget-meta-nothumb"><?php the_time('F j Y'); ?></span>
					<?php } else { } ?>
					</li>
				<?php endwhile; ?>				
				</ul><!-- End of blog posts module-->
			  <?php } ?>
			<?php } ?>
			</div> <!-- End of popular posts -->

			<div class="tab-content" id="recent">
			<?php if($recent != '') { ?>
			  <?php $recent_posts = new WP_Query('showposts='.$recent);
			  if($recent_posts->have_posts()) { ?>
				<ul class="blog-posts-widget">	
				<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>				
					<li>
					<?php if(has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog_footer'); ?></a>
						<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
						<span class="blog-post-widget-meta"><?php the_time('F j Y'); ?></span>
					<?php } elseif(!has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<span class="blog-post-widget-meta-nothumb"><?php the_time('F j Y'); ?></span>
					<?php } else { } ?>
					</li>
				<?php endwhile; ?>				
				</ul><!-- End of blog posts module-->
			  <?php } ?>
			<?php } ?>
			</div><!-- End of popular posts -->

			<div class="tab-content" id="comments">
			<?php if($comments != '') { ?>
			  <?php global $wpdb; 
			  $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,110) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $comments";
			  $latest_comments = $wpdb->get_results($sql); ?> 
				<ul class="blog-posts-widget">
					<?php foreach ($latest_comments as $comment) { ?>
					<li>
						<a href="<?php echo get_permalink($comment->ID); ?>"><?php echo get_avatar($comment, '52'); ?></a>
						<p><?php echo strip_tags($comment->comment_author); ?></p>
						<span class="blog-post-widget-meta"><?php echo $comment->post_title; ?></span>
					</li>
					<?php } ?>
				</ul><!-- End of blog posts module -->
			<?php } ?>
			</div><!-- End of latest comments -->

	</div><!-- End of tabs sidebar widget -->

	<?php 
	echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance['popular'] = $new_instance['popular'];
		$instance['recent'] = $new_instance['recent'];
		$instance['comments'] = $new_instance['comments'];
		return $instance;
	}	
	
	function form($instance) {
		// outputs the options form on admin
		// Set up some default widget settings
		$defaults = array('recent' => '3', 'comments' => '3', 'popular' => '3');
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('popular'); ?>"><?php _e('Number of popular posts:', 'Jungle') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'popular' ); ?>" name="<?php echo $this->get_field_name( 'popular' ); ?>" value="<?php echo $instance['popular']; ?>" style="width:30px" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('recent'); ?>"><?php _e('Number of recent posts:', 'Jungle') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'recent' ); ?>" name="<?php echo $this->get_field_name( 'recent' ); ?>" value="<?php echo $instance['recent']; ?>" style="width:30px" />
		</p>  
		<p>
			<label for="<?php echo $this->get_field_id('comments'); ?>"><?php _e('Number of comments:', 'Jungle') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'comments' ); ?>" name="<?php echo $this->get_field_name( 'comments' ); ?>" value="<?php echo $instance['comments']; ?>" style="width:30px" />
		</p>    

	<?php }

}

?>
<?php 
/******************************************
/* Twitter Widget API 1.1
******************************************/

class Tweets_Widget extends WP_Widget {
	
	function Tweets_Widget()
	{
		$widget_ops = array('classname' => 'tweets', 'description' => 'Twitter widget that displays latest tweets');

		$control_ops = array('id_base' => 'tweets-widget');

		$this->WP_Widget('tweets-widget', 'Jungle - Latest Tweets', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$consumer_key = $instance['consumer_key'];
		$consumer_secret = $instance['consumer_secret'];
		$access_token = $instance['access_token'];
		$access_token_secret = $instance['access_token_secret'];
		$twitter_id = $instance['twitter_id'];
		$count = $instance['count'];

		echo $before_widget;
		
		if($title) {
			echo $before_title.$title.$after_title;
		}
		
		if($twitter_id && $consumer_key && $consumer_secret && $access_token && $access_token_secret && $count) { 
		$transName = 'list_tweets_'.$args['widget_id'];
		$cacheTime = 10;
		delete_transient($transName);
		if(false === ($twitterData = get_transient($transName))) {
		     // require the twitter auth class
		     @require_once 'oauth/twitteroauth.php';
		     $twitterConnection = new TwitterOAuth(
							$consumer_key,
							$consumer_secret,
							$access_token,
							$access_token_secret
							);
		    $twitterData = $twitterConnection->get(
							  'statuses/user_timeline',
							  array(
							    'screen_name'     => $twitter_id,
							    'count'           => $count,
							    'exclude_replies' => false
							  )
							);
		     if($twitterConnection->http_code != 200)
		     {
		          $twitterData = get_transient($transName);
		     }

		     set_transient($transName, $twitterData, 60 * $cacheTime);
		};
		$twitter = get_transient($transName);
		if($twitter && is_array($twitter)) {
		?>
		<div class="twitters" id="tweets_<?php echo $args['widget_id']; ?>">
			<ul>
				<?php foreach($twitter as $tweet): ?>
				<li>
					<!-- <p> -->
						<?php
						$latestTweet = $tweet->text;
						$latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet);
						$latestTweet = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet);
						echo $latestTweet;
						?>

					<!-- </p> -->
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php }}
		
		echo $after_widget;
	}
	
	function ago($time)
	{
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");

	   $now = time();

	       $difference     = $now - $time;
	       $tense         = "ago";

	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	       $difference /= $lengths[$j];
	   }

	   $difference = round($difference);

	   if($difference != 1) {
	       $periods[$j].= "s";
	   }

	   return "$difference $periods[$j] ago ";
	}

	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		$instance['twitter_id'] = $new_instance['twitter_id'];
		$instance['count'] = $new_instance['count'];

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Latest Tweets', 'twitter_id' => '', 'count' => 3);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:', 'Jungle'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php echo __('Consumer Key:', 'Jungle'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>" value="<?php echo $instance['consumer_key']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('consumer_secret'); ?>"><?php echo __('Consumer Secret:', 'Jungle'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('consumer_secret'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>" value="<?php echo $instance['consumer_secret']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php echo __('Access Token:', 'Jungle'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" value="<?php echo $instance['access_token']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('access_token_secret'); ?>"><?php echo __('Access Token Secret:', 'Jungle'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('access_token_secret'); ?>" name="<?php echo $this->get_field_name('access_token_secret'); ?>" value="<?php echo $instance['access_token_secret']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php echo __('Yours or others twitter ID:', 'Jungle'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo $instance['twitter_id']; ?>" />
		</p>

			<label for="<?php echo $this->get_field_id('count'); ?>"><?php echo __('Number of Tweets:', 'Jungle'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>" />
		</p>

	<?php
	}
}
// Register Twitter WIdget
add_action('widgets_init', create_function('', 'return register_widget("Tweets_Widget");'));
?>