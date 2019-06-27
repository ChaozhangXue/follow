<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "process".
 *
 * @property int $id 自增长的process id
 * @property string $client_name 客户公司
 * @property int $is_send_sample 是否寄样 1： 否  2 是
 * @property string $send_sample_date 寄样时间
 * @property string $sender_name 寄样人
 * @property string $make_time 建档时间
 */
class Process extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_send_sample'], 'integer'],
            [['send_sample_date', 'make_time'], 'safe'],
            [['client_name', 'sender_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_name' => 'Client Name',
            'is_send_sample' => 'Is Send Sample',
            'send_sample_date' => 'Send Sample Date',
            'sender_name' => 'Sender Name',
            'make_time' => 'Make Time',
        ];
    }
}
