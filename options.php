<?php
function no_cc_attack_register_settings() {
	add_option('no_cc_attack_redirect_url', 'http://www.google.com/');
	add_option('no_cc_attack_second', 3);
	add_option('no_cc_attack_time', 5);
	register_setting('no_cc_attack_options', 'no_cc_attack_redirect_url');
	register_setting('no_cc_attack_options', 'no_cc_attack_second');
	register_setting('no_cc_attack_options', 'no_cc_attack_time');
}
add_action('admin_init', 'no_cc_attack_register_settings');

function no_cc_attack_register_options_page() {
	add_options_page(__('No CC Attack Options Page', NO_CC_ATTACK_TEXT_DOMAIN), __('No CC Attack', NO_CC_ATTACK_TEXT_DOMAIN), 'manage_options', NO_CC_ATTACK_TEXT_DOMAIN.'-options', 'no_cc_attack_options_page');
}
add_action('admin_menu', 'no_cc_attack_register_options_page');

function no_cc_attack_options_page() {
?>
<div class="wrap">
	<h2><?php _e("No CC Attack Options Page", NO_CC_ATTACK_TEXT_DOMAIN); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields('no_cc_attack_options'); ?>
		<h3><?php _e("General Options", NO_CC_ATTACK_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="no_cc_attack_redirect_url"><?php _e("Where will the one who CC be redirect?", NO_CC_ATTACK_TEXT_DOMAIN); ?></label></th>
					<td>
						<input type="url" name="no_cc_attack_redirect_url" id="no_cc_attack_redirect_url" value="<?php echo get_option('no_cc_attack_redirect_url'); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="no_cc_attack_second"><?php _e("How many seconds between refreshs mean attack?", NO_CC_ATTACK_TEXT_DOMAIN); ?></label></th>
					<td>
						<input type="number" name="no_cc_attack_second" id="no_cc_attack_second" value="<?php echo get_option('no_cc_attack_second'); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="no_cc_attack_time"><?php _e("How many times of attack will redirect?", NO_CC_ATTACK_TEXT_DOMAIN); ?></label></th>
					<td>
						<input type="number" name="no_cc_attack_time" id="no_cc_attack_time" value="<?php echo get_option('no_cc_attack_time'); ?>" />
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>