<?php

use Gloudemans\Shoppingcart\Facades\Cart;

function presentPrice($price)
{
    return '$' . number_format($price / 100, 2);
}

function productImage($path)
{
    return $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset('img/not-found.jpg');
}

function setActiveCategory($category)
{
    return $category == request()->category ? 'active' : '';
}
function getNumbers()
{
    $tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0;
    $newSubtotal = Cart::subtotal() - $discount;
    $newTax = $newSubtotal *  $tax;
    $newTotol = $newSubtotal * (1 + $tax);

    return collect([
        'tax' => $tax,
        'newTotal' => $newTotol,
        'discount' => $discount,
        'newSubtotal' => $newSubtotal,
        'newTax' => $newTax,
    ]);
}
