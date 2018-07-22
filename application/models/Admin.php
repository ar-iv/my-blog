<?php 

namespace application\models;

use application\core\Model;
use Imagick;


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
			$this->error = 'Имя должно содержать от 3 до 100 символов.';
			return false;
		}
		if ($nameLen < 3 or $nameLen > 100) 
		{
			$this->error = 'Описание должно содержать от 3 до 100 символов.';
			return false;
		}
		if ($textLen < 10 or $textLen > 2000) 
		{
			$this->error = 'Пост должно содержать от 10 до 2000 символов.';
			return false;
		}
		if ($type == 'add' and empty($_FILES['img']['tmp_name'])) 
		{
			$this->error = 'Отсутствует изображение.';
			return false;
		}
		return true;
	}

	public function postAdd($post)
	{
		$params = [
			// 'id' => '',
			'name' => $post['name'],
			'description' => $post['description'],
			'dtext' => $post['text'],
		];
		$this->db->query("INSERT INTO `posts`(`name`, `description`, `text`) VALUES  ( :name, :description, :dtext)", $params);
		return $this->db->lastInsertId();
	}

	public function postUploadImage($path, $id)
	{
		// $img = new Imagick($path);
		// $img->cropThumbnailImage(1080, 600);
		// $img->setImageCompressionQuality(80);
		// $img->writeImage('public/materials/'.$id.'.jpg');

		move_uploaded_file($path, 'public/materials/'.$id.'jpg');
	}
}

 ?>