<?php
class Pages extends Controller {


    public function __construct() {


    }

    public function index() {

        $data = [
            'title'=>'Welcome',
            'body'=>'Welcome to HOME PAGE',
        ];
        $this -> view('pages/welcome', $data);
    }

    public function about() {
        $this -> view('pages/about');
    }


}