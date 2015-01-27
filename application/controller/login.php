<?php

class Login extends controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->view->render('login/index');
	}

	public function login()
	{
		$login_model = $this->loadModel('login');
		$login_succesfull = $login_model->login();

		if ($login_succesfull) {
			header('location: ' . URL . 'dashboard/index');
		} else {
			header('location: ' . URL . 'login/index');
		}
		

	}

	public function logout()
	{
		$login_model = $this->loadModel('login');
		$login_model->logout();
		
		header('location: ' . URL);
	}

	public function register()
	{
		$this->view->render('login/register');
	}

	public function register_action()
	{
		$login_model = $this->loadModel('login');
		$registration_succesfull = $login_model->registerNewUser();

		if ($registration_succesfull) {
			header('location: ' . URL . 'login/index');
		} else {
			header('location: ' . URL . 'login/register');
		}
	}


}