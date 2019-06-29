<?php

namespace api\modules\v1\controllers;

use Yii;
use api\controllers\BaseController;

class UserinfoController extends BaseController
{
    public $modelClass = 'api\models\Userinfo';

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
        //todo 小程序登陆是用的工号和密码
        $post_data = Yii::$app->request->post();
        $user_ext = $post_data['user_ext'];
        $username = $post_data['username'];
        $password = $post_data['password'];

        if (empty($username) || empty($user_ext)) {
            return $this->error('用户名密码为空');
        }

        $model = $this->modelClass;
        if(!empty($username)){

            $user = $model::find()->where(['username' => $username])->one();
            if ($user) {
                $token = $this->generateRandomString();
                $user->token = $token;
                $user->save();
            } else {
                return $this->error('用户不存在',404);
            }
        }

        if(!empty($user_ext)){
            $model = $this->modelClass;

            $user = $model::find()->where(['user_ext' => $user_ext])->one();
            if ($user) {
                $token = $this->generateRandomString();
                $user->token = $token;
                $user->save();
            } else {
                return $this->error('用户不存在',404);
            }
        }

        return $this->success($user->toArray());
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
