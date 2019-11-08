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
 * @property string $rmb 报价
 * @property string $usd 报价备注
 * @property string $price_date 报价日期
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
            [['client_id'], 'required'],
            [['client_id'], 'integer'],
            [['pic'], 'string'],
            [['price_date'], 'safe'],
            [['title', 'rmb', 'usd'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => '客户id',
            'title' => '商品款号',
            'pic' => '商品图片',
            'rmb' => '报价',
            'usd' => '报价备注',
            'price_date' => '报价日期',
        ];
    }
}
