<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'csrfParam' => '_csrf-api',
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        //修改返回值  如果是gii的话 需要注释这一段
//        'response' => [
//            'class' => 'yii\web\Response',
//            'on beforeSend' => function ($event) {
//                $response = $event->sender;
//                $response->data = [
//                    'r' => $response->isSuccessful ?? 1,
//                    'code' => $response->getStatusCode(),
//                    'msg' => $response->statusText,
//                    'data' => $response->data,
//                ];
//                $response->statusCode = 200;
//            },
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' =>true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/goods'],
                    'extraPatterns' => [
                        'POST  search' => 'search',//通过这种方式新加搜索
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/userinfo'],
                    'extraPatterns' => [
                        'POST  search' => 'search',//通过这种方式新加搜索
                        'POST  login' => 'login',
                        'POST  logout' => 'logout',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'v1/client',
                        'v1/client-backup',
                        'v1/client-contact',
                        'v1/client-price',
                        'v1/exhibition',
                        'v1/sample',
                        'v1/sample-price',
                        'v1/suggestion',
                        'v1/process',
                    ],
                    'extraPatterns' => [
                        'POST  search' => 'search',//通过这种方式新加搜索
                    ]
                ],
            ]
        ],
    ],
    'params' => $params,
];
