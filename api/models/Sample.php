<?php

namespace api\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property string $xiuhua_suplier 绣花供应
 * @property string $dibu_suplier 底部供应
 * @property string $design_time 打样时间
 * @property string $dahuo_time 大货时间
 * @property string $xiuxian_num 绣线号码
 * @property string $product_num 商品卡号
 * @property string $other_num 其他编号
 * @property string $xiuhua_card_num 绣花卡号
 * @property int $xiuhua_gongyi 绣花工艺1：平绣 2水溶绣 3金片绣 4激光绣 5盘带绣 6其他工艺
 * @property int $source 客户来源 1：文兴 2豪鼎3美楠 4怡之鸣 5天森 6骏达 7黄龙 8其他
 * @property int $inStock 是否是现货 0无现货 1有现货
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
            [['pic'], 'string'],
            [['xiuhua_gongyi', 'source', 'inStock'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'color', 'width', 'kilo', 'minimum', 'xiuhua_suplier', 'dibu_suplier', 'design_time', 'dahuo_time', 'xiuxian_num', 'product_num', 'other_num', 'xiuhua_card_num'], 'string', 'max' => 50],
            [['title', 'color', 'width', 'kilo'], 'unique', 'targetAttribute' => ['title', 'color', 'width', 'kilo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '商品款号',
            'pic' => '商品图片',
            'color' => '商品颜色',
            'width' => '商品门幅',
            'kilo' => '商品克重（克）',
            'minimum' => '最低起定（米）',
            'xiuhua_suplier' => '绣花供应',
            'dibu_suplier' => '底部供应',
            'design_time' => '打样时间',
            'dahuo_time' => '大货时间',
            'xiuxian_num' => '绣线号码',
            'product_num' => '商品卡号',
            'other_num' => '其他编号',
            'xiuhua_card_num' => '绣花卡号',
            'xiuhua_gongyi' => '绣花工艺1：平绣 2水溶绣 3金片绣 4激光绣 5盘带绣 6其他工艺',
            'source' => '客户来源 1：文兴 2豪鼎3美楠 4怡之鸣 5天森 6骏达 7黄龙 8其他',
            'inStock' => '是否是现货 0无现货 1有现货',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }



    public function extraFields() {
        return [
            'price'=>function(){
                return SamplePrice::find()->where(['sample_id'=> $this->id])->asArray()->one();
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
