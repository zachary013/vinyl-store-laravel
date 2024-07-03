<?php

// app/Http/Controllers/CartItemController.php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index()
    {
        return CartItem::with(['cart', 'product'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::create($validated);

        return response()->json($cartItem, 201);
    }

    public function show(CartItem $cartItem)
    {
        return $cartItem->load(['cart', 'product']);
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'cart_id' => 'sometimes|required|exists:carts,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        $cartItem->update($validated);

        return response()->json($cartItem);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json(null, 204);
    }
}
