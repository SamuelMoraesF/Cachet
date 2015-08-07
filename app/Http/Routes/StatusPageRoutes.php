<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Http\Routes;

use Illuminate\Contracts\Routing\Registrar;

/**
 * This is the statsu page routes class.
 *
 * @author James Brooks <james@alt-three.com>
 */
class StatusPageRoutes
{
    /**
     * Define the status page routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     */
    public function map(Registrar $router)
    {
        // Prevent access until the app is setup.
        $router->group(['middleware' => 'app.hasSetting', 'setting' => 'app_name'], function ($router) {
            $router->get('/', [
                'as'   => 'status-page',
                'uses' => 'HomeController@showIndex',
            ]);
        });
    }
}
