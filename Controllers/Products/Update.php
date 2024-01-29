<?php
include_once("./../../App/Config.php");
include_once(MAIN_PATH . "/Views/layouts/header.php");
// include_once(MAIN_PATH . '/env.php');
include_once(MAIN_PATH . '/App/Validation.php');
include_once(MAIN_PATH . '/App/Database.php');
include_once(MAIN_PATH . '/App/Session.php');

echo "update";
// die;



if (isset($_POST['name'])) {
    foreach ($_POST as $key => $value) {
        $$key = htmlspecialchars(htmlentities(trim($value)));
    }
    $data = [
        "name" => $name,
        "url" => $url,
        "price" => $price
    ];
    $validation = new Validator();

    $validation->check([
        'name' => 'required|string|min:3|max:200',
        'price' => 'required|numeric',
        'url' => 'required|url'
    ]);

    if ($validation->getErrors()) {
        Session::set("errors", $validation->getErrors());
        var_dump(Session::get('errors'));
        die;
        header("Location:../../Views/products/edit.php?id=$id");
        die;
    } else {
       
        $database = new Database();
        $result = $database->update("products", $data,["id"=>$id]);
        if ($result) {
            Session::set("success", "product updated successfully");

            header("Location:../../Views/products/edit.php?id=$id");
            die;
        }
    }
    
}
