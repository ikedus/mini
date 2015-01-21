<?php

class Auth
{
	public static function handleLogin()
	{
		session::init();

		if (!isset($_SESSION['user_logged_in'])) {
			Session::destroy();
			header('location:' . URL . 'login');
			exit();
		}
	}
}