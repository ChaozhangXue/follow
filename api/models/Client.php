<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id 自增长id
 * @property string $company_name 客户公司名称
 * @property string $province 省份
 * @property string $address 客户地址
 * @property string $phone 客户电话
 * @property string $called 客户称呼
 * @property int $age 客户年龄
 * @property string $position 客户职位
 * @property string $country 所属国家
 * @property int $nature 公司性质(1.服装厂 2.批发商 3代理商 4零售商)
 * @property string $first_follow_time 首次接触时间
 * @property int $sex 性别 1：男 2 女
 * @property int $intention 客户意向 1：偏低 2：中等 3： 偏高
 * @property int $type 客户类型 1：新客户 2：老客户
 * @property int $distribute 客户分配 1：待分配 2：已分配
 * @property int $source 客户来源 1：展会 2线上 3客户介绍
 * @property string $follow_backup 来源备注
 * @property string $follower_name 跟进人姓名
 * @property int $follower_id 跟进人id（参照userinfo表的数据）
 * @property string $make_time 建档时间
 * @property string $maker 建党人员
 * @property string $update_time 修改时间
 * @property string $update_people 修改角色
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['age', 'nature', 'sex', 'intention', 'type', 'distribute', 'source', 'follower_id'], 'integer'],
            [['first_follow_time', 'make_time'], 'safe'],
            [['company_name', 'province', 'address', 'phone', 'called', 'position', 'country', 'follow_backup', 'follower_name', 'maker', 'update_time', 'update_people'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'province' => 'Province',
            'address' => 'Address',
            'phone' => 'Phone',
            'called' => 'Called',
            'age' => 'Age',
            'position' => 'Position',
            'country' => 'Country',
            'nature' => 'Nature',
            'first_follow_time' => 'First Follow Time',
            'sex' => 'Sex',
            'intention' => 'Intention',
            'type' => 'Type',
            'distribute' => 'Distribute',
            'source' => 'Source',
            'follow_backup' => 'Follow Backup',
            'follower_name' => 'Follower Name',
            'follower_id' => 'Follower ID',
            'make_time' => 'Make Time',
            'maker' => 'Maker',
            'update_time' => 'Update Time',
            'update_people' => 'Update People',
        ];
    }
}
