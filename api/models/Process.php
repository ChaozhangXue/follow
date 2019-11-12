<?php

namespace api\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "process".
 *
 * @property int $id 自增长的process id
 * @property string $client_name 客户公司
 * @property string $client_id 客户id
 * @property int $follow_id 跟进的用户id
 * @property int $follow_name 跟进用户的name
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
            [['follow_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['client_name', 'client_id', 'follow_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长的process id',
            'client_name' => '客户公司',
            'client_id' => '客户id',
            'follow_id' => '跟进的用户id',
            'follow_name' => '跟进用户的name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public function extraFields() {
        return [
            'follow'=>function(){
                return ProcessFollow::find()->where(['process_id'=> $this->id])->asArray()->all();
            },
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
}
