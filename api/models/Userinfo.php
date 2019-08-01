<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "userinfo".
 *
 * @property int $id 自增长id
 * @property int $user_ext 工号
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $department 部门
 * @property string $phone 手机号码
 * @property int $enabled 是否启用 0:未启用 1: 启用
 * @property int $role 1.运营 2 业务 3跟单 4 生产
 * @property string $user_auth /用户权限 (1 应付管理 2应收管理 3 出纳管理 4 数据管理 5考情管理 6账户管理)
 * @property string $function_auth 功能权限 1: 查看权限 2编辑权限 3:保存权限 4新增权限 5 查询权限 6 停用权限
 * @property string $maker 创建人
 * @property string $token
 * @property string $last_login
 * @property string $updated_at
 * @property string $created_at
 */
class Userinfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userinfo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_ext', 'enabled', 'role'], 'integer'],
            [['username'], 'required'],
            [['last_login', 'updated_at', 'created_at'], 'safe'],
            [['username', 'password', 'department', 'phone', 'maker', 'token'], 'string', 'max' => 50],
            [['user_auth', 'function_auth'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['user_ext'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长id',
            'user_ext' => '工号',
            'username' => '用户名',
            'password' => '密码',
            'department' => '部门',
            'phone' => '手机号码',
            'enabled' => '是否启用 0:未启用 1: 启用',
            'role' => '1.运营 2 业务 3跟单 4 生产',
            'user_auth' => '/用户权限 (1 应付管理 2应收管理 3 出纳管理 4 数据管理 5考情管理 6账户管理)',
            'function_auth' => '功能权限 1: 查看权限 2编辑权限 3:保存权限 4新增权限 5 查询权限 6 停用权限',
            'maker' => '创建人',
            'token' => 'Token',
            'last_login' => 'Last Login',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }
}
