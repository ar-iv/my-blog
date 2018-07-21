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
		// debug($_SESSION);
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