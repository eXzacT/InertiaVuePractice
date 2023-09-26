<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingOfferController extends Controller
{   
    public function store(Listing $listing,Request $request){

        //validate form
        $validatedData = $request->validate([
            'amount' => 'required|integer|min:1|max:20000000'
        ]);

        // Create the new offer instance and associate the bidder
        $listing->offers()->make($validatedData)
            ->bidder()->associate($request->user())->save();

        return redirect()->back()->with('success', 'Offer was successfully made!');
    }
}
