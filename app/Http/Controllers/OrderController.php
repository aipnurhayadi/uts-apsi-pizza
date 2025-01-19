<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailAdditional;
use App\Models\Product;
use App\Models\ProductCrust;
use App\Models\ProductSize;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->where('order_status', 'oncart')
            ->orderBy('id', 'desc')
            ->first();

        if (!$order) {
            $address = Address::where('user_id', $user->id)->orderBy('id', 'desc')->first();

            if (!$address) {
                return redirect()->back()->withErrors('Alamat tidak ditemukan, harap tambahkan alamat terlebih dahulu.');
            }

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'order_status' => 'oncart',
            ]);
        }
        return Redirect::route('order.show', ['order' => $order->id]);
    }

    public function show(Request $request, Order $order): Response
    {
        $products = Product::with('images')->get();

        return Inertia::render('Order/Index', ['products' => $products, 'order' => $order]);
    }

    public function add(Request $request, Order $order,  Product $product): Response
    {
        $product->load('images');
        $product->load('crusts');
        $product->load('sizes');
        return Inertia::render('Order/Add', ['product' => $product, 'order' => $order]);
    }


    public function doadd(Request $request, Order $order, Product $product)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:255',
        ]);

        $crust_id = $validated['crust_id'] ?? null;
        $size_id = $validated['size_id'] ?? null;
        $notes = $validated['notes'] ?? '';

        try {
            $orderDetail = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'notes' => $notes,
            ]);

            if ($crust_id) {
                $crusts = ProductCrust::find($crust_id);
                if ($crusts) {
                    OrderDetailAdditional::create([
                        'order_detail_id' => $orderDetail->id,
                        'order_detail_additionable_id' => $crusts->id,
                        'order_detail_additionable_type' => ProductCrust::class,
                    ]);
                }
            }
            if ($size_id) {
                $sizes = ProductSize::find($size_id);
                if ($sizes) {
                    OrderDetailAdditional::create([
                        'order_detail_id' => $orderDetail->id,
                        'order_detail_additionable_id' => $sizes->id,
                        'order_detail_additionable_type' => ProductSize::class,
                    ]);
                }
            }

            return Redirect::route('order.show', ['order' => $order->id]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['summary' => $e->getMessage()]);
        }
    }

    public function cart(Request $request, Order $order)
    {
        return Inertia::render('Order/Cart', ['order' => $order]);
    }
}
