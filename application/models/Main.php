<?php 

namespace application\models;

use application\core\Model;


/**
 * Main
 */
class Main extends Model
{
	public $error;

	public function contactValidate($post)
	{
		$nameLen = iconv_strlen($post['name']);
		$textLen = iconv_strlen($post['text']);
		if ($nameLen < 3 or $nameLen > 20) 
		{
			$this->error .= 'Имя должно содержать от 3 до 20 символов.';
			return false;
		}
		if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) 
		{
			$this->error .= 'Не верный E-mail.';
			return false;
		}
		if ($textLen < 10 or $textLen > 500) 
		{
			$this->error .= 'Сообщение должно содержать от 10 до 500 символов.';
			return false;
		}

		// if ($nameLen < 3 or $nameLen > 20) 
		// {
		// 	$this->error = 'Имя должно содержать от 3 до 20 символов.';
		// 	if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) 
		// 	{
		// 		$this->error .= 'Не верный E-mail.';
		// 		if ($textLen < 10 or $textLen > 500) 
		// 		{
		// 			$this->error .= 'Сообщение должно содержать от 10 до 500 символов.';
		// 			return false;
		// 		}
		// 		return false;
		// 	}
		// 	return false;
		// }

		
		return true;
	}
}

 ?>