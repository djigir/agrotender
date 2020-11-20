<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/_debugbar/open' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.openhandler',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/assets/stylesheets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.assets.css',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_debugbar/assets/javascript' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.assets.js',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/home' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::OrB7bOhJAL7SxQxZ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mx75DehAsqobig6W',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/reset' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password/confirm' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Aqqv6f8lnKgAsqCG',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders_sell' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wQ79R1onpZOBXq1J',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders/tport_producers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.generated::UUCQkzsDdyEELJEW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders/tport_export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.generated::0iyA3vPkEAPRFi9F',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders/tport_export/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.generated::5Pw5AhWQaNDt7NdI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders/tport_producers/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.generated::8YDNYzPSYXfxYc9q',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders/tport_tradecomps' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.generated::aDeL79SgdacfQRlj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traders/tport_tradecomps/index' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.generated::GHCS0Wu8ODepAEHz',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/kompanii' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.companies',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/company' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.company',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/contacts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.contacts',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/notify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.notify',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/reviews' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.reviews',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/news' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.news',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/vacancy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.vacancy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/create_company' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.create_company',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/change_pass' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.change_pass',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/new_login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.new_login',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/toggle_visible' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.toggle_visible',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/action_news' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.action_news',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/edit_news' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.edit_news',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/print_news' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.print_news',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/action_vacancy' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.profile.action_vacancy',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/posts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.advert.advert',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/posts/limits' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.advert.limit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/posts/upgrade' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.advert.upgrade',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/balance/pay' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.tariff.pay',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/balance/history' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.tariff.history',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/balance/docs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.tariff.docs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/u/proposeds' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'user.application',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/_debugbar/(?|c(?|lockwork/([^/]++)(*:42)|ache/([^/]++)(?:/([^/]++))?(*:76))|telescope/([^/]++)(*:102))|/password/reset/([^/]++)(*:135)|/traders(?|/(?|region_([^/]++)(?|(*:176)|/([^/]++)(*:193))|tport_([^/]++)(?|(*:219)|/([^/]++)(*:236)))|_(?|forwards/(?|region_([^/]++)(?|(*:280)|/([^/]++)(*:297))|tport_([^/]++)(?|(*:323)|/([^/]++)(*:340)))|sell/(?|region_([^/]++)(?|(*:376)|/([^/]++)(*:393))|tport_([^/]++)(?|(*:419)|/([^/]++)(*:436)))))|/kompanii/(?|region_([^/]++)(?|(*:479)|/t([^/]++)(*:497))|s/([^/]++)(*:516)|c(?|omp\\-(?|([^/\\-]++)\\-(?|prices(*:557)|cont(*:569)|reviews(*:584)|forwards(*:600)|traderContacts(*:622))|([^/]++)(*:639))|reate_review/([^/]++)(*:669))))/?$}sDu',
    ),
    3 => 
    array (
      42 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.clockwork',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      76 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.cache.delete',
            'tags' => NULL,
          ),
          1 => 
          array (
            0 => 'key',
            1 => 'tags',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      102 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'debugbar.telescope',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      135 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      176 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.region',
          ),
          1 => 
          array (
            0 => 'region',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      193 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.region_culture',
          ),
          1 => 
          array (
            0 => 'region',
            1 => 'culture',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      219 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.port',
          ),
          1 => 
          array (
            0 => 'port_name',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      236 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders.port_culture',
          ),
          1 => 
          array (
            0 => 'port',
            1 => 'culture',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      280 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_forward.region',
          ),
          1 => 
          array (
            0 => 'region',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      297 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_forward.region_culture',
          ),
          1 => 
          array (
            0 => 'region',
            1 => 'culture',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      323 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_forward.port',
          ),
          1 => 
          array (
            0 => 'port',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      340 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_forward.port_culture',
          ),
          1 => 
          array (
            0 => 'port',
            1 => 'culture',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      376 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_sell.region',
          ),
          1 => 
          array (
            0 => 'region',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      393 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_sell.region_culture',
          ),
          1 => 
          array (
            0 => 'region',
            1 => 'culture',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      419 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_sell.port',
          ),
          1 => 
          array (
            0 => 'port',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      436 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traders_sell.port_culture',
          ),
          1 => 
          array (
            0 => 'port',
            1 => 'culture',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      479 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.region',
          ),
          1 => 
          array (
            0 => 'region',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      497 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.region_culture',
          ),
          1 => 
          array (
            0 => 'region',
            1 => 'rubric_number',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      516 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.filter',
          ),
          1 => 
          array (
            0 => 'query',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      557 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.prices',
          ),
          1 => 
          array (
            0 => 'id_company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      569 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.cont',
          ),
          1 => 
          array (
            0 => 'id_company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      584 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.reviews',
          ),
          1 => 
          array (
            0 => 'id_company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      600 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.forwards',
          ),
          1 => 
          array (
            0 => 'id_company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      622 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.trader_contacts',
          ),
          1 => 
          array (
            0 => 'id_company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      639 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.index',
          ),
          1 => 
          array (
            0 => 'id_company',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      669 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'company.create_review',
          ),
          1 => 
          array (
            0 => 'id_company',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'debugbar.openhandler' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/open',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@handle',
        'as' => 'debugbar.openhandler',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@handle',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.clockwork' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/clockwork/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@clockwork',
        'as' => 'debugbar.clockwork',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\OpenHandlerController@clockwork',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.telescope' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/telescope/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\TelescopeController@show',
        'as' => 'debugbar.telescope',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\TelescopeController@show',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.assets.css' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/assets/stylesheets',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@css',
        'as' => 'debugbar.assets.css',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@css',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.assets.js' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_debugbar/assets/javascript',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@js',
        'as' => 'debugbar.assets.js',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\AssetController@js',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'debugbar.cache.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => '_debugbar/cache/{key}/{tags?}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'Barryvdh\\Debugbar\\Middleware\\DebugbarEnabled',
        ),
        'uses' => 'Barryvdh\\Debugbar\\Controllers\\CacheController@delete',
        'as' => 'debugbar.cache.delete',
        'controller' => 'Barryvdh\\Debugbar\\Controllers\\CacheController@delete',
        'namespace' => 'Barryvdh\\Debugbar\\Controllers',
        'prefix' => '_debugbar',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'home',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@showLoginForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::OrB7bOhJAL7SxQxZ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@login',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'generated::OrB7bOhJAL7SxQxZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'controller' => 'App\\Http\\Controllers\\Auth\\LoginController@logout',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisterController@showRegistrationForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisterController@showRegistrationForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::mx75DehAsqobig6W' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisterController@register',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisterController@register',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'generated::mx75DehAsqobig6W',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@showLinkRequestForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'controller' => 'App\\Http\\Controllers\\Auth\\ForgotPasswordController@sendResetLinkEmail',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/reset/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@showResetForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'controller' => 'App\\Http\\Controllers\\Auth\\ResetPasswordController@reset',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'password.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'password/confirm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@showConfirmForm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@showConfirmForm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'password.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::Aqqv6f8lnKgAsqCG' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'password/confirm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@confirm',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmPasswordController@confirm',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'generated::Aqqv6f8lnKgAsqCG',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'generated::wQ79R1onpZOBXq1J' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders_sell',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => NULL,
        'where' => 
        array (
        ),
        'as' => 'generated::wQ79R1onpZOBXq1J',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders_sell/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'as' => 'traders.',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.generated::UUCQkzsDdyEELJEW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders/tport_producers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'as' => 'traders.generated::UUCQkzsDdyEELJEW',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.generated::0iyA3vPkEAPRFi9F' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders/tport_export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'as' => 'traders.generated::0iyA3vPkEAPRFi9F',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.generated::5Pw5AhWQaNDt7NdI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders/tport_export/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'as' => 'traders.generated::5Pw5AhWQaNDt7NdI',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.generated::8YDNYzPSYXfxYc9q' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders/tport_producers/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'as' => 'traders.generated::8YDNYzPSYXfxYc9q',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.generated::aDeL79SgdacfQRlj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders/tport_tradecomps',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'as' => 'traders.generated::aDeL79SgdacfQRlj',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.generated::GHCS0Wu8ODepAEHz' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'traders/tport_tradecomps/index',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\RedirectController@__invoke',
        'controller' => '\\Illuminate\\Routing\\RedirectController',
        'as' => 'traders.generated::GHCS0Wu8ODepAEHz',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'destination' => '/traders/region_ukraine',
        'status' => 301,
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.region' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders/region_{region}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@index',
        'controller' => 'App\\Http\\Controllers\\TraderController@index',
        'as' => 'traders.region',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.region_culture' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders/region_{region}/{culture}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@regionCulture',
        'controller' => 'App\\Http\\Controllers\\TraderController@regionCulture',
        'as' => 'traders.region_culture',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.port' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders/tport_{port_name}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@port',
        'controller' => 'App\\Http\\Controllers\\TraderController@port',
        'as' => 'traders.port',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders.port_culture' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders/tport_{port}/{culture}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@portCulture',
        'controller' => 'App\\Http\\Controllers\\TraderController@portCulture',
        'as' => 'traders.port_culture',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_forward.region' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_forwards/region_{region}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@forwardsRegion',
        'controller' => 'App\\Http\\Controllers\\TraderController@forwardsRegion',
        'as' => 'traders_forward.region',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_forwards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_forward.region_culture' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_forwards/region_{region}/{culture}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@forwardsRegionCulture',
        'controller' => 'App\\Http\\Controllers\\TraderController@forwardsRegionCulture',
        'as' => 'traders_forward.region_culture',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_forwards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_forward.port' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_forwards/tport_{port}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@forwardsPort',
        'controller' => 'App\\Http\\Controllers\\TraderController@forwardsPort',
        'as' => 'traders_forward.port',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_forwards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_forward.port_culture' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_forwards/tport_{port}/{culture}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@forwardsPortCulture',
        'controller' => 'App\\Http\\Controllers\\TraderController@forwardsPortCulture',
        'as' => 'traders_forward.port_culture',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_forwards',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_sell.region' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_sell/region_{region}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@sellRegion',
        'controller' => 'App\\Http\\Controllers\\TraderController@sellRegion',
        'as' => 'traders_sell.region',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_sell',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_sell.region_culture' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_sell/region_{region}/{culture}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@sellRegionCulture',
        'controller' => 'App\\Http\\Controllers\\TraderController@sellRegionCulture',
        'as' => 'traders_sell.region_culture',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_sell',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_sell.port' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_sell/tport_{port}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@sellPort',
        'controller' => 'App\\Http\\Controllers\\TraderController@sellPort',
        'as' => 'traders_sell.port',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_sell',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'traders_sell.port_culture' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traders_sell/tport_{port}/{culture}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TraderController@sellPortCulture',
        'controller' => 'App\\Http\\Controllers\\TraderController@sellPortCulture',
        'as' => 'traders_sell.port_culture',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/traders_sell',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.companies' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companies',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companies',
        'as' => 'company.companies',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.region' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/region_{region}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companiesRegion',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companiesRegion',
        'as' => 'company.region',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.filter' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/s/{query}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companiesFilter',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companiesFilter',
        'as' => 'company.filter',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.region_culture' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/region_{region}/t{rubric_number}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companiesRegionRubric',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companiesRegionRubric',
        'as' => 'company.region_culture',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.prices' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/comp-{id_company}-prices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companyPrices',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companyPrices',
        'as' => 'company.prices',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.cont' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/comp-{id_company}-cont',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companyContact',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companyContact',
        'as' => 'company.cont',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.reviews' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/comp-{id_company}-reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companyReviews',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companyReviews',
        'as' => 'company.reviews',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.forwards' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/comp-{id_company}-forwards',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@companyForwards',
        'controller' => 'App\\Http\\Controllers\\CompanyController@companyForwards',
        'as' => 'company.forwards',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.trader_contacts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/comp-{id_company}-traderContacts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@traderContacts',
        'controller' => 'App\\Http\\Controllers\\CompanyController@traderContacts',
        'as' => 'company.trader_contacts',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kompanii/comp-{id_company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@company',
        'controller' => 'App\\Http\\Controllers\\CompanyController@company',
        'as' => 'company.index',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'company.create_review' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'kompanii/create_review/{id_company}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\CompanyController@createReviews',
        'controller' => 'App\\Http\\Controllers\\CompanyController@createReviews',
        'as' => 'company.create_review',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/kompanii',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.company' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/company',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@profileCompany',
        'controller' => 'App\\Http\\Controllers\\UserController@profileCompany',
        'as' => 'user.profile.company',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@profile',
        'controller' => 'App\\Http\\Controllers\\UserController@profile',
        'as' => 'user.profile.profile',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.contacts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/contacts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@profileContacts',
        'controller' => 'App\\Http\\Controllers\\UserController@profileContacts',
        'as' => 'user.profile.contacts',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.notify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/notify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@profileNotify',
        'controller' => 'App\\Http\\Controllers\\UserController@profileNotify',
        'as' => 'user.profile.notify',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.reviews' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@profileReviews',
        'controller' => 'App\\Http\\Controllers\\UserController@profileReviews',
        'as' => 'user.profile.reviews',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.news' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/news',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@profileNews',
        'controller' => 'App\\Http\\Controllers\\UserController@profileNews',
        'as' => 'user.profile.news',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.vacancy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/vacancy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@profileVacancy',
        'controller' => 'App\\Http\\Controllers\\UserController@profileVacancy',
        'as' => 'user.profile.vacancy',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.create_company' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/create_company',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@createCompanyProfile',
        'controller' => 'App\\Http\\Controllers\\UserController@createCompanyProfile',
        'as' => 'user.profile.create_company',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.change_pass' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/change_pass',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@changePass',
        'controller' => 'App\\Http\\Controllers\\UserController@changePass',
        'as' => 'user.profile.change_pass',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.new_login' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/new_login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@newLogin',
        'controller' => 'App\\Http\\Controllers\\UserController@newLogin',
        'as' => 'user.profile.new_login',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.toggle_visible' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/toggle_visible',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@toggleVisible',
        'controller' => 'App\\Http\\Controllers\\UserController@toggleVisible',
        'as' => 'user.profile.toggle_visible',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.action_news' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/action_news',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@actionNews',
        'controller' => 'App\\Http\\Controllers\\UserController@actionNews',
        'as' => 'user.profile.action_news',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.edit_news' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/edit_news',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@editNews',
        'controller' => 'App\\Http\\Controllers\\UserController@editNews',
        'as' => 'user.profile.edit_news',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.print_news' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/print_news',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@printNews',
        'controller' => 'App\\Http\\Controllers\\UserController@printNews',
        'as' => 'user.profile.print_news',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.profile.action_vacancy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'u/action_vacancy',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'check_auth_user',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@actionVacancy',
        'controller' => 'App\\Http\\Controllers\\UserController@actionVacancy',
        'as' => 'user.profile.action_vacancy',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.advert.advert' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/posts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@advert',
        'controller' => 'App\\Http\\Controllers\\UserController@advert',
        'as' => 'user.advert.advert',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.advert.limit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/posts/limits',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@advertLimit',
        'controller' => 'App\\Http\\Controllers\\UserController@advertLimit',
        'as' => 'user.advert.limit',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.advert.upgrade' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/posts/upgrade',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@advertUpgrade',
        'controller' => 'App\\Http\\Controllers\\UserController@advertUpgrade',
        'as' => 'user.advert.upgrade',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/posts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.tariff.pay' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/balance/pay',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@balancePay',
        'controller' => 'App\\Http\\Controllers\\UserController@balancePay',
        'as' => 'user.tariff.pay',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/balance',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.tariff.history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/balance/history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@balanceHistory',
        'controller' => 'App\\Http\\Controllers\\UserController@balanceHistory',
        'as' => 'user.tariff.history',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/balance',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.tariff.docs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/balance/docs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@balanceDocs',
        'controller' => 'App\\Http\\Controllers\\UserController@balanceDocs',
        'as' => 'user.tariff.docs',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => 'u/balance',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
    'user.application' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'u/proposeds',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\UserController@application',
        'controller' => 'App\\Http\\Controllers\\UserController@application',
        'as' => 'user.application',
        'namespace' => 'App\\Http\\Controllers',
        'prefix' => '/u',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
    ),
  ),
)
);
