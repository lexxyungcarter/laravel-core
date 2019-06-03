<?php

namespace AceLords\Core\Library\Sidebars;


class SidebarGenerator
{
    
    /**
     * return sidebar entries for admin
     *
     * @return array
     */
    public static function forAdmin() : array
    {
        return (new AdminSidebar)->data();
    }
    
    /**
     * return sidebar entries for admin
     *
     * @return array
     */
    public static function forSudo() : array
    {
        return (new SudoSidebar)->data();
    }
    
    /**
     * return sidebar entries for client
     *
     * @return array
     */
    public static function forClient() : array
    {
        return [];
    }
    
}
