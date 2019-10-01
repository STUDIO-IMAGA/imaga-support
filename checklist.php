<?php
/*
 * Op maat maken naar onze checklist.
 *
 * Let op: plugins, Taal, PHP Versie, WordPress versie, eventuele custom eisen wat binnen WordPress valt te checken qua API calls enzo.
 * Check als Yoast goed ingesteld staat (geen defaults)
 */
function zee_checklist(){
?>
<style>
.zeedesign-status-table{
	margin-bottom: 20px;
}
.zeedesign-status-table th{
	width: 60%;
}
.zeedesign-status-table td {
	width: 40%;
}
</style>

<div class="wrap">
	<h2><?php echo get_admin_page_title(); ?></h2>

	<?php

	$language      			= get_locale();
	$is_dutch      			= 'nl_NL' === $language;
	$timezone      			= get_option( 'timezone_string' );
	$blog_public   			= get_option( 'blog_public' );
	$category_base 			= get_option( 'category_base' );
	$permalink_structure 	= get_option('permalink_structure');

	?>
	<table class="zeedesign-status-table widefat striped" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2"><?php _e( 'WordPres', 'zeedesign_check' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<th scope="row">
					<?php _e( 'Language', 'zeedesign_check' ); ?>
				</th>
				<td>
					<span class="dashicons dashicons-yes"></span> <?php echo $language; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Is Dutch', 'zeedesign_check' ); ?>
				</th>
				<td>
					<?php if ( $is_dutch ) : ?>

						<span class="dashicons dashicons-yes"></span>

					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Timezone (Amsterdam)', 'zeedesign_check' ); ?>
				</th>
				<td>
					<?php if ( $is_dutch && 'Europe/Amsterdam' === $timezone ) : ?>

						<span class="dashicons dashicons-yes"></span>

					<?php endif; ?>

					<?php echo $timezone; ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Site Visibility', 'zeedesign_check' ); ?>
				</th>
				<td>
					<?php if ( $blog_public ) : ?>

						<span class="dashicons dashicons-yes"></span>

					<?php endif; ?>

					<?php $blog_public ? esc_html_e( 'Public', 'zeedesign_check' ) : esc_html_e( 'Private', 'zeedesign_check' ); ?>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Permalinks ( /%postname%/ )', 'zeedesign_check' ); ?>
				</th>
				<td>
					<?php if ( $permalink_structure === "/%postname%/" ) : ?>

						<span class="dashicons dashicons-yes"></span>

					<?php endif; ?>

				</td>
			</tr>
			<?php /*
			<tr>
				<th scope="row">
					<?php _e( 'Category Base', 'zeedesign_check' ); ?>
				</th>
				<td>
					<?php if ( $is_dutch && 'categorie' === $category_base ) : ?>

						<span class="dashicons dashicons-yes"></span>

					<?php endif; ?>

					<?php echo $category_base; ?>
				</td>
			</tr>
			*/ ?>
		</tbody>
	</table>

	<table class="zeedesign-status-table widefat striped" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2"><?php _e( 'Config', 'zeedesign_check' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php

			$constants = array(
				'WP_DEBUG',
				'SCRIPT_DEBUG',
				'SAVEQUERIES',
			);

			foreach ( $constants as $constant ) : ?>

				<tr>
					<th scope="row">
						<code><?php echo esc_html( $constant ); ?></code>
					</th>
					<td>
						<?php if ( ! defined( $constant ) || false === constant( $constant ) ) : ?>

							<span class="dashicons dashicons-yes"></span>

						<?php endif; ?>

						<code><?php echo esc_html( defined( $constant ) ? constant( $constant ) : '' ); ?></code>
					</td>
				</tr>

			<?php endforeach; ?>

		</tbody>
	</table>

	<table class="zeedesign-status-table widefat striped" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2"><?php _e( 'Theme', 'zeedesign_check' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<?php

				$childTheme = is_child_theme();

				?>
				<th scope="row">
					Is template childtheme
				</th>
				<td>
					<span class="dashicons dashicons-<?php echo esc_attr( $childTheme ? 'yes' : 'no' ); ?>"></span>

					<?php $childTheme ? esc_html_e( 'Yes', 'zeedesign_check' ) : esc_html_e( 'No', 'zeedesign_check' ); ?>
				</td>
			</tr>
			<tr>
				<?php

				$header_file          = get_template_directory() . '/header.php';

				/*
				// check of het besand in child of parent zit
				// nog afmaken
				$getHeader = file_exists( get_template_directory().'header.php' );

				if ($childTheme == 'Yes') {
					$getHeader = file_exists( get_stylesheet_directory().'header.php' );
					$themeCheck = '<em>(In Child Theme)</em>';
				} else {
					$themeCheck = '<em>(In Parent Theme)</em>';
				}
				*/


				$header_file_content  = file_get_contents( $header_file );
				$has_wp_head_function = strpos( $header_file_content, 'wp_head();' );

				?>
				<th scope="row">
					<?php printf( __( 'Function %s in %s', 'zeedesign_check' ), '<code>wp_head();</code>', '<code>header.php</code>' ); ?>
				</th>
				<td>
					<span class="dashicons dashicons-<?php echo esc_attr( $has_wp_head_function ? 'yes' : 'no' ); ?>"></span>

					<?php $has_wp_head_function ? esc_html_e( 'Yes', 'zeedesign_check' ) : esc_html_e( 'No', 'zeedesign_check' ); ?>
					<?php //echo $themeCheck; ?>
				</td>
			</tr>
			<tr>
				<?php

				$footer_file            = get_template_directory() . '/footer.php';
				$footer_file_content    = file_get_contents( $footer_file );
				$has_wp_footer_function = strpos( $footer_file_content, 'wp_footer();' );

				?>
				<th scope="row">
					<?php printf( __( 'Function %s in %s', 'zeedesign_check' ), '<code>wp_footer();</code>', '<code>footer.php</code>' ); ?>
				</th>
				<td>
					<span class="dashicons dashicons-<?php echo esc_attr( $has_wp_footer_function ? 'yes' : 'no' ); ?>"></span>

					<?php $has_wp_footer_function ? esc_html_e( 'Yes', 'zeedesign_check' ) : esc_html_e( 'No', 'zeedesign_check' ); ?>
				</td>
			</tr>

		</tbody>
	</table>

	<table class="zeedesign-status-table widefat striped" cellspacing="0">
		<thead>
			<tr>
				<th colspan="2"><?php _e( 'Users', 'zeedesign_check' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<?php

				$user_zeedesign      = get_user_by( 'login', 'zee_admin' );
				$has_user_zeedesign  = false !== $user_zeedesign;

				?>
				<th scope="row">
					<?php _e( 'WordPress user \'zee_admin\'', 'zeedesign_check' ); ?>
				</th>
				<td>
					<?php if ( $has_user_zeedesign ) : ?>

						<span class="dashicons dashicons-yes"></span>

					<?php endif; ?>

					<?php $has_user_zeedesign ? esc_html_e( 'Yes', 'zeedesign_check' ) : esc_html_e( 'No', 'zeedesign_check' ); ?>
				</td>
			</tr>

			<?php if ( false !== $user_zeedesign ) : ?>

				<tr>
					<?php

					//$has_email_zeedesign = 'info@zeedesign.nl' === $user_zeedesign->user_email;
					$has_email_zeedesign = strpos($user_zeedesign->user_email, '@zeedesign.nl') !== false;

					?>
					<th scope="row">
						<?php _e( 'WordPress user \'zee_admin\' email heeft \'@zeedesign.nl\' adres', 'zeedesign_check' ); ?>
					</th>
					<td>
						<?php if ( $has_email_zeedesign ) : ?>

							<span class="dashicons dashicons-yes"></span>

						<?php endif; ?>

						<?php echo esc_html( $user_zeedesign->user_email ); ?>
					</td>
				</tr>

			<?php endif; ?>

		</tbody>
	</table>


	<?php

	$plugins = array(
		'advanced-custom-fields-pro/acf.php' => array(
			'slug' => '',
			'name' => 'Advanced Custom Fields Pro',
		),
		'contact-form-7/wp-contact-form-7.php' => array(
			'slug' => 'contact-form-7',
			'name' => 'Contact Form 7',
		),
		'contact-form-7-to-database-extension/CF7DBPlugin.php' => array(
			'slug' => 'contact form db',
			'name' => 'Contact Form DB',
		),
		'gravityforms/gravityforms.php' => array(
			'slug' => '',
			'name' => 'Gravity Forms',
		),
		'gravityforms-nl/gravityforms-nl.php' => array(
			'slug' => 'gravityforms-nl',
			'name' => 'Gravity Forms (nl)',
		),
		'wordfence/wordfence.php' => array(
			'slug' => 'wordfence',
			// 'slug' => '',
			'name' => 'Wordfence Security',
		),
		'nextgen-gallery/nggallery.php' => array(
			'slug' => 'nextgen gallery',
			'name' => 'Nextgen Gallery',
		),
		'mce-table-buttons/mce_table_buttons.php' => array(
			'slug' => 'mce table buttons',
			'name' => 'MCE Table Buttons',
		),
		'shortcodes-ultimate/shortcodes-ultimate.php' => array(
			'slug' => 'shortcodes ultimate',
			'name' => 'Shortcodes Ultimate',
		),
		'recent-posts-widget-extended/rpwe.php' => array(
			'slug' => 'recent posts widget extended',
			'name' => 'Recent Posts Widget Extended',
		),
		'simple-301-redirects/wp-simple-301-redirects.php' => array(
			'slug' => 'simple 301 redirects',
			'name' => 'Simple 301 Redirects',
		),
		'custom-facebook-feed-pro/custom-facebook-feed.php' => array(
			'slug' => '',
			'name' => 'Custom Facebook Feed Pro',
		),
		'mailchimp-for-wp/mailchimp-for-wp.php' => array(
			'slug' => 'MailChimp ibericode ',
			'name' => 'MailChimp voor WordPress',
		),
		'worker/init.php' => array(
			'slug' => 'managewp',
			'name' => 'ManageWP - Worker',
		),
		'google-analytics-for-wordpress/googleanalytics.php' => array(
			'slug' => 'google-analytics-for-wordpress',
			'name' => 'Google Analytics for WordPress',
		),
		'wordpress-seo/wp-seo.php' => array(
			'slug' => 'wordpress-seo',
			'name' => 'WordPress SEO by Yoast',
		),
		'wp-statistics/wp-statistics.php' => array(
			'slug' => 'wp-statistics',
			'name' => 'WP Statistics',
		),
	);

	?>

	<table class="zeedesign-status-table widefat striped" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3"><?php _e( 'Plugins (veel gebruikte)', 'zeedesign_check' ); ?></td>
			</tr>
		</thead>

		<tbody>

			<?php foreach ( $plugins as $file => $data ) : ?>

				<tr>
					<th scope="row">
						<?php echo $data['name']; ?>
					</th>
					<td>
						<?php if ( is_plugin_active( $file ) ) : ?>

							<span class="dashicons dashicons-yes"></span>

						<?php else : ?>

							<?php
							if (!empty($data['slug'])) {
								$searchUrl = add_query_arg(
									array(
										'tab'  => 'search',
										'type' => 'term',
										's'    => $data['slug'],
									),
									'plugin-install.php'
								);
							} else {
								$searchUrl = add_query_arg(
									array(
										'tab'  => 'upload',
									),
									'plugin-install.php'
								);
							}

							?>
							<a href="<?php echo $searchUrl; ?>">
								<?php _e( 'Search Plugin', 'zeedesign_check' ); ?>
							</a>

						<?php endif; ?>

					</td>
				</tr>

			<?php endforeach; ?>

		</tbody>
	</table>
</div>
<?php } ?>
