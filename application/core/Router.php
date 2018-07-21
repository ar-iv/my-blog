<?php 

// Пространство имён
namespace application\core;

// хз
use application\core\View;


/**
 * Router
 */
class Router
{
	protected $routes = [];
	protected $params = [];

	function __construct() 
	{
		$arr = require 'application/config/routes.php';
		foreach ($arr as $key => $value) 
		{
			$this->add($key, $value);
		}
	}

	// Доавление маршрута
	public function add($route, $params)
	{
		$route = '#^'.$route.'$#';
		$this->routes[$route] = $params;
	}

	// Проверка маршрута
	public function match()
	{
		$uri = trim($_SERVER['REQUEST_URI'], '/');
		foreach ($this->routes as $route => $params) 
		{
			if (preg_match($route, $uri, $matches)) 
			{
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

	public function run()
	{
		if ($this->match()) 
		{
            $path = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
			if (class_exists($path)) 
			{
				$action = $this->params['action'].'Action';
				if (method_exists($path, $action)) 
				{
                    $controller = new $path($this->params);
                    $controller->$action();
				} else 
				{
					// $oldController->$action();
					// Action не найден
					View::errorCode(404);
				}
			} else 
			{
				// Class не найден
				View::errorCode(404);
			}
		}
		else 
		{
			// Маршрут не найден
			View::errorCode(404);
		}
	}
}

 ?>