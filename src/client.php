<?php
namespace App;

require_once('model/Product.php');

use App\Model\Product;

function main()
{
    $product1 = new Product("B00M0QVG3W");    // Canon Powershot
    // $product2 = new Product("B00R45Z2WU");    // B&O Casque
    // $product3 = new Product("B00PQWIZPY"); // Ipod
    echo '<pre>';
    var_dump($product1);
    echo '</pre>';
}

main();
