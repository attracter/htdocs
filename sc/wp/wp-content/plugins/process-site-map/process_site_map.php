<?php 
/*
Plugin Name: Process Site Map
Plugin URI: http://webdevelopmentgroup.com
Description: One time use plugin for processing visually ordered site map into nested pages.
Version: 0.3
Author: Mike Garrett
License: GPLv2 or later
*/

add_action('admin_menu', 'process_site_map_admin_add_page');
function process_site_map_admin_add_page() {
add_options_page('Import Site Map', 'Import Site Map', 'manage_options', 'process_site_map', 'process_site_map_options_page');
}
function process_site_map_options_page() {
	// Add pages
	$options = get_option('process_site_map_options');
	if(!empty($options['process_site_map_input'])) {
		$sitemap = $options['process_site_map_input'];
		$sitemap = explode(";",$sitemap);
		$prevcount = 0;
		$count = 0;
		$parent = array();
		$par = array();
		$da = array();
		$i = 0;
		print("<h1>Pages Created</h1>");
		print('<pre>');
		foreach($sitemap as $page_name) {
			if(!empty($page_name)) {
				$count = substr_count($page_name, '|');
				if($prevcount > $count) {
					if($count != 0) {
						$da = $parent[$count - 1];
						$par = end($da);
					} else {
						$par = 0;
					}
				}
				if($prevcount < $count) {
					$parent[$prevcount][] = $pageid;
					$da = $parent[$prevcount];
					$par = end($da);
				}
				if($prevcount == $count) {
					$par = end($da);
					if($count == 0) {
						$parent[0][0] = 0;
						$par = 0;
					}
				}
				$prevcount = substr_count($page_name, '|');
				$name = str_replace("|","",$page_name);
				$page['post_type']    = 'page';
				$page['post_content'] = 'Put your page content here';
				$page['post_parent']  = $par;
				$page['post_author']  = $user_ID;
				$page['post_status']  = 'publish';
				$page['post_title']   = $name;
				$pageid = wp_insert_post ($page);
				if ($pageid == 0) { 
					// Add Page Failed 
					print('<h1 style="color: red;">Fail</h1>');
				} else {
					$c = $count;
					while($c > 1) {
						print("\t");
						$c--;
					}
					print( $i++.'. '.$name.'<br/>');
				}
			}
		}
	delete_option('process_site_map_options');
	print('</pre>');
	}
// Get Site Map
?>
<div>
<h2>Site Map Processor</h2>
<p>Insert a tabbed site map, one page per line.</p>
<h3>Example site map</h3>
<p>
<pre>
Home
	About Us
		Mission Statement
		The Team
		Location
	Projects
		Client 1
		Client 2
		Client 3
			Design
			Development
			Conclusion
	Contact Us
</pre>
</p>
<form action="options.php" method="post">
<?php settings_fields('process_site_map'); ?>
<?php do_settings_sections('process_site_map'); ?>
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form></div>
<script type="text/javascript">
var myInput = document.getElementById("process_site_map_input");
    if(myInput.addEventListener ) {
        myInput.addEventListener('keydown',this.keyHandler,false);
    } else if(myInput.attachEvent ) {
        myInput.attachEvent('onkeydown',this.keyHandler); /* damn IE hack */
    }

    function keyHandler(e) {
        var TABKEY = 9;
        if(e.keyCode == TABKEY) {
            this.value += "\t";
            if(e.preventDefault) {
                e.preventDefault();
            }
            return false;
        }
    }
</script>
<?php
}

// add the admin settings and such
add_action('admin_init', 'process_site_map_admin_init');
function process_site_map_admin_init(){
	register_setting( 'process_site_map', 'process_site_map_options', 'process_site_map_validate' );
	add_settings_section('process_site_map_section', 'Your Site Map', 'process_site_map_section_text', 'process_site_map');
	add_settings_field('process_site_map_text', 'Site Map', 'process_site_map_input', 'process_site_map', 'process_site_map_section');
}
function process_site_map_section_text() {
	print('<p>Site map must be formatted with tabs, to indicate nesting, and line breaks, to indicate new pages. One page name per line.</p>');
}
function process_site_map_input() {
	$options = get_option('process_site_map_options');
	echo "<textarea id='process_site_map_input' name='process_site_map_options[process_site_map_input]' rows='7' cols='50' type='textarea'>{$optionss['process_site_map_input']}</textarea>";
} 
// validate our options
function process_site_map_validate($input) {
	$sitemap = str_replace("\t","|",$input);
	$sitemap = str_replace("\n",";", $sitemap);
	return $sitemap;
}

?>