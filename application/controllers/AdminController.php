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
		if (!$this->model->isPostExists($this->route['id'])) 
		{
			$this->view->errorCode(404);
		}
		if (!empty($_POST)) 
		{
			if (!$this->model->postValidate($_POST, 'edit')) 
			{
				$this->view->message('error', $this->model->error);
			}
			$this->model->postEdit($_POST, $this->route['id']);
			if ($_FILES['img']['tmp_name']) {
				$this->model->postUploadImage($_FILES['img']['tmp_name'], $id);
			}
			$this->view->message('success', 'Изменено.');
		}
		$vars = [
			'data' => $this->model->postData($this->route['id'])[0],
		];
		$this->view->render('Редактировать пост: ', $vars);
	}

	public function deleteAction()
	{
		if (!$this->model->isPostExists($this->route['id'])) 
		{
			// $this->view->message('error', $this->route['id']);
			$this->view->errorCode(404);
		}
		$this->model->postDelete($this->route['id']);
		$this->view->redirect('admin/posts');
		// exit('Удалиение: '.$this->route['id']);
	}

	public function postsAction()
	{
		$this->view->render('Посты.');
	}
}

 ?>