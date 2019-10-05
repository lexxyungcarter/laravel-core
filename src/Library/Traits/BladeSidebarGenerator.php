<?php
/**
 * Created by PhpStorm.
 * User: lexxyungcarter
 * Date: 2019-04-18
 * Time: 12:28
 */

namespace AceLords\Core\Library\Traits;

trait BladeSidebarGenerator
{
    public function generateSidebar($user)
    {
        $sidebar = redis()->get('sidebar')->filter(function($item) use ($user) {
                if($user->can($item['permissions']))
                    return $item;
            })
            ->sortBy('order')
            ->toJson();
        
        return <<<EOT
<script type="text/javascript">
    var AceLordsSidebar = {
        routes: $sidebar
    };
</script>
EOT;
    }
}
