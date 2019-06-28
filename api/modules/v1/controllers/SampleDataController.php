<?php

namespace api\modules\v1\controllers;

use api\models\Sample;
use api\models\SampleData;
use api\models\SamplePrice;
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
        $today_client_data = Sample::find()->where("created_at like '$date%'")->all();
        $param['today_add_sample'] = count($today_client_data);
        $date_ary = explode('-', $date);
        $now_month = $date_ary[0] . '-' . $date_ary[1];
        $param['monthly_add_sample'] = Sample::find()->where("created_at like '$now_month%'")->count();
        $param['total_add_sample'] = Sample::find()->count();;

        //统计新老样品  新的表示 30天内的算新    超过30天的算老
        $early_30  = date('Ymd', strtotime('-1 month'));
        $param['new_sample'] = Sample::find()->where(['>','created_at', $early_30])->count();
        $param['old_sample'] = $param['total_add_sample'] - $param['new_sample'];

        //统计样品价格  统计线上价格
        $sample_price = SamplePrice::find()->asArray()->all();
        foreach ($sample_price as $val){
            $price = $val['online_price'];
            switch ($price){
                case (0 < $price && $price <= 10):
                    $param['sample_10']++;
                    break;
                case (10 < $price && $price <= 30):
                    $param['sample_30']++;
                    break;
                case (30 < $price && $price <= 50):
                    $param['sample_50']++;
                    break;
                case (50 < $price && $price <= 70):
                    $param['sample_70']++;
                    break;
            }
        }

        //统计样品类型
        $all_sample = Sample::find()->select('xiuhua_suplier')->asArray()->all();
        foreach ($all_sample as $val){
            if(stripos($val['xiuhua_suplier'],"文兴") !== false){
                $param['wenxing']++;
            }

            if(stripos($val['xiuhua_suplier'],"豪鼎") !== false){
                $param['haoding']++;
            }

            if(stripos($val['xiuhua_suplier'],"怡之鸣") !== false){
                $param['yizhiming']++;
            }
        }

        return $param;
    }
}
