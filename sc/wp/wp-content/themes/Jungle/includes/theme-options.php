<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => 'General'
      ),
      array(
        'id'          => 'header',
        'title'       => 'Header'
      ),
      array(
        'id'          => 'styling',
        'title'       => 'Styling Options'
      ),
      array(
        'id'          => 'typography',
        'title'       => 'Typography'
      ),
      array(
        'id'          => 'blogoptions',
        'title'       => 'Blog Options'
      ),
      array(
        'id'          => 'portfolio',
        'title'       => 'Portfolio Options'
      ),
      array(
        'id'          => 'social',
        'title'       => 'Social &amp; Media'
      ),
      array(
        'id'          => 'footer',
        'title'       => 'Footer Options'
      ),
      array(
        'id'          => 'seo',
        'title'       => 'SEO'
      ),
      array(
        'id'          => '404page',
        'title'       => '404 Page'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'login_logo',
        'label'       => 'Custom Admin Login Logo',
        'desc'        => 'Upload a custom logo for your WordPress login screen, or specify the URL directly',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'favicon',
        'label'       => 'Browser Favicon',
        'desc'        => 'Upload your favicon which should be 16 pixels width by 16 pixels height.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'apple_favicon',
        'label'       => 'Apple Touch Icon',
        'desc'        => 'Upload the default apple touch icon, the icon should be 57 pixels width by 57 pixels height.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'apple_favicon_72',
        'label'       => 'Apple Touch Icon 72x72',
        'desc'        => 'The icon should be 72 pixels width by 72 pixels height.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'apple_favicon_114',
        'label'       => 'Apple Touch Icon 114x114',
        'desc'        => 'The icon should be 114 pixels width by 114 pixels height.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'responsivness',
        'label'       => 'Responsive',
        'desc'        => 'Enable or disable the responsivness.',
        'std'         => 'enabled',
        'type'        => 'select',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enabled',
            'label'       => 'Enabled',
            'src'         => ''
          ),
          array(
            'value'       => 'disabled',
            'label'       => 'Disabled',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'logo',
        'label'       => 'Upload your Logo',
        'desc'        => 'Upload your own logo, or simply specify the URL directly. Delete or leave it empty to show text only.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'headercolor',
        'label'       => 'Header Background Color',
        'desc'        => 'Choose a color that you would like to use for the header.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'navigationcolor',
        'label'       => 'Navigation background color',
        'desc'        => 'Change the background color of the navigation menu.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'navigationhover',
        'label'       => 'Navigation background hover color',
        'desc'        => 'Change the color when hovering a menu link.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'navactive',
        'label'       => 'Navigation background active Color',
        'desc'        => 'Choose the background color when menu link is active.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'navigation_font',
        'label'       => 'First level navigation link font',
        'desc'        => 'Change the font settings of the menu.',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'second_navigation',
        'label'       => 'Second level navigation link font',
        'desc'        => 'Change the font settings of the dropdown menu.',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'boxed',
        'label'       => 'Boxed or Wide Layout',
        'desc'        => 'Choose if you want your layout to be boxed or wide full screen.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'wide',
            'label'       => 'Wide',
            'src'         => ''
          ),
          array(
            'value'       => 'boxy',
            'label'       => 'Boxed',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'color_scheme',
        'label'       => 'Color schemes',
        'desc'        => 'Select your themes alternative color scheme.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'light_scheme',
            'label'       => 'Light',
            'src'         => ''
          ),
          array(
            'value'       => 'dark_scheme',
            'label'       => 'Dark',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'bodycolor',
        'label'       => 'Body Background',
        'desc'        => 'Choose a color that you would like to use for the body of the page.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'body_font_color',
        'label'       => 'Body Font Color',
        'desc'        => 'Change the main body color for blog, single portfolio items etc.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'accent_color',
        'label'       => 'Main Accent Color',
        'desc'        => 'Change the color for borders, hovers, links etc.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'links_color',
        'label'       => 'Links Color',
        'desc'        => 'Change the color for all links.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'links_hover',
        'label'       => 'Links hover color',
        'desc'        => 'Change the color for the hover of all links.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'title_background',
        'label'       => 'Page Title Background',
        'desc'        => 'Change the background of the page title.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_color',
        'label'       => 'Footer Background',
        'desc'        => 'Choose a color for your footer.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'copyright_color',
        'label'       => 'Footer Copyright Background',
        'desc'        => 'Choose a color for the part below the widgetized footer, where is the copyright message and the social icons.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'styling',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'page_title',
        'label'       => 'Page Title',
        'desc'        => '',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'h1',
        'label'       => 'h1',
        'desc'        => '',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'h2',
        'label'       => 'h2',
        'desc'        => '',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'h3',
        'label'       => 'h3',
        'desc'        => '',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'h4',
        'label'       => 'h4',
        'desc'        => '',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'h5',
        'label'       => 'h5',
        'desc'        => '',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'typography',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blog_title',
        'label'       => 'Blog Page Title',
        'desc'        => 'Change the default blog page title.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'blogoptions',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blog_excerpt',
        'label'       => 'Blog Excerpt Length',
        'desc'        => 'Extended or shorten the excerpt on blog page. By default is set to 80.',
        'std'         => '80',
        'type'        => 'text',
        'section'     => 'blogoptions',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'blogsidebar',
        'label'       => 'Blog Sidebar Position',
        'desc'        => 'Choose whether you want to display the sidebar on the left or the right side on the blog page.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'blogoptions',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'right',
            'label'       => 'Right',
            'src'         => ''
          ),
          array(
            'value'       => 'left',
            'label'       => 'Left',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'portfolio_filter',
        'label'       => 'Portfolio filtering',
        'desc'        => 'Enable or disable the filtering for the portfolio items.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enabled',
            'label'       => 'Enabled',
            'src'         => ''
          ),
          array(
            'value'       => 'disabled',
            'label'       => 'Disabled',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'portfolio_items_number',
        'label'       => 'Number of Portfolio Items',
        'desc'        => 'Set up how many items should be displayed on portfolio page. By default is set to 9.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'related_works',
        'label'       => 'Enable related works',
        'desc'        => 'Display or not related portfolio works.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enable',
            'label'       => 'Enabled',
            'src'         => ''
          ),
          array(
            'value'       => 'disable',
            'label'       => 'Disabled',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'portfolio_hover',
        'label'       => 'Enable hover effect on portfolio items',
        'desc'        => 'Enable or disable the hover effect for portfolio images.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enabled',
            'label'       => 'Enabled',
            'src'         => ''
          ),
          array(
            'value'       => 'disabled',
            'label'       => 'Disabled',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'hover_color',
        'label'       => 'Change the color for the hover effect',
        'desc'        => 'Change the color for the hover effect on portfolio items.',
        'std'         => '',
        'type'        => 'colorpicker',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'lightbox_style',
        'label'       => 'Lighbox style',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'dark_rounded',
            'label'       => 'Dark Rounded',
            'src'         => ''
          ),
          array(
            'value'       => 'dark_square',
            'label'       => 'Dark Square',
            'src'         => ''
          ),
          array(
            'value'       => 'default',
            'label'       => 'Default',
            'src'         => ''
          ),
          array(
            'value'       => 'facebook_style',
            'label'       => 'Facebook',
            'src'         => ''
          ),
          array(
            'value'       => 'light_rounded',
            'label'       => 'Light Rounded',
            'src'         => ''
          ),
          array(
            'value'       => 'light_square',
            'label'       => 'Light Square',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'project_overview',
        'label'       => 'Project Overview Title',
        'desc'        => 'Change the default text in this area.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'project_challenge',
        'label'       => 'Project Challenge Title',
        'desc'        => 'Change the default text in this area.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'project_details',
        'label'       => 'Project Details Title',
        'desc'        => 'Change the default text in this area.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'portfolio',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'twitter',
        'label'       => 'Twitter',
        'desc'        => 'Add your Twitter url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'facebook',
        'label'       => 'Facebook',
        'desc'        => 'Add your Facebook profile url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tumblr',
        'label'       => 'Tumblr',
        'desc'        => 'Add your tumblr url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'linkedin',
        'label'       => 'Linkedin',
        'desc'        => 'Add your linkedin url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vimeo',
        'label'       => 'Vimeo',
        'desc'        => 'Add your vimeo url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'youtube',
        'label'       => 'Youtube',
        'desc'        => 'Add your youtube url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'flickr',
        'label'       => 'Flickr',
        'desc'        => 'Add your Flickr profile url.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'googleplus',
        'label'       => 'Google plus',
        'desc'        => 'Add your Google Plus profile url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'pinterest',
        'label'       => 'Pinterest',
        'desc'        => 'Add your pinterest url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'dribbble',
        'label'       => 'Dribbble',
        'desc'        => 'Add your dribbble url',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'rssfeed',
        'label'       => 'RSS',
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enable',
            'label'       => 'Enabled',
            'src'         => ''
          ),
          array(
            'value'       => 'disable',
            'label'       => 'Disabled',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'footer_columns',
        'label'       => 'Footer Column Display',
        'desc'        => 'Choose how many columns and in what order widgets to be displayed',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'onetwo',
            'label'       => '1:2',
            'src'         => ''
          ),
          array(
            'value'       => 'onethree',
            'label'       => '1:3',
            'src'         => ''
          ),
          array(
            'value'       => 'onefour',
            'label'       => '1:4',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'copyright_text',
        'label'       => 'Copyright Text',
        'desc'        => 'Enter your copyright message here',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_social_icons',
        'label'       => 'Footer Social Icons',
        'desc'        => 'Display footer social icons',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'footer',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'enabled',
            'label'       => 'Enable',
            'src'         => ''
          ),
          array(
            'value'       => 'disabled',
            'label'       => 'Disable',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'site_keywords',
        'label'       => 'Site Keywords',
        'desc'        => 'Write the list of keywords for you resume site page, separated by commas.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'seo',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'site_description',
        'label'       => 'Site Description',
        'desc'        => 'Write a description for your site.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'seo',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'google_analytics',
        'label'       => 'Google Analytics',
        'desc'        => 'Insert your google analytics tracking code',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'seo',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'error_text',
        'label'       => '404 Error Text',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => '404page',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'error_image',
        'label'       => '404 Main Image',
        'desc'        => 'Change the 404 error image.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => '404page',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}