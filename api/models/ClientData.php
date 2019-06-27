<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "client_data".
 *
 * @property int $id
 * @property int $today_add 今日新增客户数
 * @property int $monthly_add 本月新增客户数
 * @property int $totally_add 累计新增客户数
 * @property int $exhibition_count 展会客户
 * @property int $online_count 线上客户
 * @property int $introduce_count 转介绍
 * @property int $clothing_count 服装厂
 * @property int $pifa_count 批发商
 * @property int $daili_count 代理商
 * @property int $lingshou_count 零售商
 * @property int $new_client 新客户数
 * @property int $old_client 老客户数
 * @property int $new_client_percentage 新客户占比
 * @property int $old_client_percentage 老客户占比
 * @property int $offline_percentage 线下占比
 * @property int $online_percentage 线上占比
 * @property string $from_percentage 客户来源城市占比
 * @property string $country_client_info_percentage 每个城市的老板比例，高意向比例等信息
 * @property string $data_date 数据日期
 */
class ClientData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['today_add', 'monthly_add', 'totally_add', 'exhibition_count', 'online_count', 'introduce_count', 'clothing_count', 'pifa_count', 'daili_count', 'lingshou_count', 'new_client', 'old_client', 'new_client_percentage', 'old_client_percentage', 'offline_percentage', 'online_percentage'], 'integer'],
            [['from_percentage', 'country_client_info_percentage', 'data_date'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'today_add' => 'Today Add',
            'monthly_add' => 'Monthly Add',
            'totally_add' => 'Totally Add',
            'exhibition_count' => 'Exhibition Count',
            'online_count' => 'Online Count',
            'introduce_count' => 'Introduce Count',
            'clothing_count' => 'Clothing Count',
            'pifa_count' => 'Pifa Count',
            'daili_count' => 'Daili Count',
            'lingshou_count' => 'Lingshou Count',
            'new_client' => 'New Client',
            'old_client' => 'Old Client',
            'new_client_percentage' => 'New Client Percentage',
            'old_client_percentage' => 'Old Client Percentage',
            'offline_percentage' => 'Offline Percentage',
            'online_percentage' => 'Online Percentage',
            'from_percentage' => 'From Percentage',
            'country_client_info_percentage' => 'Country Client Info Percentage',
            'data_date' => 'Data Date',
        ];
    }
}
