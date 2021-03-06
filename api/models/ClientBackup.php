<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "client_backup".
 *
 * @property int $id
 * @property int $client_id 客户id
 * @property string $msg 备注信息
 * @property string $price_date 报价日期
 * @property string $maker_date 建档时间
 * @property string $maker 建档人员
 * @property string $update_time 修改时间
 * @property string $update_people 修改角色
 */
class ClientBackup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_backup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id'], 'integer'],
            [['price_date', 'maker_date', 'update_time'], 'safe'],
            [['msg', 'maker', 'update_people'], 'string', 'max' => 50],
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
            'msg' => '备注信息',
            'price_date' => '报价日期',
            'maker_date' => '建档时间',
            'maker' => '建档人员',
            'update_time' => '修改时间',
            'update_people' => '修改角色',
        ];
    }
}
