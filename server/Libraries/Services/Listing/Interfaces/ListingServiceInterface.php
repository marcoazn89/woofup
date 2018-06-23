<?php
namespace ParkAlong\Libraries\Services\Listing\Interfaces;

/**
 * Listing Service Interface
 *
 * This interface is meant to be inherited by anybody writing a profile service
 *
 * @author Marco A Chang marco@parkalong.us
 * @version 0.1.0
 * @since 4/13/2016
 */
interface ListingServiceInterface
{
    //public function getListing($listingId);

    public function getListings(array $data);

    //public function getListingDetails($userId, $listingId);
}
