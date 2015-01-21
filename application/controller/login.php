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
		// geen code
	}
}