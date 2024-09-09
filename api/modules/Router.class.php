<?php
/**
 * @author Ewerton Mendonça
 * @version 1.0
 *
 *
 *
 */

class Router {

	private $filtersBefore = array();
	private $filtersAfter = array();

	private $routes = array();

    public static $GET = array();
    public static $POST = array();

	public function setFilterBefore($filter) {
		$this->filtersBefore[] = $filter;
	}

	public function setFilterAfter($filter) {
		$this->filtersAfter[] = $filter;
	}

	public function addRoute($uri, $callback) {
		foreach($this->routes as $key => $value) {
			if ($uri === $key) {
				$this->routes[$uri] = $callback;
				return;
			}
		}
		$this->routes[$uri] = $callback;
	}

    private function parameters() {
        if (isset($_GET)) {
            Router::$GET = array();
            foreach ($_GET as $key => $value) {
                Router::$GET[htmlspecialchars($key, ENT_QUOTES, 'UTF-8')] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            $_GET = null;
        }
        if (isset($_POST)) {
            Router::$POST = array();
            foreach ($_POST as $key => $value) {
                Router::$POST[htmlspecialchars($key, ENT_QUOTES, 'UTF-8')] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            $_POST = null;
        }
    }

	public function execute() {
        //echo $_SERVER['REQUEST_URI'];
        $this->parameters();

		$uri = strtok($_SERVER['REQUEST_URI'],'?');
		//echo "<p>$uri</p>";
		//echo '<pre>'; print_r($this->routes); echo '</pre><br /><br />';

		foreach($this->routes as $url => $valor) {

			if ($uri === $url) {
				//echo "<p>Match $url</p>";

				//echo '<pre>'; print_r($this->filtersBefore); echo '</pre><br /><br />';
				foreach($this->filtersBefore as $f) {
					call_user_func_array($f, array($url));
				}

				//echo '<pre>'; print_r($valor); echo '</pre><br /><br />';
				//echo '<pre>'; print_r(array($url)); echo '</pre><br /><br />';
				//call_user_func_array($valor, array($url));
				call_user_func($valor);
				
				//echo '<pre>'; print_r($this->filtersAfter); echo '</pre><br /><br />';
				foreach($this->filtersAfter as $f) {
					call_user_func_array($f, array($url));
				}
				return;
			}
		}
		exit();
	}
}