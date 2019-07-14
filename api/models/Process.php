<?php

namespace api\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use api\models\ProcessFollow;


/**
 * This is the model class for table "process".
 *
 * @property int $id 自增长的process id
 * @property string $client_name 客户公司
 * @property string $follow_people 跟进角色
 * @property string $follow_time 跟进时间
 * @property string $created_at
 * @property string $updated_at
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
            [['follow_time', 'created_at', 'updated_at'], 'safe'],
            [['client_name', 'follow_people'], 'string', 'max' => 50],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_name' => 'Client Name',
            'follow_people' => 'Follow People',
            'follow_time' => 'Follow Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function extraFields() {
        return [
            'follow'=>function(){
                return ProcessFollow::find()->where(['process_id'=> $this->id])->asArray()->one();
            },
        ];
    }

}
