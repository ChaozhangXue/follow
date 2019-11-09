<?php

namespace api\modules\v1\controllers;

use api\models\Client;
use api\models\Userinfo;
use Yii;
use api\controllers\BaseController;

class ClientController extends BaseController
{
    public $modelClass = 'api\models\Client';

    /**
     * 获取最近的15天的新增用户
     */
    public function actionGetLatest()
    {
        $today = date("Y-m");
        $client_data = Client::find()
            ->where("make_time like '$today%'")
            ->orderBy('id desc')
            ->limit(15)
            ->asArray()
            ->all();
        $this->success($client_data);
    }
}
