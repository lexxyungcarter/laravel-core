<?php

namespace AceLords\Core\Library\RedisConfigurations;

use AceLords\Core\Library\Contracts\RedisInterface;

class Sidebar extends RedisTemplate implements RedisInterface
{

    /*
     * Set the keys as they are to be returned to redis
     */
    public function setKeys()
    {
        $this->keys = ['sidebar', 'sudo_sidebar'];
    }

    /*
     * Returns selects data to the repository for redis storage
     */
    public function data($key = null)
    {
        if($key == "sidebar")
        {
            return $this->generalSidebar();
        }

        return $this->sudoSidebar();
    }

    /**
     * get the general entries for sidebar
     *
     * @return \Illuminate\Support\Collection
     */
    protected function generalSidebar()
    {
        $data  = collect();

        $sidebarConfig = config("acelords_sidebar_autoload.general");

        if($sidebarConfig)
        {
            foreach($sidebarConfig as $config)
            {
                $data->push(collect($config)->recursive());
            }
        }

        return $data;
    }

    /**
     * get the sudo sidebar entries
     *
     * @return \Illuminate\Support\Collection
     */
    protected function sudoSidebar()
    {
        $data  = collect();

        $sidebarConfig = config("acelords_sidebar_autoload.sudo");

        if($sidebarConfig)
        {
            foreach($sidebarConfig as $config)
            {
                $data->push(collect($config)->recursive());
            }
        }

        return $data;
    }
}