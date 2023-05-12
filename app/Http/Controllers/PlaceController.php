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
        $totalPrice = Order::where('place_id', $id)->sum('price');
        $place = Place::findOrFail($id);
        $categories = Category::all();
        return view('admin.place.index', ['place' => $place, 'categories' => $categories, 'total_price' => $totalPrice]);
    }

    public function create()
    {
        return view('admin.room.create');
    }

    public function store(Request $request)
    {
        $formfill = $request->validate([
            'name' => 'required',
        ]);

        $room = Place::create($formfill);
        $roomId = $room->id;

        for ($i = 0; $i < $request->place; $i++) {
            $place = new Place();
            $place->room_id = $roomId;
            $place->name = $i;
            $place->save();
        }

        $rooms = Place::all();
        return view('admin.room.index', compact('rooms'));
    }
}
