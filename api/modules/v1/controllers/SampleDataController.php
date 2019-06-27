<?php

namespace api\modules\v1\controllers;

use api\models\Sample;
use api\models\SampleData;
use Yii;
use api\controllers\BaseController;

class SampleDataController extends BaseController
{
    public $modelClass = 'api\models\SampleData';

    public function actionStatistic()
    {
        $date = Yii::$app->request->get('date');//2019-01-01
        $need_timestamp = strtotime($date);//2019-01-01
        $model = new SampleData();
        $data = $model::find()->where(['data_date' => $date])->one();
        if (!empty($data)) {
            return $data;
        }
        $return = $this->getData($date);
        $today = date('Y-m-d');
        $today_timestamp = strtotime($today);//2019-01-01

        if ($need_timestamp < $today_timestamp) {
//            比当前小的话 则保存到数据库
            foreach ($return as $key => $val) {
                $model->$key = $val;
            }

            $model->save();
        }

        return $return;
    }

    public function getData($date){
        $param = [
            'today_add_sample' => 0,
            'monthly_add_sample' => 0,
            'total_add_sample' => 0,
            'new_sample' => 0,
            'old_sample' => 0,
            'sample_10' => 0,
            'sample_30' => 0,
            'sample_50' => 0,
            'sample_70' => 0,
            'wenxing' => 0,
            'haoding' => 0,
            'yizhiming' => 0,
            'data_date' => $date,
        ];

        //统计新增样品
        $today_client_data = Sample::find()->where("make_time like '$date%'")->all();
        $param['today_add_sample'] = count($today_client_data);
        $date_ary = explode('-', $date);
        $now_month = $date_ary[0] . '-' . $date_ary[1];
        $param['monthly_add_sample'] = Sample::find()->where("make_time like '$now_month%'")->count();
        $param['total_add_sample'] = Sample::find()->count();;

        //统计新老样品  新的表示 30天内的算新    超过30天的算老


        //统计样品价格  统计线上价格


        //统计样品类型

        return $param;
    }
}
