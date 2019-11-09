<?php

namespace api\modules\v1\controllers;

use api\models\Userinfo;
use Yii;
use api\controllers\BaseController;

class UserinfoController extends BaseController
{
    public $modelClass = 'api\models\Userinfo';

    public function actionResetPassword($id){
        $old_pwd = Yii::$app->request->post('old_pwd');
        $new_pwd = Yii::$app->request->post('new_pwd');

        if($old_pwd == $new_pwd){
            return $this->error('不能修改成和原来一样的密码',400);
        }

        $user = Userinfo::find()->where(['id' => $id, 'password'=>$old_pwd])->one();
        if(empty($user)){
            return $this->error('修改失败',400);
        }
        $user->password = $new_pwd;
        $user->save();

        return $this->success($user->toArray());
    }

    /**
     * @SWG\Options(
     *	path = "/users",
     *	tags = {"user"},
     *	operationId = "userOptions",
     *	summary = "options",
     *	produces = {"application/json"},
     *	consumes = {"application/json"},
     *	@SWG\Response(
     *     response = 200,
     *     description = "success",
     *     @SWG\Header(header="Allow", type="GET, POST, HEAD, OPTIONS"),
     *     @SWG\Header(header="Content-Type", type="application/json; charset=UTF-8")
     *  )
     *)
     */
    public function actionLogin(){
        $post_data = Yii::$app->request->post();
        $user_ext = isset($post_data['user_ext'])? $post_data['user_ext']:'';
        $username = isset($post_data['username'])? $post_data['username']:'';
        $password = isset($post_data['password'])? $post_data['password']:'';
        $platform = isset($post_data['platform'])? $post_data['platform']:'2';//1:后台 2：小程序
        $token = $this->generateRandomString();
        $model = $this->modelClass;
        if(!empty($username)){

            $user = $model::find()->where(['username' => $username, 'password'=> $password])->one();
            if ($user) {
                if($user->enable == 0){
                    return $this->error('账号已被停用,请联系管理员开启',404);
                }
                $user->token = $platform . '_' . $token;
                $user->save();
            } else {
                return $this->error('登陆失败',404);
            }
        }

        if(!empty($user_ext)){
            $model = $this->modelClass;

            $user = $model::find()->where(['user_ext' => $user_ext, 'password'=> $password])->one();
            if ($user) {
                if($user->enable == 0){
                    return $this->error('账号已被停用,请联系管理员开启',404);
                }
                $user->token = $platform . '_' .$token;
                $user->save();
            } else {
                return $this->error('登陆失败',404);
            }
        }

        if(!empty($user)){
            return $this->success($user->toArray());
        }else{
            return $this->error('登陆失败',404);
        }

    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString . time();
    }

    public function actionLogout(){
        $user_id = Yii::$app->request->post('user_id');

        if(empty($user_id)){
            return $this->error('user_id 为空');
        }
        $model = $this->modelClass;
        $user = $model::find()->where(['id' => $user_id])->one();
        if(empty($user)){
            return $this->error('用户不存在');
        }
        $user->token = '';
        $user->save();
        return $this->success();
    }
}
