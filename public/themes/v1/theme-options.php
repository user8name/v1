<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'v1_options', 'v1_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'v1theme' ), __( 'Theme Options', 'v1theme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create arrays for our select and radio options
 */
$select_options = array(
	'0' => array(
		'value' =>	'0',
		'label' => __( 'Zero', 'v1theme' )
	),
	'1' => array(
		'value' =>	'1',
		'label' => __( 'One', 'v1theme' )
	),
	'2' => array(
		'value' => '2',
		'label' => __( 'Two', 'v1theme' )
	),
	'3' => array(
		'value' => '3',
		'label' => __( 'Three', 'v1theme' )
	),
	'4' => array(
		'value' => '4',
		'label' => __( 'Four', 'v1theme' )
	),
	'5' => array(
		'value' => '3',
		'label' => __( 'Five', 'v1theme' )
	)
);

$radio_options = array(
	'yes' => array(
		'value' => 'yes',
		'label' => __( 'Yes', 'v1theme' )
	),
	'no' => array(
		'value' => 'no',
		'label' => __( 'No', 'v1theme' )
	),
	'maybe' => array(
		'value' => 'maybe',
		'label' => __( 'Maybe', 'v1theme' )
	)
);

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	<div class="wrap">
		<?php  echo "<h2>" . wp_get_theme() . __( ' Theme Options', 'v1theme' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'v1theme' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'v1_options' ); ?>
			<?php $options = get_option( 'v1_theme_options' ); ?>

			<table class="form-table">


				<?php
				/**
				 * copyright
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Copyright', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[copyright]" class="regular-text" type="text" name="v1_theme_options[copyright]" value="<?php esc_attr_e( $options['copyright'] ); ?>" />
						<label class="description" for="v1_theme_options[copyright]"><?php _e( 'Copyright: copyright', 'v1theme' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * USA Tel 1
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'USA Tel 1', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[usatel1]" class="regular-text" type="text" name="v1_theme_options[usatel1]" value="<?php esc_attr_e( $options['usatel1'] ); ?>" />
						<label class="description" for="v1_theme_options[usatel1]"><?php _e( 'USA Tel 1: usatel1', 'v1theme' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * Europe Tel 1
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Europe Tel 1', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[europetel1]" class="regular-text" type="text" name="v1_theme_options[europetel1]" value="<?php esc_attr_e( $options['europetel1'] ); ?>" />
						<label class="description" for="v1_theme_options[europetel1]"><?php _e( 'Europe Tel 1: europetel1', 'v1theme' ); ?></label>
					</td>
				</tr>


				<?php
				/**
				 * Europe Tel 1
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Fax 1', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[fax1]" class="regular-text" type="text" name="v1_theme_options[fax1]" value="<?php esc_attr_e( $options['fax1'] ); ?>" />
						<label class="description" for="v1_theme_options[fax1]"><?php _e( 'Fax 1: fax1', 'v1theme' ); ?></label>
					</td>
				</tr>


					<?php
				/**
				 * Address
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Address', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[address]" class="regular-text" type="text" name="v1_theme_options[address]" value="<?php esc_attr_e( $options['address'] ); ?>" />
						<label class="description" for="v1_theme_options[address]"><?php _e( 'Address: address', 'v1theme' ); ?></label>
					</td>
				</tr>
				<?php
				/**
				 * facebook
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Facebook', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[facebook]" class="regular-text" type="text" name="v1_theme_options[facebook]" value="<?php esc_attr_e( $options['facebook'] ); ?>" />
						<label class="description" for="v1_theme_options[facebook]"><?php _e( 'Facebook: facebook', 'v1theme' ); ?></label>
					</td>
				</tr>
				<?php
				/**
				 * twitter
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Twitter', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[twitter]" class="regular-text" type="text" name="v1_theme_options[twitter]" value="<?php esc_attr_e( $options['twitter'] ); ?>" />
						<label class="description" for="v1_theme_options[twitter]"><?php _e( 'Twitter: twitter', 'v1theme' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * linkedin
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Linkedin', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[linkedin]" class="regular-text" type="text" name="v1_theme_options[linkedin]" value="<?php esc_attr_e( $options['linkedin'] ); ?>" />
						<label class="description" for="v1_theme_options[linkedin]"><?php _e( 'Linkedin: linkedin', 'v1theme' ); ?></label>
					</td>
				</tr>

				<?php
				/**
				 * GOOGLE plus
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Google plus', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[googleplus]" class="regular-text" type="text" name="v1_theme_options[googleplus]" value="<?php esc_attr_e( $options['googleplus'] ); ?>" />
						<label class="description" for="v1_theme_options[googleplus]"><?php _e( 'Google plus: googleplus', 'v1theme' ); ?></label>
					</td>
				</tr>

				
				<?php
				/**
				 * verification code
				 */
				?>
				<tr valign="top"><th scope="row"><?php _e( 'Verification code', 'v1theme' ); ?></th>
					<td>
						<input id="v1_theme_options[code]" class="regular-text" type="text" name="v1_theme_options[code]" value="<?php esc_attr_e( $options['code'] ); ?>" />
						<label class="description" for="v1_theme_options[code]"><?php _e( 'Verification code: code', 'v1theme' ); ?></label>
					</td>
				</tr>


			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'v1theme' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $select_options, $radio_options;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/