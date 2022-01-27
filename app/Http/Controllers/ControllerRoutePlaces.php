<?php

namespace App\Http\Controllers;

use App\Models\Poi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class ControllerRoutePlaces extends Controller
{
    public function show($id = null)
    {

        // aOoPe6kJglVNKgA7


        if ($id) {

            $id = Hashids::decode($id);

            Log::debug($id);

            return view('place', [
                'place' => Poi::findOrFail($id)
            ]);
        } else {
            return view('places', [
                'places' => Poi::all()
            ]);
        }
    }
}
