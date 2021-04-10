<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\FestivityRequest;
use App\Http\Resources\FestivityResource;
use App\Models\Festivity;
use Illuminate\Http\Request;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class FestivitiesController extends Controller
{
    use DisableAuthorization;

    protected $model = Festivity::class;
    protected $request = FestivityRequest::class;
    protected $resource  = FestivityResource::class;

    /**
     * The name of the field used to fetch a resource from the database.
     *
     * @return string
     */
    protected function keyName(): string
    {
        return 'uuid';
    }

    /**
    * The attributes that are used for filtering.
    *
    * @return array
    */
    protected function filterableBy() : array
    {
        return ['name', 'place', 'start', 'end'];
    }

    /**
     * The attributes that are used for searching.
     *
     * @return array
     */
    protected function searchableBy() : array
    {
        return ['name', 'place'];
    }

    /**
     * The attributes that are used for sorting.
     *
     * @return array
     */
    protected function sortableBy() : array
    {
        return ['name', 'place'];
    }

    /**
     * The list of available query scopes.
     *
     * @return array
     */
    protected function exposedScopes() : array
    {
        return ['whereBetween'];
    }

    public function searchIndexed(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255'
        ]);
        $defaultPaginate = config('festivities.default_paginate', 15);
        $festivitiesCollection = Festivity::search($request->value)->paginate($defaultPaginate);
        return FestivityResource::collection($festivitiesCollection);
    }
}
