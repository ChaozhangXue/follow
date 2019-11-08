<?php

namespace api\modules\v1\controllers;

use api\models\SamplePrice;
use api\models\Userinfo;
use Yii;
use api\controllers\BaseController;

class SamplePriceController extends BaseController
{
    public $modelClass = 'api\models\SamplePrice';

    public function actions()
    {
        $actions = parent::actions();
        // 禁用""index,delete" 和 "create" 操作
        unset($actions['update']);
        return $actions;
    }

    public function actionUpdate(){
        $client_id = Yii::$app->request->post('sample_id');
        $post = Yii::$app->request->post();

        $client_price = SamplePrice::find()->where(['sample_id' => $client_id])->one();
        if(empty($client_price)){
            //新增
            $price = new SamplePrice();
        }else{
            //更新
            $price = $client_price;
        }

        foreach ($post as $key =>$val){
            $price->$key = $val;
        }
        $price->save();

        return $this->success();
    }
}
