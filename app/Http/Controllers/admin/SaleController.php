<?php

namespace App\Http\Controllers\admin;

use App\Models\cart;
use App\Models\sale;
use App\Models\product;
use App\Models\storeSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SaleController extends Controller
{

    public function cartView(){
        $cartData=cart::select('carts.id as cart_id','carts.quantity','products.image','products.name','products.price','products.id as product_id','products.category_id')
                ->leftJoin('products','carts.product_id','products.id')
                ->where('carts.user_id',Auth::user()->id)
                ->get();

        return view('admin.sale.cart',compact('cartData'));
    }

     public function saleProductView()
    {
        $product = product::select('products.id','products.name','products.price','products.description','products.image','products.stock','products.category_id','categories.name as category_name')
                ->leftJoin('categories','products.category_id','categories.id')
                ->orderBy('products.created_at','desc')
                ->get();

        // Fetch cart for current user
        $cart = cart::where('user_id', Auth::id())->get();

        return view('admin.sale.saleproduct', compact('product', 'cart'));
    }

    public function addCart(Request $request)
    {
        $userId = $request->userid;
        $productId = $request->productid;

        // Check if the product is already in the user's cart
        $existingCartItem = cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            // Product is already in the cart, show toast notification
            Alert::toast('Product is already in your cart!', 'error')->position('top')->hideCloseButton();
            return back(); // Redirect back to the sale product view
        }

        // Product is not in the cart, add it
        cart::create([
            'user_id' => $userId,
            'product_id' => $productId,
            // You might need to add other fields like quantity, price, etc.
        ]);

        return back(); // Redirect back to the sale product view
    }

    public function cartDelete($id){
       cart::where('id', $id)->delete();
       return back();
    }

    public function store(Request $request)
    {
        // Validate that all items have a description
        if (empty($request->cart[0]['description'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Description is required!'
            ], 422);
        }

        // Get the current open store session
        $session = storeSession::whereNull('closed_at')->latest()->first();

        if (!$session) {
            return response()->json(['status' => 'error', 'message' => 'No open store session!'], 400);
        }

        foreach ($request->cart as $item) {
            $product = product::find($item['product_id']);
            if (!$product || $product->stock < $item['quantity']) {
                return response()->json([
                    'status' => 'error',
                    'message' => $product ? 'Out of stock for ' . $product->name : 'Product not found!'
                ], 400);
            }

            // Create sale record
            sale::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'description'=>$item['description'],
                'quantity' => $item['quantity'],
                'total' => $item['total'],
                'store_session_id' => $session->id,
            ]);

            // Minus product stock
            $product->stock -= $item['quantity'];
            $product->save();
        }

        // Destroy all cart data for the user
        $userId = $request->cart[0]['user_id'] ?? null;
        if ($userId) {
            cart::where('user_id', $userId)->delete();
        }

        return response()->json(['status' => 'success']);
    }

    public function saleListView(Request $request)
    {
        $query = sale::select(
                'products.name as product_name',
                'products.price',
                'sales.quantity',
                'sales.description',
                'sales.total',
                'sales.created_at'
            )
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->orderBy('sales.created_at', 'desc');

        // Apply filters based on request
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('sales.created_at', today());
                    break;
                case 'month':
                    $query->whereMonth('sales.created_at', now()->month)
                          ->whereYear('sales.created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('sales.created_at', now()->year);
                    break;
            }
        }

        // Apply custom date range filter
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('sales.created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('sales.created_at', '<=', $request->end_date);
        }

        $sessions = $query->get();

        // Calculate summary statistics
        $totalSales = $sessions->sum('total');
        $totalQuantity = $sessions->sum('quantity');
        $transactionCount = $sessions->count();

        return view('admin.sale.salelist', compact('sessions', 'totalSales', 'totalQuantity', 'transactionCount'));
    }

    public function openStore()
    {
        // Check if already open
        if (storeSession::whereNull('closed_at')->exists()) {
            return back()->with('error', 'Store is already open!');
        }
        storeSession::create([
            'opened_at' => now(),
            'opened_by' => Auth::id(),
        ]);
        return redirect()->route('saleManagementView')->with('success', 'Store opened!'); // Redirect to salemanagement
    }
    public function closeStore()
    {
        $session = storeSession::whereNull('closed_at')->latest()->first();
        if (!$session) {
            return back()->with('error', 'No open store session!');
        }
        $session->update([
            'closed_at' => now(),
            'closed_by' => Auth::id(),
        ]);
        return back()->with('success', 'Store closed!'); // Redirect back to salemanagement
    }

    public function saleManagementView()
    {
        $cart = cart::get();
        $session = storeSession::latest('opened_at')->first(); // Fetch latest session
        $storeOpen = storeSession::whereNull('closed_at')->exists();

        $sessions = collect();
        $totalAmount = 0;

        if ($session) {
            // Get all sales for the session to calculate total
            $totalAmount = sale::where('store_session_id', $session->id)->sum('total');
            
            // Paginate sales for the latest session
            $sales = $session->sales()->with('product')->paginate(10);
            $session->setRelation('sales', $sales);
            $sessions = collect([$session]);
        }

        return view('admin.sale.salemanagement', compact('storeOpen', 'sessions', 'cart', 'totalAmount'));
    }
}
