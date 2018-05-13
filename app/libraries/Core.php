<?php

    /*
    *App Core class
    *Creates URL & Loads core controller
    *URL Format -/controller/method/params
    */

    class Core
    {

        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $param = [];

        public function __construct()
        {
            //print_r($this->getUrl());
            $url = $this->getUrl();

            //look in controller for first value
            //ucwords make any String start with a capital letter ex. youssry Youssry
            if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){
                //if exists ,set as controller
                $this->currentController = ucwords($url[0]);
                unset($url[0]);
            }

            //require controller
            require_once '../app/controllers/'. $this->currentController .'.php';

            //instantiate controller class
            $this->currentController = new $this->currentController;

            //check of second part of url
            if(isset($url[1]))
            {
                //check to see if method exists in controller
                if(method_exists($this->currentController ,$url[1]))
                {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            //Get params
            $this->param = $url ? array_values($url) : [];

            //call back of array of params
            call_user_func_array([$this->currentController ,$this->currentMethod] ,$this->param);
        }

        public function getUrl()
        {
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'] ,'/'); // make url without / to make it array
                $url = filter_var($url ,FILTER_SANITIZE_URL); // make filter for url
                $url = explode('/', $url);  //make url array
                return $url;
            }
        }
    }