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

	public function postValidate($post, $type)
	{
		$nameLen = iconv_strlen($post['name']);
		$descriptionLen = iconv_strlen($post['description']);
		$textLen = iconv_strlen($post['text']);
		if ($nameLen < 3 or $nameLen > 100) 
		{
			$this->error .= 'Имя должно содержать от 3 до 100 символов.';
			return false;
		}
		if ($nameLen < 3 or $nameLen > 100) 
		{
			$this->error .= 'Описание должно содержать от 3 до 100 символов.';
			return false;
		}
		if ($textLen < 10 or $textLen > 2000) 
		{
			$this->error .= 'Пост должно содержать от 10 до 2000 символов.';
			return false;
		}
		if ($type == 'add' and empty($_FILES['img']['tmp_name'])) 
		{
			$this->error .= 'Отсутствует изображение.';
			return false;
		}
		return true;
	}
}

 ?>