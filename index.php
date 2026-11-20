<?php

session_start();
require "Database.php";

$met = $_SERVER['REQUEST_METHOD'];
$config = require('config.php');
$db = new Database($config['database']);

function redirectBack()
{
    $page = $_GET['page'] ?? 1;
    $page = (int)$page;

    if ($page < 1) {
        $page = 1;
    }

    $toFind = trim($_GET['toFind'] ?? '');
    header('Location: index.php?page=' . $page . '&toFind=' . urlencode($toFind));
    exit;
}

if ($met === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action == 'save') {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $descr = trim($_POST['description']);
        $price = $_POST['price'];
        if ($_POST['availability_date']) {
            $avail_date = $_POST['availability_date'];
        } else {
            $avail_date = NULL;
        }
        $stock_status = $_POST['stock_status'] ?? 0;
        $imagePath = NULL;

        $errors = [];

        if ($name == '') {
            $errors[] = 'Product name is required!';
        }
        if (!is_numeric($price) or $price < 0) {
            $errors[] = 'The price must be a numeric valid value!';
        }
        if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] != '') {
            $target_dir    = "uploads/";
            $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $uploadOk      = 1;

            if (getimagesize($_FILES["image"]["tmp_name"]) === false) {
                $errors[] = 'The file is not an image.';
                $uploadOk = 0;
            }
            if ($_FILES["image"]["size"] > 500000) {
                $errors[] = 'The image is too large (max 500 KB).';
                $uploadOk = 0;
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $errors[] = 'Only JPG, JPEG, PNG & GIF files are allowed.';
                $uploadOk = 0;
            }

            if ($uploadOk == 1 && count($errors) == 0) {
                $target_file = $target_dir . uniqid() . '.' . $imageFileType;
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $imagePath = $target_file;
                } else {
                    $errors[] = 'Sorry, there was an error uploading your file.';
                }
            }
        }
        if (count($errors) == 0) {
            if ($imagePath) {
                if ($id) {
                    $params = [
                        ':name' => $name,
                        ':description' => $descr,
                        ':price' => $price,
                        ':availability_date' => $avail_date,
                        ':stock_status' => $stock_status,
                        ':id' => $id,
                        ':image' => $imagePath
                    ];

                    $sql = "update products set 
                name = :name, description = :description,
                 price = :price,  availability_date = :availability_date, 
                 stock_status = :stock_status,
                 image=:image where id = :id";
                } else {
                    $params = [
                        ':name' => $name,
                        ':description' => $descr,
                        ':price' => $price,
                        ':availability_date' => $avail_date,
                        ':stock_status' => $stock_status,
                        ':image' => $imagePath
                    ];

                    $sql = "insert into products (name, description, price, availability_date, stock_status, image) 
        values (:name, :description, :price, :availability_date, :stock_status, :image)";
                }
            } else {

                if ($id) {

                    $params = [
                        ':name' => $name,
                        ':description' => $descr,
                        ':price' => $price,
                        ':availability_date' => $avail_date,
                        ':stock_status' => $stock_status,
                        ':id' => $id,
                    ];

                    $sql = "update products set 
                name = :name, description = :description,
                 price = :price,  availability_date = :availability_date, 
                 stock_status = :stock_status where id = :id";
                } else {

                    $params = [
                        ':name' => $name,
                        ':description' => $descr,
                        ':price' => $price,
                        ':availability_date' => $avail_date,
                        ':stock_status' => $stock_status,
                    ];
                    $sql = "insert into products (name, description, price, availability_date, stock_status) 
        values (:name, :description, :price, :availability_date, :stock_status)";
                }
            }


            try {
                $db->query($sql, $params);
                $_SESSION['flash'] = ['message' => 'Product saved successfully!'];
            } catch (Exception $e) {
                $_SESSION['flash'] = [
                    'message' => 'Database error: ' . $e->getMessage(),
                    'old'     => $_POST
                ];
            }
            redirectBack();
        } else {
            $_SESSION['flash'] = [
                'message' => implode("\n", $errors),
                'old'     => $_POST
            ];
            redirectBack();
        }
    } else if ($action === 'delete') {
        $id = $_POST['id'] ?? null;

        try {
            if ($id) {
                $db->query('delete from products where id=:id', [':id' => $id]);
                $_SESSION['flash'] = ['message' => 'Product deleted successfully!'];
            } else {
                $_SESSION['flash'] = ['message' => 'The product id is missing!'];
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['message' => 'Database error: ' . $e->getMessage()];
        }
        redirectBack();
    }
}

$currentPage = $_GET['page'] ?? 1;
$toFind = $_GET['toFind'] ?? '';
$toFind = trim($toFind);
$perPage = 10;

// echo "$toFind";

$query = "select * from products order by id desc";
$countQuery = "select count(*) as total from products";
$countSQuery = "select count(*) as total from products where name like :toFind";


$products = $db->query($query)->fetchAll();

if ($toFind != '') {
    $totalProducts = (int)$db->query($countSQuery, ['toFind' => "%$toFind%"])->fetch()['total'];
} else {
    $totalProducts = (int)$db->query($countQuery)->fetch()['total'];
}


$nrPages = (int)ceil($totalProducts / $perPage);
if ($nrPages < 1)
    $nrPages = 1;

$offset = (int) ($currentPage - 1) * $perPage;

$limitQuery = "select * from products order by id desc limit $perPage offset $offset";
$limitSQuery = "select * from products where name like :toFind order by id desc limit $perPage offset $offset";

if ($toFind == '')
    $products = $db->query($limitQuery)->fetchAll();
else
    $products = $db->query($limitSQuery,  ['toFind' => "%$toFind%"])->fetchAll();
// if($product)
//     {
//         echo "<li>" . $product['name']. "<li\> <br>";
//     }
// foreach($products as $product){
//     echo "<li>".$product['name']."</li"."<br>";
// }
$start = $offset + 1;
$end = min($offset + $perPage, $totalProducts);


$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
require "index.view.php";
if ($flash) {
    $flags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
    $old   = !empty($flash['old']) ? json_encode($flash['old'], $flags) : 'null';
    echo '<script>document.addEventListener("DOMContentLoaded", function () {'
        . 'showMessageModal(' . json_encode($flash['message'], $flags) . ', ' . $old . ');'
        . '});</script>';
}
