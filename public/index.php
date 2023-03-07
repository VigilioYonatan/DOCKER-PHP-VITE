<?php
require_once __DIR__."/../config/db.php";
require_once __DIR__."/helpers.php";
require __DIR__."/../vendor/autoload.php"; 
use App\Route;
use App\Controllers\HomeController;

Route::get("/",[HomeController::class,"index"]);
Route::get("/contacto",function(){
   return ["title"=>"home","ga"=>"ga"];
});
Route::get("/cursos/pruebas",function(){
   return "hola cursos pruebas";
});
Route::get("/cursos/:id",function($id){
   return "hola $id";
});


Route::dispatch();

?>