<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{   
    //overwrite for admin to be able to use everything
    public function before(?User $user,$ability){        
        if($user?->is_admin/*&&$ability=='update'*/){
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Only owners of the listing can see the listing even if it was sold
     */
    public function view(?User $user, Listing $listing): bool
    {   
        if($listing->owner_id==$user?->id){
            return true;
        }
        return $listing->sold_at==null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): bool
    {
        return $listing->sold_at==null
            &&($listing->owner_id==$user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return ($listing->owner_id==$user->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listing $listing): bool
    {
        return ($listing->owner_id==$user->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return ($listing->owner_id==$user->id);
    }
}
