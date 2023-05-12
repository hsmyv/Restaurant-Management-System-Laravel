<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Order;
use App\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function show($id)
    {
        $orders = Order::where('place_id', $id)->get();
        $totalPrice = Order::where('place_id', $id)->sum('price');
        $place = Place::findOrFail($id);
        $categories = Category::all();
        return view('admin.place.index', ['place' => $place, 'categories' => $categories, 'total_price' => $totalPrice, 'orders' => $orders]);
    }

    public function create()
    {
        return view('admin.room.create');
    }

    public function store(Request $request)
    {
        Place::insert(['room_id' => $request->room_id]);
        return redirect()->back();
    }
}
