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
		$route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
		$route = '#^'.$route.'$#';
		// debug($route);
		$this->routes[$route] = $params;
	}

	// Проверка маршрута
	public function match()
	{
		$url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) 
        {
            if (preg_match($route, $url, $matches)) 
            {
                foreach ($matches as $key => $match) 
                {
                    if (is_string($key)) 
                    {
                        if (is_numeric($match)) 
                        {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
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