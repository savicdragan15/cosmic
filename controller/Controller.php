<?php 
/**
 * 
 */
abstract class Controller{
	public $layout = null;
	public function index(){}
	//metod loadView - ucitava poglede na osnovu unetog parametra
	public function loadView($view, $data = array()) {
        $content = "[VIEW]";
        $this->data = $data;
        if ($this->layout) {
            ob_start(); //pokretanje output buffering-a 
            include "view/" . $this->layout . ".php";
            $content = ob_get_clean();
        }
        ob_start();
        include "view/" . $view . ".php";
        $viewContent = ob_get_clean();
        echo str_replace("[VIEW]", $viewContent, $content);
    }
}