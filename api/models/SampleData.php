<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "sample_data".
 *
 * @property int $id
 * @property int $today_add_sample 今天新增样品
 * @property int $monthly_add_sample 本月新增样品
 * @property int $total_add_sample 累计新增样品
 * @property int $new_sample 新开发样
 * @property int $old_sample 陈旧样品
 * @property int $sample_10 10元样
 * @property int $sample_30 30元样
 * @property int $sample_50 50元样
 * @property int $sample_70 70元样
 * @property int $wenxing 文兴款
 * @property int $haoding 豪鼎款
 * @property int $yizhiming 怡之鸣
 * @property string $data_date 统计的日期
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
            [['today_add_sample', 'monthly_add_sample', 'total_add_sample', 'new_sample', 'old_sample', 'sample_10', 'sample_30', 'sample_50', 'sample_70', 'wenxing', 'haoding', 'yizhiming'], 'integer'],
            [['data_date'], 'safe'],
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
            'new_sample' => 'New Sample',
            'old_sample' => 'Old Sample',
            'sample_10' => 'Sample 10',
            'sample_30' => 'Sample 30',
            'sample_50' => 'Sample 50',
            'sample_70' => 'Sample 70',
            'wenxing' => 'Wenxing',
            'haoding' => 'Haoding',
            'yizhiming' => 'Yizhiming',
            'data_date' => 'Data Date',
        ];
    }
}
