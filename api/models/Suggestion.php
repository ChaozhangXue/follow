<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "suggestion".
 *
 * @property int $id
 * @property string $client
 * @property string $phone
 * @property string $feedback_msg
 * @property string $feedback_date
 */
class Suggestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suggestion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feedback_msg'], 'string'],
            [['feedback_date'], 'safe'],
            [['client', 'phone'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client' => 'Client',
            'phone' => 'Phone',
            'feedback_msg' => 'Feedback Msg',
            'feedback_date' => 'Feedback Date',
        ];
    }
}
