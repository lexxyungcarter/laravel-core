<?php

namespace AceLords\Core\Library\Sidebars;

use AceLords\Core\Library\Contracts\SidebarsInterface;

class AdminSidebar implements SidebarsInterface
{
    
    /**
     * return sidebar entries
     *
     * @return mixed
     */
    public function data(): array
    {
        $entries = collect([
            [
                'name' => 'Dashboard',
                'icon' => 'home',
                'route' => 'home',
                'page' => 'dashboard',
                'span' => '',
                'class' => '',
                'role' => ['admin', 'superadmin'],
                'vue_router' => false,
                'component' => '',
                'order' => 1,
            ],
            
        ]);
    
        return $entries->toArray();
    }
}
