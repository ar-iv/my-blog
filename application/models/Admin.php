<?php 

namespace application\models;

use application\core\Model;


/**
 * 	Admin
 */
class Admin extends Model
{
	public $error;

	public function loginValidate($post)
	{
		$config = require 'application/config/admin.php';
		if ($config['login'] != $post['login'] or $config['password'] != $post['password']) {
			$this->error .= 'Не верный login или password.';
			return false;
		}
		return true;
	}
}

 ?>