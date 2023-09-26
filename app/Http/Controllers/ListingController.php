<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class ListingController extends Controller
{
    
    //we can apply middleware in the constructor or in routes
    public function __construct()
    {   
        //for applying said middleware
        //$this->middleware('auth')->except('index','show');
        $this->authorizeResource(Listing::class,'listing');
    }

    public function index(Request $request)
    {   
        $filters=$request->only([
            'priceFrom','priceTo','beds','baths','areaFrom','areaTo'
        ]);

        return inertia(
            'Listing/Index',
            [   
                'filters'=>$filters,
                'listings'=>Listing::latest()
                    ->filter($filters)
                    ->paginate(10)
                    ->withQueryString()
            ]
        );
    }

    public function show(Listing $listing)
    {   
        //$this->authorize('view',$listing);
        $listing->load(['images']);
        
        return inertia(
            'Listing/Show',
            [
                'listing'=>$listing
            ]
        );
    }
}
