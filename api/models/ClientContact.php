<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "client_contact".
 *
 * @property int $id 自增id
 * @property int $client_id
 * @property string $name 收样人民
 * @property string $address 收样地址
 * @property string $phone 收样电话
 * @property string $email
 * @property string $wechat
 * @property string $whats_app
 * @property string $facebook
 * @property string $instagram
 * @property string $twitter
 * @property string $viber
 * @property string $printerest
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
            [['name', 'address', 'phone'], 'required'],
            [['make_time', 'update_time'], 'safe'],
            [['name', 'address', 'phone', 'email', 'wechat', 'whats_app', 'facebook', 'instagram', 'twitter', 'viber', 'printerest', 'maker', 'update_people'], 'string', 'max' => 50],
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
            'name' => 'Name',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'wechat' => 'Wechat',
            'whats_app' => 'Whats App',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'viber' => 'Viber',
            'printerest' => 'Printerest',
            'make_time' => 'Make Time',
            'maker' => 'Maker',
            'update_time' => 'Update Time',
            'update_people' => 'Update People',
        ];
    }
}
