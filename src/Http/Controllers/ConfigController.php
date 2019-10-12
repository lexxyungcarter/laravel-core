<?php

namespace AceLords\Core\Http\Controllers;

use AceLords\Core\Models\Configuration;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * return all app settings
     */
    public function settings()
    {
        $settings = Configuration::select(['name', 'value'])->get()
            ->map(function($item) {
                return [
                    'name' => str_replace('::', '.', $item->name),
                    'value' => $item->value,
                ];
            });
        
        return response()->json(['settings' => $settings]);
    }
}
