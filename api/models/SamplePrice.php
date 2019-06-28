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
 * @property double $on_tax_price 含税价格
 * @property double $carriage 含运费价
 * @property string $range_price 区间价格
 * @property string $rmb_backup 人民币的备注信息
 * @property double $USD_price 美元价格
 * @property string $trade 贸易条款
 * @property string $aim 目的港口
 * @property string $CBM cbm
 * @property string $maitou 唛头
 * @property string $usd_backup 美元的备注信息
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
            'id' => 'ID',
            'sample_id' => 'Sample ID',
            'online_price' => 'Online Price',
            'offline_price' => 'Offline Price',
            'cost' => 'Cost',
            'make_price' => 'Make Price',
            'dibu_price' => 'Dibu Price',
            'on_tax_price' => 'On Tax Price',
            'carriage' => 'Carriage',
            'range_price' => 'Range Price',
            'rmb_backup' => 'Rmb Backup',
            'USD_price' => 'Usd Price',
            'trade' => 'Trade',
            'aim' => 'Aim',
            'CBM' => 'Cbm',
            'maitou' => 'Maitou',
            'usd_backup' => 'Usd Backup',
        ];
    }
}
