<?php

namespace api\modules\v1\controllers;

use api\models\Client;
use api\models\Process;
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
        $page_size = Yii;
        $page = Yii::$app->request->post('page');
        $per_page = Yii::$app->request->post('per-page');

        $today = date("Y-m");
        $client_data = Client::find()->where("make_time like '$today%'")->orderBy('id desc')
            ->limit($page_size)->asArray()->all();
        $count = count($client_data);
        return ['items' => $client_data, '_meta' => ['totalCount' => $count, 'pageCount' => floor($count / $page_size), 'currentPage' => 1, 'per-page' => $page_size]];
    }

    /**
     * 分配记录
     * @return array
     */
    public function actionDistribute()
    {
        $follow_id = Yii::$app->request->post('follower_id');
        $follow_name = Yii::$app->request->post('follower_name');
        $client_id = Yii::$app->request->post('client_id');
//        $client_name = Yii::$app->request->post('client_name');

        $client = Client::find()->where(['id'=>$client_id])->one();
        if(empty($client)){
            return $this->error('客户不存在');
        }
        $client->follower_name = $follow_name;
        $client->follower_id = $follow_id;
        $client->save();

        $process = Process::find()->where(['client_id'=> $client_id])->one();
        if(empty($process)){
            $process = new Process();
            $process->client_name = $client->company_name;
            $process->client_id = $client_id;
        }
        $process->follow_id = $follow_id;
        $process->follow_name = $follow_name;
        $process->save();
        return $this->success();
    }
}
