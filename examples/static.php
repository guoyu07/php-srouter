<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017/4/28
 * Time: 上午12:00
 *
 * you can test use:
 *  php -S 127.0.0.1:5670 -t examples/static
 *
 * then you can access url: http://127.0.0.1:5670
 */

use Inhere\Route\Dispatcher;
use Inhere\Route\SRouter;

require __DIR__ . '/simple-loader.php';

// set config
SRouter::setConfig([
    'ignoreLastSep' => true,

//    'intercept' => '/', // a route path
//    'intercept' => function () {
//        echo 'System Maintaining ... ...';
//    },

    // enable autoRoute
    // you can access '/demo' '/admin/user/info', Don't need to configure any route
    'autoRoute' =>  1,
    'controllerNamespace' => 'Inhere\Route\Examples\Controllers',
    'controllerSuffix' => 'Controller',
]);

/** @var array $routes */
$routes = require __DIR__ . '/some-routes.php';

foreach ($routes as $route) {
    // group
    if (is_array($route[1])) {
        $rs = $route[1];
        $router->group($route[0], function () use($rs){
            foreach ($rs as $r) {
                SRouter::map($r[0], $r[1], $r[2], isset($r[3]) ? $r[3] : []);
            }
        });

        continue;
    }

    SRouter::map($route[0], $route[1], $route[2], isset($route[3]) ? $route[3] : []);
}

$dispatcher = new Dispatcher([
    'dynamicAction' => true,
]);

// on notFound, output a message.
//$dispatcher->on(Dispatcher::ON_NOT_FOUND, function ($path) {
//    echo "the page $path not found!";
//});

// dispatch
SRouter::dispatch($dispatcher);
