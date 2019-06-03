<?php

namespace AceLords\Core\Library\Sidebars;

use AceLords\Core\Library\Contracts\SidebarsInterface;

class SudoSidebar implements SidebarsInterface
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
                'name' => 'Sudo',
                'icon' => 'alternate_email',
                'route' => 'home',
            ],
        ]);
    
        return $entries->toArray();
    }
}
