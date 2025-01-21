<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDetailAdditional;
use App\Models\PaymentMethod;
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

        $crust_id = $request->input('crust_id') ?? null;
        $size_id = $request->input('size_id') ?? null;
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
        $order->load([
            'orderDetails.product.images',
            'orderDetails.orderDetailAdditionals.orderDetailAdditionable'
        ]);

        // address
        $address = Address::where('user_id', Auth::user()->id)->with(['outlet', 'deliveryTime'])->orderBy('id', 'desc')->first();

        // payment method
        $paymentMethods = PaymentMethod::get();

        return Inertia::render('Order/Cart', ['order' => $order, 'address' => $address, 'paymentMethods' => $paymentMethods]);
    }

    public function docart(Request $request, Order $order)
    {
        // $validated = $request->validate([
        //     'payment_method_id' => 'required|string|max:255|exists:payment_methods,id',
        // ]);

        // $payment_method_id = $validated['payment_method_id'];

        $payment_method_id = $request->input('payment_method_id');
        try {
            $order->payment_method_id = $payment_method_id;
            $order->order_status = 'onprogress';
            $order->save();

            return Redirect::route('order.transaction');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['summary' => $e->getMessage()]);
        }
    }

    public function transaction(): Response
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->with([
                'orderDetails.product.images',
                'orderDetails.orderDetailAdditionals.orderDetailAdditionable'
            ])
            ->whereIn('order_status', ['onprogress', 'completed'])
            ->orderBy('id', 'desc')->get();

        return Inertia::render('Order/Transaction', ['orders' => $orders]);
    }

    public function deleteTransaction(Request $request, Order $order)
    {
        try {
            $order->delete();
            return Redirect::route('order.transaction')->with('success', 'Transaction has been deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['summary' => $e->getMessage()]);
        }
    }
}
