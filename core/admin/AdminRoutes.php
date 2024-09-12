<?php

// Admin routes need to be in a separate file so as not to be changed 
// accidently by the user.

Router::get('fw-admin', 'Admin', 'showDashboard', 'dashboard', ['title' => 'Dashboard']); //default route for fw-admin

// Login routes
Router::get('fw-admin/login', 'Admin', 'showLogin', 'login', ['title' => 'Login']);
Router::post('fw-admin/login', 'Admin', 'login', null, ['title' => 'Login']);

// Logout and dashboard routes
Router::get('fw-admin/logout', 'Admin', 'logout', null);
Router::get('fw-admin/dashboard', 'Admin', 'showDashboard', 'dashboard', ['title' => 'Dashboard']);
