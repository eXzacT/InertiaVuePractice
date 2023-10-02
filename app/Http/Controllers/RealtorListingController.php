<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateListingRequest;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{
    public function __construct(){
        $this->authorizeResource(Listing::class,'listing');
    }

    public function edit(Listing $listing)
    {
        return inertia(
            'Realtor/Edit',
            [
                'listing'=>$listing
            ]
        );
    }

    public function update(ValidateListingRequest $request,Listing $listing)
    {
        $listing->update(
            $request->validated()
        );

        return redirect()->route('realtor.listing.index')
            ->with('success','Listing was changed successfully!');
    }

    public function index(Request $request)
    {
        $filters=[
            'deleted'=>$request->boolean('deleted'),
            ...$request->only(['by','order'])
        ];

        $listings = Auth::user()
            ->listings()
            ->withCount('images')
            ->withCount('offers')
            ->filter($filters)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return inertia(
            'Realtor/Index',[
                'filters' => $filters,
                'listings' => $listings
            ]
        );
    }

    public function show(Listing $listing){
        return inertia(
            'Realtor/Show',
            ['listing' => $listing->load('offers', 'offers.bidder'),
            ]);
    }

    public function create()
    {
        return inertia('Realtor/Create');
    }

    public function store(ValidateListingRequest $request)
    {
        $request->user()->listings()->create(
            $request->validated()
        );

        return redirect()->route('realtor.listing.index')
            ->with('success','Listing was created successfully!');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();
        return redirect()->back()
            ->with('success','Listing was deleted successfully!');
    }

    public function restore(Listing $listing){
        $listing->restore();

        return redirect()->back()->with('success','Listing was successfully restored!');
    }
}
