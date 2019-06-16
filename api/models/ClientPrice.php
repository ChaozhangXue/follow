<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "client_price".
 *
 * @property int $id
 * @property int $client_id 客户id
 * @property string $title 商品款号
 * @property string $pic 商品图片
 * @property string $rmb rmb
 * @property string $usd usd
 * @property string $price_date 报价日期
 * @property string $backup 备注信息
 * @property int $packaged 是否包装
 * @property int $is_tax 是否含税
 * @property int $is_logistics 是否物流
 */
class ClientPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'packaged', 'is_tax', 'is_logistics'], 'integer'],
            [['price_date'], 'safe'],
            [['title', 'pic', 'rmb', 'usd', 'backup'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'title' => 'Title',
            'pic' => 'Pic',
            'rmb' => 'Rmb',
            'usd' => 'Usd',
            'price_date' => 'Price Date',
            'backup' => 'Backup',
            'packaged' => 'Packaged',
            'is_tax' => 'Is Tax',
            'is_logistics' => 'Is Logistics',
        ];
    }
}
