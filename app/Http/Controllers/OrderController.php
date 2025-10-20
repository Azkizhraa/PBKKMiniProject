<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('menuItems')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuItems = MenuItem::where('availability', true)->get();
        return view('orders.create', compact('menuItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'menu_items' => 'required|array|min:1',
            'menu_items.*' => 'exists:menu_items,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:1',
        ]);

        $totalPrice = 0;
        foreach ($validated['menu_items'] as $key => $menuItemId) {
            $menuItem = MenuItem::find($menuItemId);
            $totalPrice += $menuItem->price * $validated['quantities'][$key];
        }

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        foreach ($validated['menu_items'] as $key => $menuItemId) {
            $order->menuItems()->attach($menuItemId, [
                'quantity' => $validated['quantities'][$key]
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,completed'
        ]);

        $order->update($validated);
        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
