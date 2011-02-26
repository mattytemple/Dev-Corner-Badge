<?php
/*
Plugin Name: Dev Corner Badge
Plugin URI: http://www.mattytemple.com/
Description: Places a highly visible marker in the upper corner of every post/page to denote a development site.
Author: Matt Temple
Author URI: http://www.mattytemple.com
Version: 1.1
*/

/*
Copyright 2010 Philip Cain (email:philipacamaniac[at]gmail dot com)
This program is free softwate; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
Public License for more detail

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software Fondation, Inc.,
51 Franklin St, Fifth Floor, Boston, MA 02110-1301 US
*/

function dev_corner_badge() {
	$devbadge_position = get_option( 'devbadge_position' );
	$devbadge_behavior = get_option( 'devbadge_behavior' );
	$devbadge_text = get_option( 'devbadge_text' );
	$devbadge_link = get_option( 'devbadge_link' );
	$devbadge_css =  WP_PLUGIN_URL . '/dev-corner-badge/styles/';
	echo '<link rel="stylesheet" type="text/css" href="' . $devbadge_css . 'style.css" />';
	if ($devbadge_position == 'right') {
		if ($devbadge_text) {
			echo '<link rel="stylesheet" type="text/css" href="' . $devbadge_css . 'right-blank.css" />';		
			} else {
				echo '<link rel="stylesheet" type="text/css" href="' . $devbadge_css . 'right.css" />';
			}
		} else {
		if ($devbadge_text) {
			echo '<link rel="stylesheet" type="text/css" href="' . $devbadge_css . 'left-blank.css" />';		
			} else {
				echo '<link rel="stylesheet" type="text/css" href="' . $devbadge_css . 'left.css" />';
			}
		}
	if ($devbadge_behavior == 'fixed') echo '<link rel="stylesheet" type="text/css" href="' . $devbadge_css . 'fixed.css" />';
	if ($devbadge_link) echo '<a class="dev-corner-badge-link" href="' . $devbadge_link . '">';
	echo '<div id="dev-corner-badge">';
	if ($devbadge_text) echo '<span>' . $devbadge_text . '</span>';
	echo '</div>';	
	if ($devbadge_link) echo '</a>';
	}
	

function dev_corner_badge_menu() {
	add_options_page('Dev Corner Badge Options', 'Dev Corner Badge', 'manage_options', 'dev-corner-badge', 'dev_corner_badge_options');
	}

function dev_corner_badge_options() {
	if (!current_user_can('manage_options')) wp_die( __('You do not have sufficient permissions to access this page.') );

    $devbadge_position = get_option( 'devbadge_position' );
    $devbadge_behavior = get_option( 'devbadge_behavior' );
    $devbadge_text = get_option( 'devbadge_text' );
    $devbadge_link = get_option( 'devbadge_link' );

    if($_POST[ 'devbadge_submit' ] == 'Y') {
   		$devbadge_position = $_POST[ 'devbadge_position' ];
    	$devbadge_behavior = $_POST[ 'devbadge_behavior' ];
    	$devbadge_link = $_POST[ 'devbadge_link' ];    	
    	$devbadge_text = $_POST[ 'devbadge_text' ];    	
        update_option( 'devbadge_position', $devbadge_position );
        update_option( 'devbadge_behavior', $devbadge_behavior );
        update_option( 'devbadge_text', $devbadge_text ); 
        update_option( 'devbadge_link', $devbadge_link ); 
?>
		<div class="updated"><p><strong><?php _e('settings saved.', 'dev-corner-badge' ); ?></strong></p></div>
<?php }

    echo '<div class="wrap">';
    echo "<h2>" . __( 'Dev Corner Badge Settings', 'dev-corner-badge' ) . "</h2>";
    echo "<div><em><a href=\"http://en.wikipedia.org/wiki/KISS_principle\" target=\"_blank\">\"Keep it simple, Stupid!\"</a></em></div>"

    ?>
	<form name="devbadge_settings_form" method="post" action="">
		<input type="hidden" name="<?php echo 'devbadge_submit'; ?>" value="Y">
		<p><?php _e("Position:", 'dev-corner-badge' ); ?> 
			<select type="text" name="<?php echo 'devbadge_position'; ?>">
				<option <?php if ($devbadge_position == 'left') echo 'selected'; ?> value="left">Left Corner</option>
				<option <?php if ($devbadge_position == 'right') echo 'selected'; ?> value="right">Right Corner</option>
			</select>	
		</p>
		<p><?php _e("Behavior:", 'dev-corner-badge' ); ?> 
			<select type="text" name="<?php echo 'devbadge_behavior'; ?>">
				<option <?php if ($devbadge_behavior == 'absolute') echo 'selected'; ?> value="absolute">Absolute (stick to the top of the page)</option>
				<option <?php if ($devbadge_behavior == 'fixed') echo 'selected'; ?> value="fixed">Fixed (stick to the top of the browser window)</option>
			</select>
		</p>
		<p><?php _e("Optional Link URL:", 'dev-corner-badge' ); ?> 
			<input type="text" name="<?php echo 'devbadge_link'; ?>" value="<?php echo $devbadge_link; ?>" size="100">
		</p>
		<p><?php _e("Optional Custom Text (15 char max):", 'dev-corner-badge' ); ?> 
			<input type="text" name="<?php echo 'devbadge_text'; ?>" value="<?php echo $devbadge_text; ?>" size="15" maxlength="15">
		</p>		
		<hr />
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
		</p>
	</form>
</div>
<?php }	

add_action('wp_head', 'dev_corner_badge');
add_action('admin_menu', 'dev_corner_badge_menu');

?>