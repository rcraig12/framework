<?php


Router::get('', 'Page', 'render', 'home', [ 'title' => 'Home']);
Router::get('about', 'Page', 'render', 'about', [ 'title' => 'About']);

//Router::debug();