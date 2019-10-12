<?php

namespace  AceLords\Core\Http\Controllers;

use Illuminate\Routing\Controller;

class RedisController extends Controller
{
    protected $repo;

    /*
     * Initialise class
     */
    public function __construct()
    {
        $this->repo = redis();
    }

    /*
     * Display a listing of the resource.
     */
    public function fetch()
    {
        $items = request()->except(['page']);

        $collection = array();

        foreach($items as $item)
        {
            $collection[camel_case($item)] = $this->repo->get(snake_case(camel_case($item)));
        }

        return response()->json($collection);
    }

}
