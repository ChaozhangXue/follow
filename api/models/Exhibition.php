<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "exhibition".
 *
 * @property int $id
 * @property string $title 展会标题
 * @property string $date 展会时间
 * @property string $city 展会城市
 * @property string $address 展会地址
 * @property string $zhanguan_no 展馆号
 * @property string $zhanwei_no 展位号
 * @property string $contact_people 联系人
 * @property string $phone 联系电话
 * @property string $pic 展馆图片
 * @property string $backup 备注信息
 * @property string $delivery_time 发布时间
 */
class Exhibition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exhibition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'delivery_time'], 'safe'],
            [['backup'], 'string'],
            [['title', 'city', 'address', 'zhanguan_no', 'zhanwei_no', 'contact_people', 'phone', 'pic'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date' => 'Date',
            'city' => 'City',
            'address' => 'Address',
            'zhanguan_no' => 'Zhanguan No',
            'zhanwei_no' => 'Zhanwei No',
            'contact_people' => 'Contact People',
            'phone' => 'Phone',
            'pic' => 'Pic',
            'backup' => 'Backup',
            'delivery_time' => 'Delivery Time',
        ];
    }
}
