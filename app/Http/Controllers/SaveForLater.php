<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLater extends Controller
{
    public function SwitchToCart($id)
    {
        $item = Cart::instance('SwitchToSaveForLater')->get($id);

        Cart::instance('SwitchToSaveForLater')->remove($id);

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already in your Cart!');
        }

        Cart::instance('default')->add($item->id, $item->name, 1, $item->price)
            ->associate(Product::class);

        return redirect()->route('cart.index')->with('success_message', 'This item was added to your Shopping Cart');
    }

    public function destroy($id)
    {
        Cart::instance('SwitchToSaveForLater')->remove($id);

        return back()->with('success_message', 'This item was successfully removed');
    }
}
