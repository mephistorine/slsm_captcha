<?php
/*
	Plugin Name: Капча
	Description: Добавляет капчу в форму комментариев
	Author: stylesam
	Author URI: http://stylesam.com/
	Version: 1.0
	License: MIT
*/

class SLSMCaptcha
{
	/**
	 * SLSMCaptcha constructor.
	 */
	public function __construct()
	{
		add_filter('comment_form_default_fields', [$this, 'captcha']);
		add_filter('preprocess_comment', [$this, 'check_captcha']);
	}

	/**
	 * @param $fields
	 * @return mixed
	 */
	public function captcha($fields)
	{

		unset($fields['url']);

		$fields['captcha'] = '
		<p class="comment-form-author">
			<label for="captcha">Капча <span class="required">*</span></label>
			<input id="captcha" name="captcha" type="checkbox" required="required">
		</p>';

		return $fields;
	}

	/**
	 * @param $comment_data
	 * @return mixed
	 */
	public function check_captcha($comment_data)
	{
		if ( is_user_logged_in() )
		{
			return $comment_data;
		}

		if ( !$_POST['captcha'] )
		{
			wp_die('<strong>Ошибка :</strong> Вы не прошли проверку на человечность');
		}

		return $comment_data;
	}
}

$slsm_captcha = new SLSMCaptcha();