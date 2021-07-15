<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 * *****************************************************************************
 *
 * @package root
 */

function contact_form_isif_life( $atts ) {

	if ( ! empty( $_POST['email'] ) ) {
		$emailSent = false;
	} elseif ( isset( $_POST['submitted'] ) ) {
		if ( trim( $_POST['contact_name'] ) === '' ) {
			$nameError = __( 'Enter your name', THEME_TEXTDOMAIN );
			$hasError  = true;
		} else {
			$name = trim( $_POST['contact_name'] );
		}

		if ( trim( $_POST['iimmaaiill'] ) === '' ) {
			$emailError = __( 'Enter your e-mail', THEME_TEXTDOMAIN );
			$hasError   = true;
		} else if ( ! is_email( $_POST['iimmaaiill'] ) ) {
			$emailError = __( 'Wrong e-mail format', THEME_TEXTDOMAIN );
			$hasError   = true;
		} else {
			$email = trim( $_POST['iimmaaiill'] );
		}

		if ( trim( $_POST['contact_theme'] ) === '' ) {
			$themeError = __( 'Enter subject', THEME_TEXTDOMAIN );
			$hasError   = true;
		} else {
			$theme = trim( $_POST['contact_theme'] );
		}

		if ( trim( $_POST['contact_comments'] ) === '' ) {
			$commentError = __( 'Enter message', THEME_TEXTDOMAIN );
			$hasError     = true;
		} else {
			if ( function_exists( 'stripslashes' ) ) {
				$comments = stripslashes( trim( $_POST['contact_comments'] ) );
			} else {
				$comments = trim( $_POST['contact_comments'] );
			}
		}

		if ( ! empty( $_POST['contact_email'] ) ) {
			$commentError = __( 'Suspicious activity - are you a robot?', THEME_TEXTDOMAIN );
			$hasError     = true;
		}

		if ( ! isset( $hasError ) ) {
			$emailTo   = apply_filters( 'wpshop_contact_form_email_to', get_option( 'admin_email' ) );
			$subject   = 'Сообщение с сайта ' . get_site_url() . ' от ' . $name;
			$body      = "Имя: $name \n\nE-mail: $email \n\nТема: $theme \n\nСообщение: $comments";
			$mail_from = apply_filters( 'wpshop_contact_form_email_from', $email );
			$headers   = 'From: ' . $name . ' <' . $mail_from . '>' . "\r\n" . 'Reply-To: ' . $email;
			wp_mail( $emailTo, $subject, $body, $headers );
			$emailSent = true;
		}

	}


	ob_start();
	?>

    <div id="contact_form" class="contact-form">
		<?php if ( isset( $emailSent ) && $emailSent == true ) { ?>
            <div class="contact_message"><?php _e( 'Your message was successfully sent!', THEME_TEXTDOMAIN ) ?></div>
		<?php } else { ?>
			<?php if ( isset( $hasError ) || isset( $captchaError ) ) { ?>

			<?php } ?>

            <form action="<?php the_permalink(); ?>" method="post">

                <input type="email" name="email" style="display:none;">

                <div class="contact_left">
                    <div class="contact_name">
                        <input type="text" placeholder="<?php _e( 'Your name', THEME_TEXTDOMAIN ) ?>"
                               name="contact_name" id="contact_name"
                               value="<?php if ( isset( $_POST['contact_name'] ) ) {
							       echo $_POST['contact_name'];
						       } ?>" class="required requiredField"/>
						<?php if ( ! empty( $nameError ) ) { ?>
                            <div class="errors"><?= $nameError; ?></div>
						<?php } ?>
                    </div>
                    <div class="contact_email">
                        <input type="text" placeholder="E-mail" name="contact_email" id="contact_email"
                               value="<?php if ( isset( $_POST['contact_email'] ) ) {
							       echo $_POST['contact_email'];
						       } ?>" class="required requiredField email"/><input type="text" placeholder="E-mail"
                                                                                  name="iimmaaiill" id="iimmaaiill"
                                                                                  value="<?php if ( isset( $_POST['iimmaaiill'] ) ) {
							                                                          echo $_POST['iimmaaiill'];
						                                                          } ?>"
                                                                                  class="required requiredField iimmaaiill"/>
						<?php if ( ! empty( $emailError ) ) { ?>
                            <div class="errors"><?= $emailError; ?></div>
						<?php } ?>
                    </div>
                    <div class="contact_theme">
                        <input type="text" placeholder="<?php _e( 'Subject', THEME_TEXTDOMAIN ) ?>" name="contact_theme"
                               id="contact_theme" value="<?php if ( isset( $_POST['contact_theme'] ) ) {
							echo $_POST['contact_theme'];
						} ?>" class="required requiredField"/>
						<?php if ( ! empty( $themeError ) ) { ?>
                            <div class="errors"><?= $themeError; ?></div>
						<?php } ?>
                    </div>
                </div>

                <div class="contact_right">
                    <div class="contact_textarea">
                        <textarea placeholder="<?php _e( 'Message', THEME_TEXTDOMAIN ) ?>" name="contact_comments"
                                  id="commentsText" rows="12" cols="56"
                                  class="required requiredField"><?php if ( isset( $_POST['contact_comments'] ) ) {
								if ( function_exists( 'stripslashes' ) ) {
									echo stripslashes( $_POST['contact_comments'] );
								} else {
									echo $_POST['contact_comments'];
								}
							} ?></textarea>
						<?php if ( ! empty( $commentError ) ) { ?>
                            <div class="errors"><?= $commentError; ?></div>
						<?php } ?>
                    </div>

					<?php do_action( THEME_SLUG . '_contact_form_before_button' ); ?>
                    <button type="contsubmit" class="contact_submit"><?php _e( 'Send', THEME_TEXTDOMAIN ) ?></button>
                    <input type="hidden" name="submitted" id="submitted" value="true"/>
                </div>

            </form>
		<?php } ?>
    </div>

	<?php
	$buffer = ob_get_contents();
	ob_end_clean();

	return $buffer;
}

add_shortcode( 'contactform', 'contact_form_isif_life' );