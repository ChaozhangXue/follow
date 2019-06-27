<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "sample_data".
 *
 * @property int $id
 * @property int $today_add_sample
 * @property int $monthly_add_sample
 * @property int $total_add_sample
 * @property int $Column 5
 */
class SampleData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sample_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['today_add_sample', 'monthly_add_sample', 'total_add_sample', 'Column 5'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'today_add_sample' => 'Today Add Sample',
            'monthly_add_sample' => 'Monthly Add Sample',
            'total_add_sample' => 'Total Add Sample',
            'Column 5' => 'Column 5',
        ];
    }
}
