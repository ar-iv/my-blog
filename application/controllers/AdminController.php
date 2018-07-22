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
	}

	public function loginAction()
	{
		if (isset($_SESSION['admin'])) 
		{
			$this->view->redirect('admin/add');
		}

		if (!empty($_POST)) 
		{
			if (!$this->model->loginValidate($_POST)) 
			{
				$this->view->message('error', $this->model->error);
			}
			$_SESSION['admin'] = true;
			$this->view->location('admin/add');
		}
		$this->view->render('Вход.');
	}

	public function logoutAction()
	{
		unset($_SESSION['admin']);
		// $_SESSION['admin'] = false;
		$this->view->redirect('admin/login');
	}

	public function addAction()
	{
		if (!empty($_POST)) {
			if (!$this->model->postValidate($_POST, 'add')) 
			{
				$this->view->message('error', $this->model->error);
			}
			$id = $this->model->postAdd($_POST);
			if (!$id) {
				$this->view->message('success', 'Ошибка обработки запроса');
			}
			$this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
			$this->view->message('success', 'Пост добавлен');
		}
		$this->view->render('Добавить пост');
	}

	public function editAction()
	{
		if (!empty($_POST)) {
			if (!$this->model->postValidate($_POST, 'edit')) {
				$this->view->message('error', $this->model->error);
			}
			$this->view->message('success', 'Okk');
		}
		$this->view->render('Изменить.');
	}

	public function deleteAction()
	{
		// debug($this->route['id']);
		exit('Удалиение.');
	}

	public function postsAction()
	{
		$this->view->render('Посты.');
	}
}

 ?>