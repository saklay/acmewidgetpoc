<?php

// Simple class implementation. If there would be variations of a Cart, we have to create an Interface instead for better architecture.
class Cart 
{
  // representation of Product class object, setting this as array now for simplicity
  // if by any case, client requires a more sophisticated Product model, we'll need to create a separate Model Class for it.
  const PRODUCTS = [
    [
      'product_name' => 'Red Widget',
      'product_id'   => 'R01',
      'price'        => 32.95
    ],
    [
      'product_name' => 'Green Widget',
      'product_id'   => 'G01',
      'price'        => 24.95
    ],
    [
      'product_name' => 'Blue Widget',
      'product_id'   => 'B01',
      'price'        => 7.95
    ],
  ];

  const ZERO_DELIVERY_FEE = 0;  // can be omitted, but for documentation and clarity, we define it
  const ZERO_FEE_CAP = 90;
  const SMALL_DELIVERY_FEE = 2.95;
  const SMALL_FEE_CAP = 50;
  const LARGE_DELIVERY_FEE = 4.95;
  const CURRENT_OFFER_TARGET_PRODUCT_ID = 'R01';

  // representation of all the orders in one place
  public $cart = [];

  // Should exist in the product array
  public function add_product_to_cart( $prod_id ) {
    // This will change, and will be heavily affected by how the products are represented in the actual implementation.
    // Suppose the products won't be too complicated, I personally think that a static array like the public variable in the class will suffice.
    $product_to_add = array_filter( self::PRODUCTS, function ( $row ) use ( $prod_id ) {
      return strtolower( $row[ 'product_id' ] ) === strtolower( $prod_id );
    } );
    
    // unpacks the array (clears any index as well), if using PHP 7.4 we can use (...) spread operator instead
    $product_to_add && $product_to_add = array_merge( [], $product_to_add );

    // this maps the cart and check if we can apply the offer
    if ( !empty( $this->cart ) && !empty( $product_to_add ) ) {
      // filter the cart for any applied discounts first
      $discounted_found = array_filter( $this->cart, function ( $row ) {
        return $row[0][ 'product_id' ] === self::CURRENT_OFFER_TARGET_PRODUCT_ID && isset( $row[0][ 'discounted' ] );
      } );

      // if nothing was found, add the discount flag, else leave as is.
      // it's either a different product or a discount was already fount.
      empty( $discounted_found ) && $product_to_add[0][ 'product_id' ] === self::CURRENT_OFFER_TARGET_PRODUCT_ID && $product_to_add[0][ 'discounted' ] = true;
    }

    // inserts the found product into the cart
    $product_to_add && $this->cart[] = $product_to_add;
    
    return $product_to_add ? "Successfully added {$product_to_add[0][ 'product_name' ]} to cart!" : 'No products found with the given ID.';
  }

  // sums up the cart, applies delivery fee and offers
  public function calculate_total() {
    $total = !empty( $this->cart ) ? array_reduce( $this->cart, function ( $sum, $row ) {
      return $sum += isset( $row[0][ 'discounted' ] ) ? round( $row[0][ 'price' ] / 2, 3 ) : $row[0][ 'price' ];
    }, 0 ) : 0;

    // apply delivery fee
    if ( $total >= self::ZERO_FEE_CAP ) {
      $total += self::ZERO_DELIVERY_FEE;
    } else if ( $total >= self::SMALL_FEE_CAP ) {
      $total += self::SMALL_DELIVERY_FEE;
    } else {
      $total += self::LARGE_DELIVERY_FEE;
    }

    // round( $total, 2, PHP_ROUND_HALF_DOWN ) (optional) can be simply $total if we want the most precise value
    // also, used PHP_ROUND_HALF_DOWN, since based on the table they are not rounding up.
    return round( $total, 2, PHP_ROUND_HALF_DOWN );
  }

  /* ✨  EXTRA UTILITY FUNCTIONS ✨ */

  public function get_products() {
    return self::PRODUCTS;
  }

  public function get_cart() {
    return $this->cart;
  }

  // accept index (assumes this is passed by a JS button click, using cart index)
  public function remove_from_cart( $index ) {
    return !empty( $this->cart ) ? array_splice( $this->cart, $index, 1 ) : 'Cart is empty!';
  }

  // Simply resets the cart
  public function empty_cart() {
    return $this->cart = [];
  }
}
