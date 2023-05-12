<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Order;
use App\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function addOrder(Request $request)
    {
        try {
            foreach ($request->items as $itemId) {
                $item = Item::findOrFail($itemId);

                Order::insert([
                    'place_id' => $request->placeId,
                    'category_id' => $item['category_id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                ]);
            }
            return response()->json(['success' => true, 'msg' => 'Order added Successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function calculatePrice(Request $request)
    {
        $change = $request->price - $request->totalPrice;
        $payment = Payment::create([
            'place_id' => $request->place_id,
            'received_price' => $request->price,
            'change'          => $change,
        ]);
        Order::where('place_id', $request->place_id)->delete();
        return redirect()->back();
    }

}
