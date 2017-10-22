(function() {	
	tinymce.create('tinymce.plugins.sympleShortcodeMce', {
		init : function(ed, url){
			tinymce.plugins.sympleShortcodeMce.theurl = url;
		},
		createControl : function(btn, e) {
			if ( btn == "symple_shortcodes_button" ) {
				var a = this;	
				var btn = e.createSplitButton('symple_button', {
	                title: "Insert Shortcode",
					image: tinymce.plugins.sympleShortcodeMce.theurl +"/images/shortcodes.png",
					icons: false,
	            });
	            btn.onRenderMenu.add(function (c, b) {

	            	b.add({title : 'Jungle Shortcodes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

					c = b.addMenu({title: "Columns"});

					a.render( c, "1/2 Column", "one_half");
					a.render( c, "1/3 Column", "one_third" );
					a.render( c, "1/4 Column", "one_fourth" );
					a.render( c, "2/3 Column", "two_third" );
					a.render( c, "3/4 Column", "three_fourth" );
					a.render( c, "3/5 Column", "three_fifth" );
					a.render( b, "Alert", "alert" );
					d = b.addMenu({
						title: "Content"
					});
					a.render( d, "Box", "box" );
					a.render( d, "Boxes", "boxes" );
					a.render( d, "Clear Floats", "clear" );
					a.render( b, "Latest Posts", "latest_blog" );
					a.render( d, "Button", "button" );
					a.render( d, "Divider", "divider" );
					a.render( b, "Google Map", "googlemap" );
					// a.render( b, "Heading", "heading" );
					a.render( d, "Highlight", "highlight" );
					a.render( b, "Pricing Table", "symple_pricing_table" );
					a.render( b, "Skills", "skills" );
					a.render( d, "Spacing", "spacing" );
					a.render( b, "Social Icon", "social" );
					a.render( b, "Title", "title" );
					a.render( b, "Toggle", "toggle" );
					f = b.addMenu({
						title: "Tabs"
					});
					a.render( f, "Tabs Horizontal", "tabs" );
					a.render( f, "Tabs Vertical", "vertical_tabs" );
					// a.render( b, "Testimonial box", 'testimonial_box');
					a.render( b, "Testimonial", "testimonial" );
					a.render( b, "Team Member", "team_member" );
					a.render( b, "Notification", "notification" );
					a.render( b, "Works", "works" );
				});
	            
	          return btn;
			}
			return null;               
		},
		render : function(ed, title, id) {
			ed.add({
				title: title,
				onclick: function () {
					
					// Selected content
					var mceSelected = tinyMCE.activeEditor.selection.getContent();
					
					// Add highlighted content inside the shortcode when possible - yay!
					if ( mceSelected ) {
						var sympleDummyContent = mceSelected;
					} else {
						var sympleDummyContent = 'Sample Content';
					}
					
					// Accordion
					// if(id == "accordion") {
					// 	tinyMCE.activeEditor.selection.setContent('[symple_accordion]<br />[symple_accordion_section title="Section 1"]<br />Accordion Content<br />[/symple_accordion_section]<br />[symple_accordion_section title="Section 2"]<br />Accordion Content<br />[/symple_accordion_section]<br />[/symple_accordion]');
					// }
					// Alert
					if(id == "alert") {
						tinyMCE.activeEditor.selection.setContent('[alert type="error-notice-info-success"]Your Content displayed in the alert box[/alert]');
					}
					// Box
					if(id == "box") {
						tinyMCE.activeEditor.selection.setContent('[box]Your Content displayed in a row or box[/box]');
					}

					// Boxes
					if(id == "boxes") {
						tinyMCE.activeEditor.selection.setContent('[box]<br />[boxes title="Creative Design" image="wp-content/themes/jungle/images/icons/services/design.png"]Lorimaem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.[/boxes]<br />[boxes title="LayerSlider Included" image="wp-content/themes/jungle/images/icons/services/support.png"]Extremely useful shortcode plugin, no more mess after you change template, the shortcodes stay with you all the time.[/boxes]<br />[boxes last="yes" title="Advanced Options"  image="wp-content/themes/jungle/images/icons/services/web.png"]An advanced custom panel that will make your editing easier like never before, check and enjoy![/boxes]<br />[boxes title="Jungle WordPress"  image="wp-content/themes/jungle/images/icons/services/photography.png"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.![/boxes]<br />[boxes title="Marketing" image="wp-content/themes/jungle/images/icons/services/business.png"]Lorimaem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.[/boxes]<br />[boxes last="yes" title="Responsive & Flexible" image="wp-content/themes/jungle/images/icons/services/mobile.png"]Lorimaem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.[/boxes]<br />[/box]');
					}
					
					// Button
					if(id == "button") {
						tinyMCE.activeEditor.selection.setContent('[button color="green" url="http://www.themeseagle.com" title="Visit Site" icon="icon-call | icon-launch | icon-buy | icon-download" arrow="yes" target="blank" border_radius=""]Button Text[/button]');
					}
					
					// Clear Floats
					if(id == "clear") {
						tinyMCE.activeEditor.selection.setContent('[clear]');
					}
					
					// One Third Column
					if(id == "one_third") {
						tinyMCE.activeEditor.selection.setContent('[one_third position="last"]<br />Your Content Goes Here<br />[/one_third]');
					}

					// One fourth Column
					if(id == "one_fourth") {
						tinyMCE.activeEditor.selection.setContent('[one_fourth position="last"]<br />Your Content Goes Here<br />[/one_fourth]');
					}

					// One Half Column
					if(id == "one_half") {
						tinyMCE.activeEditor.selection.setContent('[one_half position="last"]<br />Your Content Goes Here<br />[/one_half]');
					}

					// Two Third Column
					if(id == "two_third") {
						tinyMCE.activeEditor.selection.setContent('[two_third position="last"]<br />Your Content Goes Here<br />[/two_third]');
					}
					
					// Three Fourth Column
					if(id == "three_fourth") {
						tinyMCE.activeEditor.selection.setContent('[three_fourth position="last"]<br />Your Content Goes Here<br />[/three_fourth]');
					}
					// Three Fifth Column
					if(id == "three_fifth") {
						tinyMCE.activeEditor.selection.setContent('[three_fifth position="last"]<br />Your Content Goes Here<br />[/three_fifth]');
					}

					// Divider
					if(id == "divider") {
						tinyMCE.activeEditor.selection.setContent('[divider style="solid" margin_top="20px" margin_bottom="20px"]');
					}
					
					// Latest Posts
					if(id == "latest_blog") {
						tinyMCE.activeEditor.selection.setContent('[latest_blog secondlast="no" fromcategory="uncategorized" numberofposts="3" title="yes" image="yes" excerpt="yes" date="yes" comments="yes" column="one-third"][/latest_blog]');
					}

					// Title
					if(id == "title") {
						tinyMCE.activeEditor.selection.setContent('[title]Your Title[/title]');
					}

					// Google Map
					if(id == "googlemap") {
						tinyMCE.activeEditor.selection.setContent('[googlemap title="Envato Office" location="2 Elizabeth St, Melbourne Victoria 3000 Australia" zoom="10" height=250]');
					}
					
					// Heading
					// if(id == "heading") {
					// 	tinyMCE.activeEditor.selection.setContent('[symple_heading type="h2" title="This is my title" margin_top="20px;" margin_bottom="20px" text_align="left"]');
					// }
					
					// Highlight
					if(id == "highlight") {
						tinyMCE.activeEditor.selection.setContent('[highlight color="yellow"]highlighted text[/highlight]');
					}

					// Notifications
					if(id == "notification") {
						tinyMCE.activeEditor.selection.setContent('[notification color="#fcfcfc" text_align="left" shadow="no"][notification_content]<br />Notification Content<br />[/notification_content][/notification]');
					}

					// Pricing
					if(id == "symple_pricing_table") {
						tinyMCE.activeEditor.selection.setContent('[symple_pricing_table]<br />[symple_pricing size="one-half" plan="Basic" cost="$19" decimal=".99" per="per month" featured="" button_url="#" button_color="#8CBD2F" button_text="Sign Up" button_border_radius="" button_target="self" button_rel="nofollow" position=""]<br /><ul><li>30GB Storage</li><li>512MB Ram</li><li>10 databases</li><li>1,000 Emails</li><li>25GB Bandwidth</li></ul>[/symple_pricing]<br />[/symple_pricing_table]');
					}

					//Skills
					if(id == "skills") {
						tinyMCE.activeEditor.selection.setContent('[skills name="Project Management" percent="80"]');
					}

					//Spacing
					if(id == "spacing") {
						tinyMCE.activeEditor.selection.setContent('[spacing size="20px"]');
					}
					
					//Social
					if(id == "social") {
						tinyMCE.activeEditor.selection.setContent('[social icon="twitter" url="http://www.twitter.com" title="Follow Us" target="self" rel=""]');
					}
					
					//Tabs
					if(id == "tabs") {
						tinyMCE.activeEditor.selection.setContent('[tabgroup]<br />[tab title="First Tab"]<br />First tab content<br />[/tab]<br />[tab title="Second Tab"]<br />Second Tab Content.<br />[/tab]<br />[tab title="Third Tab"]<br />Third tab content<br />[/tab]<br />[/tabgroup]');
					}
					
					// Vetical Tabs
					if(id == "vertical_tabs") {
						tinyMCE.activeEditor.selection.setContent('[vertical_tabs]<br />[tab title="First Tab"]<br />First tab content<br />[/tab]<br />[tab title="Second Tab"]<br />Third Tab Content.<br />[/tab]<br />[tab title="Third Tab"]<br />Third tab content<br />[/tab]<br />[/vertical_tabs]');
					}

					//Testimonial
					if(id == "testimonial") {
						tinyMCE.activeEditor.selection.setContent('[testimonial_box effect="fade-flip-slide"][testimonial by="Client Name" photo="wp-content/themes/jungle/images/demo/testimonial-thumb-small.jpg" description="Client description" link="http://www.clientslinkiftheresany.com"]Add your clients testimonial here,consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua[/testimonial][/testimonial_box]');
					}

					//Team Member
					if(id == "team_member") {
						tinyMCE.activeEditor.selection.setContent('[carousel type="fade-flip-slide"][team_member image="Team Member Photo" name="Team Member Name" position="Member Position" tooltips="yes" facebook="http://www.your-facebook-url.com" twitter="http://www.your-twitter-url.com" linkedin="http://www.your-linkedin-url.com" vimeo="http://www.your-vimeo-url.com" dribbble="http://www.your-dribbble-url.com"]Add your team member info here,consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua[/team_member][/carousel]');
					}

					//Toggle
					if(id == "toggle") {
						tinyMCE.activeEditor.selection.setContent('[toggle title="This Is Your Toggle Title"]Your Toggle Content[/toggle]');
					}

					//Works
					if(id == "works") {
						tinyMCE.activeEditor.selection.setContent('[works numberofworks="3" categories="yes" title="yes"][/works]');
					}
					
					
					return false;
				}
			})
		}
	
	});
	tinymce.PluginManager.add("symple_shortcodes", tinymce.plugins.sympleShortcodeMce);
})();  