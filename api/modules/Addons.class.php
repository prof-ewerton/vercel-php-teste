<?php
/*
* Project Cody
* Autor: Ewerton Mendonça
* Descrição:
*/
require_once('modules/Router.class.php');

class Addons {

	private $router;

	public function __construct($router) {
		$this->router = $router;
		$this->load();
	}

	// TODO: Verificar dependência entre plugins
	public function load() {
        $path = getcwd() . DIRECTORY_SEPARATOR . 'addons';

		$iter = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
				RecursiveIteratorIterator::SELF_FIRST,
				RecursiveIteratorIterator::CATCH_GET_CHILD // Ignore "Permission denied"
		);

		foreach ($iter as $path => $dir) {
			if ($dir->isDir()) {
				$classe = ucfirst($dir->getFilename());
                //echo "<p>[$dir]</p>";
                //echo "<p>[$classe]</p>";
                //echo "<p>" . file_exists($path . DIRECTORY_SEPARATOR . $classe . '.class.php') . "</p>";
				if (file_exists($path . DIRECTORY_SEPARATOR . $classe . '.class.php')) {
					require_once($path . DIRECTORY_SEPARATOR . $classe . '.class.php');
					$obj = new $classe($this->router);
                    $obj->path = $path;
                    //echo "<p>[" . $obj->path . "]</p>";
				}
			}
		}
	}
}