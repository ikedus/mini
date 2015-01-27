<?php

class LoginModel
{
	function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

	public function login()
	{
		if (!isset($_POST['user_name']) || empty($_POST['user_name'])) {
			$_SESSION["feedback_negative"][] = FEEDBACK_USERNAME_FIELD_EMPTY;
			return false;
		}
		if (!isset($_POST['user_password']) || empty($_POST['user_password'])) {
			$_SESSION["feedback_negative"][] = FEEDBACK_PASSWORD_FIELD_EMPTY;
			return false;
		}

		$sth = $this->db->prepare("SELECT user_id,
										  user_name,
										  user_email,
										  user_password_hash,
										  user_active,
										  user_failed_logins
										  user_last_failed_login
								   FROM users
								   WHERE (user_name = :user_name OR user_email = :user_name");

		$sth->execute(array(':user_name' => $_POST['user_name']));
		$count = $sth->rowCount();



		if ($count != 1) {
			$_SESSION['feedback_negative'][] = FEEDBACK_LOGIN_FAILED;
		}

		$result = $sth->fetch();

		if (($result->user_failed_logins >= 3) AND ($result->user_last_failed_login > (time()-30))){
			$_SESSION['feedback_negative'][] = FEEDBACK_PASSWORD_WRONG_3_TIMES;
			return false;
		}

		if (password_verify($_POST['user_password'],$result->user_password_hash)){
			
		}
	}

	public function logout()
	{
		setcookie('rememberme', false, time() - (3600 * 24 *3650), '/', COOKIE_DOMAIN);

		Session::destroy();
	}

	public function registerNewUser()
	{
		if (empty($_POST['user_name'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_USERNAME_FIELD_EMPTY;
		} elseif (empty($_POST['user_password_new']) OR empty($_POST['user_password_repeat'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_PASSWORD_FIELD_EMPTY;
		} elseif ($_POST['user_password_new'] != $_POST['user_password_repeat']) {
			$_SESSION['feedback_negative'][] = FEEDBACK_PASSWORD_REPEAT_WRONG;
		} elseif (strlen($_POST['user_password_new']) < 6) {
			$_SESSION['feedback_negative'][] = FEEDBACK_PASSWORD_TOO_SHORT;
		} elseif (strlen($_POST['user_name']) < 2 OR strlen($_POST['user_name']) > 64) {
			$_SESSION['feedback_negative'][] = FEEDBACK_USERNAME_TOO_SHORT_OR_TOO_LONG;
		} elseif (!preg_match('/^[a-zA-Z\d]{2,64}/i', $_POST['user_name'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_USERNAME_DOES_NOT_FIT_PATTERN;
		} elseif (empty($_POST['user_email'])) {
			$_SESSION['feedback_negative'][] = FEEDBACK_EMAIL_FIELD_EMPTY;
		} elseif (strlen($_POST['user_email']) > 64) {
			$_SESSION['feedback_negative'][] = FEEDBACK_EMAIL_TOO_LONG;
		} elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['feedback_negative'][] = FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN;
		} elseif (!empty($_POST['user_name']) &&
				  strlen($_POST['user_name']) <= 64 &&
				  strlen($_POST['user_name']) >= 2 &&
				  preg_match('/^[a-zA-Z\d]{2,64}/i', $_POST['user_name']) &&
				  !empty($_POST['user_email']) &&
				  strlen($_POST['user_email']) <= 64 &&
				  filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL) &&
				  !empty($_POST['user_password_new']) &&
				  !empty($_POST['user_password_repeat']) &&
				  ($_POST['user_password_new'] === $_POST['user_password_repeat'])) {

			$user_name = strip_tags($_POST['user_name']);
			$user_email = strip_tags($_POST['user_email']);

			$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
			$user_password_hash = password_hash($_POST['user_password_new'], PASSWORD_DEFAULT, array('cost' => $hash_cost_factor ));

			$query = $this->db->prepare("SELECT * FROM users WHERE user_name = :user_name");
			$query->execute(array(':user_name' => $user_name));
			$count = $query->rowCount();
			if ($count == 1) {
				$_SESSION['feedback_negative'][] = FEEDBACK_USERNAME_ALREADY_TAKEN;
			}

			$query = $this->db->prepare("SELECT * FROM users WHERE user_email = :user_email");
			$query->execute(array(':user_email' => $user_email));
			$count = $query->rowCount();
			if ($count == 1) {
				$_SESSION['feedback_negative'][] = FEEDBACK_EMAIL_ALREADY_TAKEN;
			}

			$user_activation_hash = sha1(uniqid(mt_rand(), true));
			$user_creation_timestamp = time();

			$sql = "INSERT INTO users (user_name, user_password_hash, user_email, user_creation_timestamp, user_activation_hash)
					VALUES (:user_name, :user_password_hash, :user_email, :user_creation_timestamp, :user_activation_hash)";

			$query = $this->db->prepare($sql);
			$query->execute(array(':user_name' => $user_name, 
								  ':user_password_hash' => $user_password_hash, 
								  ':user_email' => $user_email, 
								  ':user_creation_timestamp' => $user_creation_timestamp, 
								  ':user_activation_hash' => $user_activation_hash));
			$count = $query->rowCount();			
			if ($count == 1) {
				$_SESSION['feedback_negative'][] = FEEDBACK_ACCOUNT_CREATION_FAILED;
			}

			$query = $this->db->prepare("SELECT user_id FROM users WHERE user_name = :user_name");
			$query-execute(array(':user_name' => $user_name));
			if ($count != 1) {
				$_SESSION['feedback_negative'][] = FEEDBACK_UNKNOW_ERROR;
			}

			$result_user_row = $query->fetch();
			$user_id = $result_user_row->user_id;

			if ($this->sendVerificationEmail($user_id,$user_email,$user_activation_hash)) {
				$_SESSION['feedback_positive'][] = FEEDBACK_ACCOUNT_SUCCESFULLY_CREATED;
			} else {
				$query = $this->db->prepare("DELETE FROM users WHERE user_id = :last_inserted_id");
				$query->execute(array('last_inserted_id' => $user_id));
				$_SESSION['feedback_negative'][] = FEEDBACK_VERIFICATION_EMAIL_SENDING_FAILED;
			}

			return true;
			// $_SESSION['feedback_negative'][] = FEEDBACK_EMAIL_DOES_NOT_FIT_PATTERN;
		} else {
			$_SESSION['feedback_negative'][] = FEEDBACK_UNKNOW_ERROR;
		}
		return false;
	}
}