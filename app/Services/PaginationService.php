<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;

class PaginationService
{
    public static function makePaginator($datas, $perPage = 10, $request)
    {
        //Get current page form url e.g. &page=6
        $currentPage = Paginator::resolveCurrentPage();

        //Create a new Laravel collection from the array data
        $collection = new Collection($datas);

        //Slice the collection to get the items to display in current page
        $currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        //Create our paginator and pass it to the view
        $paginatedSearchResults = new Paginator($currentPageSearchResults, count($collection), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return $paginatedSearchResults;
    }
}
