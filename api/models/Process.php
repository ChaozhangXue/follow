<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "process".
 *
 * @property int $id
 * @property string $follow_month 跟进月份
 * @property string $backup 备注信息
 * @property string $follow_time 跟进时间
 * @property string $follow_people 跟进角色
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
            [['follow_month', 'follow_time'], 'safe'],
            [['backup'], 'string'],
            [['follow_people'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'follow_month' => 'Follow Month',
            'backup' => 'Backup',
            'follow_time' => 'Follow Time',
            'follow_people' => 'Follow People',
        ];
    }
}
