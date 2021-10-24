<?php
require 'Cart.php';

// can be initialized any time, preferrable on load? 
// or to save memory, initialize on first "Add to Cart" click?
// Anyhow, one cart : one session
$cart1 = new Cart();
$cart2 = new Cart();
$cart3 = new Cart();
$cart4 = new Cart();

echo '<h1>Cart 1</h1>';
// var_dump($cart->get_products());
var_dump($cart1->add_product_to_cart('B01'));
var_dump($cart1->add_product_to_cart('G01'));

echo '<pre>';
var_dump($cart1->get_cart());
echo '</pre>';

echo 'TOTAL: ';
var_dump($cart1->calculate_total());
echo '<br />';



echo '<h1>Cart 2</h1>';
// var_dump($cart->get_products());
var_dump($cart2->add_product_to_cart('R01'));
var_dump($cart2->add_product_to_cart('R01'));

echo '<pre>';
var_dump($cart2->get_cart());
echo '</pre>';

echo 'TOTAL: ';
var_dump($cart2->calculate_total());
echo '<br />';



echo '<h1>Cart 3</h1>';
// var_dump($cart->get_products());
var_dump($cart3->add_product_to_cart('R01'));
var_dump($cart3->add_product_to_cart('G01'));

echo '<pre>';
var_dump($cart3->get_cart());
echo '</pre>';

echo 'TOTAL: ';
var_dump($cart3->calculate_total());
echo '<br />';



echo '<h1>Cart 4</h1>';
// var_dump($cart->get_products());
var_dump($cart4->add_product_to_cart('B01'));
var_dump($cart4->add_product_to_cart('B01'));
var_dump($cart4->add_product_to_cart('G01'));
var_dump($cart4->add_product_to_cart('R01'));
var_dump($cart4->add_product_to_cart('R01'));
var_dump($cart4->add_product_to_cart('R01'));

// test remove from cart, index 2 (G01)
$cart4->remove_from_cart(2);

echo '<pre>';
var_dump($cart4->get_cart());
echo '</pre>';

echo 'TOTAL: ';
var_dump($cart4->calculate_total());
echo '<br />';