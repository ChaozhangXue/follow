<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "sample_price".
 *
 * @property int $id 自增长id
 * @property int $sample_id 样品的id
 * @property double $online_price 线上报价
 * @property double $offline_price 线下报价
 * @property double $cost 成本价格
 * @property double $make_price 加工价格
 * @property double $dibu_price 底部价格
 * @property double $on_tax_price 含税含运价格
 * @property double $carriage 调样价格
 * @property string $range_price 打样价格
 * @property string $rmb_backup 人民币的备注信息
 * @property double $USD_price 美元价格
 * @property string $trade  贸易条款
 * @property string $aim 目的港口
 * @property string $CBM 货运信息
 * @property string $maitou 唛头
 * @property string $usd_backup 美元的备注信息
 * @property string $created_at
 * @property string $updated_at
 */
class SamplePrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sample_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sample_id'], 'integer'],
            [['online_price', 'offline_price', 'cost', 'make_price', 'dibu_price', 'on_tax_price', 'carriage', 'USD_price'], 'number'],
            [['rmb_backup', 'usd_backup'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['range_price', 'trade', 'aim', 'CBM', 'maitou'], 'string', 'max' => 50],
            [['sample_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长id',
            'sample_id' => '样品的id',
            'online_price' => '线上报价',
            'offline_price' => '线下报价',
            'cost' => '成本价格',
            'make_price' => '加工价格',
            'dibu_price' => '底部价格',
            'on_tax_price' => '含税含运价格',
            'carriage' => '调样价格',
            'range_price' => '打样价格',
            'rmb_backup' => '人民币的备注信息',
            'USD_price' => '美元价格',
            'trade' => ' 贸易条款',
            'aim' => '目的港口',
            'CBM' => '货运信息',
            'maitou' => '唛头',
            'usd_backup' => '美元的备注信息',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
