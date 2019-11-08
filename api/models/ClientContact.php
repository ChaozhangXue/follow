<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "client_contact".
 *
 * @property int $id 自增id
 * @property int $client_id
 * @property string $email
 * @property string $wechat 微信号
 * @property string $whats_app
 * @property string $facebook
 * @property string $printerest 备注
 * @property string $make_time
 * @property string $maker
 * @property string $update_time
 * @property string $update_people
 */
class ClientContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id'], 'integer'],
            [['client_id'], 'require'],
            [['make_time', 'update_time'], 'safe'],
            [['email', 'wechat', 'whats_app', 'facebook', 'printerest', 'maker', 'update_people'], 'string', 'max' => 50],
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
            'email' => 'Email',
            'wechat' => 'Wechat',
            'whats_app' => 'Whats App',
            'facebook' => 'Facebook',
            'printerest' => 'Printerest',
            'make_time' => 'Make Time',
            'maker' => 'Maker',
            'update_time' => 'Update Time',
            'update_people' => 'Update People',
        ];
    }
}
