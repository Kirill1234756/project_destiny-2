<?php
use FastRoute\RouteCollector;

$router->addGroup('/admin', function (RouteCollector $r) {
    $r->addGroup('/city', function (RouteCollector $r) {
        $r->addRoute(['GET', 'POST'], '/add', function () {
            include __DIR__ . '/admin/city_add.php';
        });
        $r->addRoute(['GET', 'POST'], '/{id}/edit', function () {
            include __DIR__ . '/admin/city_edit.php';
        });
        $r->addRoute(['GET', 'POST'], '/{id}/delete', function () {
            include __DIR__ . '/admin/city_del.php';
        });
    });

    $r->addRoute(['GET', 'POST'], '/', function () {
        include __DIR__ . '/admin/admin.php';
    });
});

$router->addRoute(['GET'], '/404', function () {
    include __DIR__ . '/views/404.php';
});

$router->addRoute(['GET'], '/', function () {
    include __DIR__ . '/views/index.php';
});