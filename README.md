# Cart Class

This class handles all basic cart/basket functionalities. On load, the Product Catalogue, Discount Fees (rather than rules), and the Current Target Product **(shall be called CTP moving forward)** for the offer are initialzed as constants.

## Usage

Please open `./index.php` for all the implementations. This file also shows the results of the table described in the POC document for checking.

## Main Functions

## `add_product_to_cart( $prod_id )`

The main function that accepts a `String` `$prod_id`. With the given product ID, we'll search the catalogue for the appropriate product, and do nothing should no product be found. Once we found one, we then check the Cart if there's an existing **CTP** before we actually add it to not apply the offer twice. Please not that at this stage, we're not manipulating any prices, we're simply flagging the product for discount. This could be useful especially for the Front-End Dev for them to easily tag in the UI in case we require to show a __slashed__ version of the price.

## `calculate_total()`

This function sums up the whole cart and finds if there are any **CTP** so we can apply the half price. After adding them up, it will compute for the correct delivery fee to be applied. Please not that we have explicitly added a variable for 0 (zero) just so we lay out clearly, this can be totally removed though and just straight up set the delivery fee to 0 (zero). Also, please note that we've used `PHP_ROUND_HALF_DOWN` as a strategy since based on the provided table, they are not rounding up. This can be removed or changed easily should the requirements change.

## Utility Functions

## `get_products()`

Displays the products constants, in case needed.

## `get_cart()`

Returns the array of products in the Cart.

## `remove_from_cart( $index )`

Accepts an index of the product in the cart that should be removed.

## `empty_cart()`

Resets the cart.