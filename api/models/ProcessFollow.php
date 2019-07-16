<?php

namespace api\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "process_follow".
 *
 * @property int $id
 * @property int $process_id 进度的id
 * @property string $follow_month 跟进月份(2019-10)
 * @property int $follow_day 跟进日期
 * @property string $follow_people 跟进人
 * @property string $follow_time 跟进时间
 * @property string $backup 备注信息
 * @property string $created_at
 * @property string $updated_at
 */
class ProcessFollow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'process_follow';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                //'value' => new Expression('NOW()'),
                'value'=>date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['process_id', 'follow_day'], 'integer'],
            [['backup'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['follow_month', 'follow_people', 'follow_time'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'process_id' => 'Process ID',
            'follow_month' => 'Follow Month',
            'follow_day' => 'Follow Day',
            'follow_people' => 'Follow People',
            'follow_time' => 'Follow Time',
            'backup' => 'Backup',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
