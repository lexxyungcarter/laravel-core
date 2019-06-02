<?php

namespace AceLords\Core\Library\RedisConfigurations;

use AceLords\Yuvo\Library\Contracts\RedisInterface;

class Models extends RedisTemplate implements RedisInterface
{

    /*
     * Set the keys as they are to be returned to redis
     */
    public function setKeys()
    {
        $this->keys = config('acelords_redis_autoload.models');
    }

    /*
     * Returns selects data to the repository for redis storage
     */
    public function data($key = null)
    {
        if(class_exists($key))
        {
            $model = new $key();
            $dbName = $model->getTable();
            $data = $model->get();

            return [
                'key' => $dbName,
                'data' => $data,
            ];
        }

        return collect();
    }

}