<?php
   namespace App\Controllers;
   use App\Controllers\Controller;
   use App\Models\Contact;

   class HomeController extends Controller{
      public function index(){
         $contact=new Contact();
        return $contact->where("name","yonatan")->first();
         // $array = [];
         // foreach($contact->query() as $key=>$value){
         //    $array[$key] = $value;
         // }
         // var_dump($value);
        
         
         // return $this->view("prueba.home",["hola"=>"mundo"]);
      }
      
   }      
?>