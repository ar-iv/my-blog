<?php 

namespace application\controllers;

use application\core\Controller;

/**
 * AdminController
 */
class AdminController extends Controller
{
	public function __construct($route)
	{
		// Вызов конструктора радителя (конструктор из Controller)
		parent::__construct($route);
		// admin
		$this->view->layout = 'admin';

		// $_SESSION['admin'] = 1;
	}

	public function loginAction()
	{
		if (!empty($_POST)) 
		{
			if (!$this->model->loginValidate($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			$_SESSION['admin'] = true;
			// echo $_SESSION['admin'];
			// #my
			$this->view->location('add');
		}
		$this->view->render('Вход.');
	}

	public function logoutAction()
	{
		exit('Выход.');
	}

	public function addAction()
	{
		$this->view->render('Добавить пост');
	}

	public function editAction()
	{
		$this->view->render('Изменить.');
	}

	public function deleteAction()
	{
		exit('Удалиение.');
	}
}

 ?>