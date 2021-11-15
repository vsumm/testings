<?php

/**
 * Blog course module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if (!defined('ABSPATH')) {
	exit;
}

$settings = $this->get_settings();

if (class_exists('LP_Shortcode_Become_A_Teacher')) {

	if (Elementor\Plugin::$instance->editor->is_edit_mode()) {

	?>
		<div id="learn-press-become-teacher-form" class="become-teacher-form learn-press-form">

			<form name="become-teacher-form" method="post" enctype="multipart/form-data" action="">

				<?php do_action('learn-press/before-become-teacher-form'); ?>

				<?php do_action('learn-press/become-teacher-form'); ?>

				<?php do_action('learn-press/after-become-teacher-form'); ?>

			</form>

		</div>
	<?php

	} else {
		
		ob_start();

		$message = '';
		$code    = 0;

		$user = learn_press_get_current_user(false);
		if (!$user || $user instanceof LP_User_Guest) {
			LP_Shortcode_Become_A_Teacher::add_message(sprintf(__('Please %s to send your request!', 'learnpress'), sprintf('<a href="%s">%s</a>', learn_press_get_login_url(), _x('login', 'become-teacher-form', 'learnpress'))), 'login');
		} else {
			if (LP_Shortcode_Become_A_Teacher::has_sent()) {
				LP_Shortcode_Become_A_Teacher::add_message(__('Your have already sent the request. Please wait for approvement.', 'learnpress'), 'sent');
			} else if (learn_press_user_maybe_is_a_teacher()) {
				LP_Shortcode_Become_A_Teacher::add_message(__('You are a teacher!', 'learnpress'), 'is-teacher');
			}
		}

		if (!is_user_logged_in()) {
			$message = __("Please login to fill in this form.", 'learnpress');
			$code    = 1;
		} elseif (in_array(LP_TEACHER_ROLE, $user->get_roles())) {
			$message = __("You are a teacher now.", 'learnpress');
			$code    = 2;
		} elseif (get_transient('learn_press_become_teacher_sent_' . $user->get_id()) == 'yes') {
			$message = __('Your request has been sent! We will get back to you soon!', 'learnpress');
			$code    = 3;
		} elseif (learn_press_user_maybe_is_a_teacher()) {
			$message = __('Your role is allowed to create a course.', 'learnpress');
			$code    = 4;
		}

		if (apply_filters('learn_press_become_a_teacher_display_form', true, $code, $message)) {

			$fields = learn_press_get_become_a_teacher_form_fields();
			$args   = array_merge(
				array(
					'fields'  => $fields,
					'code'    => $code,
					'message' => $message
				)
			);

			learn_press_get_template('global/become-teacher-form.php', $args);
		}

		echo ob_get_clean();
	}
}

if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
// end copy