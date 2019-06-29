<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "sample".
 *
 * @property int $id
 * @property string $title 商品款号
 * @property string $pic 商品图片
 * @property string $color 商品颜色
 * @property string $width 商品门幅
 * @property string $kilo 商品克重（克）
 * @property string $minimum 最低起定（米）
 * @property string $xiuhua_suplier 绣花供应 暂时是字符串 1.文兴款 2：豪鼎 3.怡之鸣
 * @property string $dibu_suplier 底布供应
 * @property string $design_time 打样时间
 * @property string $dahuo_time 大货时间
 * @property string $xiuxian_num 绣线号码
 * @property string $product_num 商品卡号
 * @property string $other_num 其他编号
 * @property string $xiuhua_card_num 绣花卡号
 * @property int $source 客户来源 1：平绣 2水溶绣 3金片绣 4激光绣 5盘带绣 6其他工艺
 * @property string $created_at
 * @property string $updated_at
 */
class Sample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sample';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'pic', 'color', 'width', 'kilo', 'minimum', 'xiuhua_suplier', 'dibu_suplier', 'design_time', 'dahuo_time', 'xiuxian_num', 'product_num', 'other_num', 'xiuhua_card_num'], 'string', 'max' => 50],
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
            'pic' => 'Pic',
            'color' => 'Color',
            'width' => 'Width',
            'kilo' => 'Kilo',
            'minimum' => 'Minimum',
            'xiuhua_suplier' => 'Xiuhua Suplier',
            'dibu_suplier' => 'Dibu Suplier',
            'design_time' => 'Design Time',
            'dahuo_time' => 'Dahuo Time',
            'xiuxian_num' => 'Xiuxian Num',
            'product_num' => 'Product Num',
            'other_num' => 'Other Num',
            'xiuhua_card_num' => 'Xiuhua Card Num',
            'source' => 'Source',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function extraFields() {
        return [
            'goods'=>function(){
                return SamplePrice::find()->where(['sample_id'=> $this->id])->asArray()->one();
            },
        ];
    }

//    public function extraFields()
//    {
//        return ['price'];
//    }
//
//    public function getPrice()
//    {
////同样第一个参数指定关联的子表模型类名
////
//        return $this->hasOne(SamplePrice::className(), ['id' => 'sample_id']);
//    }
}
