<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function contact() {
        return view('contact');
    }

    public function login() {
        return view('login');
    }

    public function register() {
        return view('register',['error' => false]);
    }

    public function cars() {
        return view('cars');
    }

    public function createCar() 
    {
        return view('dashboard.createCars');
    }

}