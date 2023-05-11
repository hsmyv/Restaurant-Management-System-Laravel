<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function show($id)
    {
        $place = Place::findOrFail($id);
        return view('admin.place.index', ['place' => $place]);
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
