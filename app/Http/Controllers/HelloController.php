<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelloController extends Controller
{
  public function index()
  {
    $note = "γγΌγ";
    dd($note);
  }
}
