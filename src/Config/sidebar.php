<?php

/*
|--------------------------------------------------------------------------
| Auth Dashboard
|--------------------------------------------------------------------------
|
| You should replace the Generator class with a custom one as per the project.
| All sidebars should implement 
| AceLords\Core\Library\Contracts\SidebarsInterface;
|
*/

use AceLords\Core\Library\Sidebars\SidebarGenerator;

return [
    'sudo' => SidebarGenerator::forSudo(),

    'general' => array_merge(
        /*
        |--------------------------------------------------------------------------
        | Admin|Superadmin Dashboard
        |--------------------------------------------------------------------------
        |
        | This option controls the sidebar items admins should see.
        | The role is normally named as 'admin'
        |
        */
        SidebarGenerator::forAdmin(),

    
        /*
        |--------------------------------------------------------------------------
        | client Dashboard
        |--------------------------------------------------------------------------
        |
        | This option controls the sidebar items clients should see.
        | The role is normally named as 'client'
        |
        */
        SidebarGenerator::forClient()
    
    )


];
