<?php 

namespace application\controllers;

use application\core\Controller;
use application\models\Main;

/**
 * MainController
 */
class MainController extends Controller
{
	public function indexAction()
	{
		$this->view->render('Главная страница.');
	}

	public function aboutAction()
	{
		$this->view->render('Обо мне.');
	}

	public function contactAction()
	{
		if (!empty($_POST)) 
		{
			if (!$this->model->contactValidate($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			// Отправка формы
			mail('puwifaji@loketa.com', 'Сообщение из блога от '.$_POST['name'].' , '.$_POST['email'].': ', $_POST['text']);
			$this->view->message('success', 'Сообщение отправлено Администратору.');			
		}
		$this->view->render('Контакты.');
	}

	public function postAction()
	{
		$this->view->render('Посты.');
	}
}

 ?>