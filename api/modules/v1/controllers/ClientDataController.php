<?php

namespace api\modules\v1\controllers;

use api\models\Client;
use api\models\ClientData;
use api\models\ClientPrice;
use api\models\Userinfo;
use Yii;
use api\controllers\BaseController;

class ClientDataController extends BaseController
{
    public $modelClass = 'api\models\ClientData';

    public function actionStatistic()
    {
        $date = Yii::$app->request->get('date');//2019-01-01
        $need_timestamp = strtotime($date);//2019-01-01
        $model = new ClientData();
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

    public function getData($date)
    {
        $param = [
            'today_add' => 0,
            'monthly_add' => 0,
            'totally_add' => 0,
            'exhibition_count' => 0,
            'online_count' => 0,
            'introduce_count' => 0,
            'clothing_count' => 0,
            'pifa_count' => 0,
            'daili_count' => 0,
            'lingshou_count' => 0,
//            'client_follow_count' => 0,
            'new_client' => 0,
            'old_client' => 0,
            'new_client_percentage' => 0,
            'old_client_percentage' => 0,
            'offline_percentage' => 0,
            'online_percentage' => 0,
            'from_percentage' => [],
            'country_client_info_percentage' => [],
            'data_date' => $date,
        ];


        $today_client_data = Client::find()->where("make_time like '$date%'")->all();
        $param['today_add'] = count($today_client_data);
        $date_ary = explode('-', $date);
        $now_month = $date_ary[0] . '-' . $date_ary[1];
        $param['monthly_add'] = Client::find()->where("make_time like '$now_month%'")->count();
        $param['totally_add'] = Client::find()->count();
        $client_price = ClientPrice::find()->select(['id'])->asArray()->all();
        $has_client_price = array_column($client_price, 'id');

        foreach ($today_client_data as $val) {
            switch ($val['source']) {
//            客户来源 1：展会 2线上 3客户介绍
                case 0:
                    $param['exhibition_count']++;
                    break;
                case 1:
                    $param['online_count']++;
                    break;
                case 2:
                    $param['introduce_count']++;
                    break;
            }

            switch ($val['nature']) {
//            公司性质(1.服装厂 2.批发商 3代理商 4零售商)
                case 0:
                    $param['clothing_count']++;
                    break;
                case 1:
                    $param['pifa_count']++;
                    break;
                case 2:
                    $param['daili_count']++;
                    break;
                case 3:
                    $param['lingshou_count']++;
                    break;
            }

            switch ($val['type']) {
//                客户类型 1：新客户 2：老客户
                case 1:
                    $param['new_client']++;
                    break;
                case 0:
                    $param['old_client']++;
                    break;
            }

            //统计城市
            if (isset($param['from_percentage'][$val['province']])) {
                $param['from_percentage'][$val['province']]['count']++;
                if (($val['intention'] == 3)) {
                    $param['from_percentage'][$val['province']]['high_intention']++;
                }
                if ((in_array($val['id'], $has_client_price))) {
                    $param['from_percentage'][$val['province']]['has_price']++;
                }
                if (stripos($val['called'], "老板") !== false) {
                    $param['from_percentage'][$val['province']]['is_boss']++;
                }
            } else {
                $param['from_percentage'][$val['province']] = [
                    'count' => 1,
                    'high_intention' => ($val['intention'] == 3) ? 1 : 0,
                    'has_price' => (in_array($val['id'], $has_client_price)) ? 1 : 0,
                    'is_boss' => stripos($val['called'], "老板") ? 1 : 0,
                ];
            }
        }

        $param['new_client_percentage'] = $this->getPercentage($param['new_client'],($param['new_client'] + $param['old_client']));
        $param['old_client_percentage'] = $this->getPercentage($param['old_client'],($param['new_client'] + $param['old_client']));
        $param['online_percentage'] = $this->getPercentage($param['online_count'],($param['exhibition_count'] + $param['introduce_count'] + $param['online_count']));
        $param['offline_percentage'] = $this->getPercentage(($param['exhibition_count'] + $param['introduce_count']),($param['exhibition_count'] + $param['introduce_count'] + $param['online_count']));

        $final_from = [];
        $final_info = [];
        $others_info = [];
        if (!empty($param['from_percentage'])) {
            array_multisort($param['from_percentage'], SORT_DESC);

            $i = 0;
            foreach ($param['from_percentage'] as $key => $val) {
                if ($i < 4) {
                    $final_from[$i] = [
                        'country' => $key,
                        'count' => $val['count'],
                    ];

                    $final_info[$i] = [
                        'country' => $key,
                        'high_intention_per' => $this->getPercentage($val['high_intention'], $val['count']),
                        'has_price_per' =>  $this->getPercentage($val['has_price'], $val['count']),
                        'is_boss_per' => $this->getPercentage($val['is_boss'], $val['count']),
                    ];
                } elseif ($i == 4) {
                    $final_from[4] = [
                        'country' => '其他',
                        'count' => $val['count'],
                    ];

                    $others_info =  [
                        'country' => '其他',
                        'high_intention' => $val['high_intention'],
                        'has_price' =>  $val['has_price'],
                        'is_boss' =>  $val['is_boss'],
                        'count' =>  $val['count'],
                    ];
                } elseif ($i > 4) {
                    $final_from[4]['count'] = $final_from[4]['count'] + $val['count'];

                    $others_info['high_intention'] = $others_info['high_intention'] + $val['high_intention'];
                    $others_info['has_price'] = $others_info['has_price'] + $val['has_price'];
                    $others_info['is_boss'] = $others_info['is_boss'] + $val['is_boss'];
                    $others_info['count'] = $others_info['count'] + $val['count'];
                }
                $i++;
            }
            $final_info[4] = [
                'country' => '其他',
                'high_intention_per' => $this->getPercentage($others_info['high_intention'], $others_info['count']),
                'has_price_per' =>  $this->getPercentage($others_info['has_price'], $others_info['count']),
                'is_boss_per' => $this->getPercentage($others_info['is_boss'], $others_info['count']),
            ];

        }

        $param['from_percentage'] = json_encode($final_from);
        $param['country_client_info_percentage'] = json_encode($final_info);

        return $param;
    }

    public function getPercentage($child, $parent){
        if($parent == 0){
            return "0%";
        }
        return number_format($child/$parent * 100, 2)  . '%';
    }

}
