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
//        //修改返回值  如果是gii的话 需要注释这一段
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if (is_string($response->data)) { //gii的是string  正常是数组
                    return;
                } else {
                    if(isset($response->data[0]['message'])){
                        if($response->data[0]['message'] == '样品的id cannot be blank.'){
                            $msg = '请先填写样品的基本信息';
                        }else{
                            if($response->data[0]['message'] == '客户id cannot be blank.'){
                                $msg = '请先填写客户的基本信息';
                            }else{
                                $msg = $response->data[0]['message'];
                            }
                        }
                    }else{
                        $msg = $response->statusText;
                    }

                    $response->data = [
                        'r' => ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) ? 0 : 1,
                        'code' => $response->getStatusCode(),
                        'msg' => $msg,
                        'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            },
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' =>true,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['v1/userinfo'],
                    'extraPatterns' => [
                        'POST  search' => 'search',//通过这种方式新加搜索
                        'POST  login' => 'login',
                        'POST  logout' => 'logout',
                        'PUT  reset-password/<id>' => 'reset-password',
                        'GET  select/<column>' => 'select',
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
                        'v1/process-follow',
                    ],
                    'extraPatterns' => [
                        'POST  get-latest' => 'get-latest',//获取最近的新增用户
                        'POST  search' => 'search',//通过这种方式新加搜索
                        'POST  search-like' => 'search-like',//模糊查询
                        'GET  select/<column>' => 'select',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => [
                        'v1/client-data',
                        'v1/sample-data',
                    ],
                    'extraPatterns' => [
                        'GET  statistic/<date>' => 'statistic',//通过这种方式新加搜索
                    ]
                ],

            ]
        ],
    ],
    'params' => $params,
];
