<?php
include_once("./../../App/Config.php");
include_once(MAIN_PATH . "/Views/layouts/header.php");
// include_once(MAIN_PATH . '/env.php');
include_once(MAIN_PATH . '/App/Validation.php');
include_once(MAIN_PATH . '/App/Database.php');
include_once(MAIN_PATH . '/App/Session.php');

echo "delete";
// die;


if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $database=new Database();
    if($database->delete("products",["id"=>$id])){
        Session::set("success",'deleted successfully');
    }else{
        Session::set("error",'faild'); 
    }

}


header("Location:../../Views/products/index.php");
die;