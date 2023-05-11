<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Place;
use App\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();

        return view('admin.room.index', compact('rooms'));
    }
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.room.show', ['room' => $room]);
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

        $room = Room::create($formfill);
        $roomId = $room->id;

        for ($i = 1; $i < $request->place + 1; $i++) {
            $place = new Place();
            $place->room_id = $roomId;
            $place->name = $i;
            $place->save();
        }

        $rooms = Room::all();
        return view('admin.room.index', compact('rooms'));
    }
}
