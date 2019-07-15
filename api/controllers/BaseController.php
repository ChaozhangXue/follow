<?php

namespace api\controllers;

use api\models\SamplePrice;
use api\models\Userinfo;
use api\models\ProcessFollow;
use Yii;
use yii\db\Exception;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Site controller
 */
class BaseController extends ActiveController
{
    public function behaviors()
    {
//        if($this->module->requestedAction->id)
//        $action = $this->module->module->controller->action->id;
//        if(in_array($action,['search'])){
//            $this->checkAccess($action);
//        }
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        // 制定允许其他域名访问
        header("Access-Control-Allow-Origin:*");
// 响应类型

        header('Access-Control-Allow-Methods:*');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');

        return $behaviors;
    }


    /**
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws \Exception
     */
    public function checkAccess($action, $model = null, $params = [])
    {
//        $token = Yii::$app->request->getHeaders()['token'] ?? '';
//        if(empty($token)){
        //{
        //    "name": "Exception",
        //    "message": "权限认证失败",
        //    "code": 401,
        //    "type": "Exception",
        //    "file": "D:\\xampp\\htdocs\\follow\\api\\controllers\\BaseController.php",
        //    "line": 31,
        //    "stack-trace": [
        //        "#0 [internal function]: api\\controllers\\BaseController->checkAccess('index')",
        //        "#1 D:\\xampp\\htdocs\\follow\\vendor\\yiisoft\\yii2\\rest\\IndexAction.php(79): call_user_func(Array, 'index')",
        //        "#2 [internal function]: yii\\rest\\IndexAction->run()",
        //        "#3 D:\\xampp\\htdocs\\follow\\vendor\\yiisoft\\yii2\\base\\Action.php(94): call_user_func_array(Array, Array)",
        //        "#4 D:\\xampp\\htdocs\\follow\\vendor\\yiisoft\\yii2\\base\\Controller.php(157): yii\\base\\Action->runWithParams(Array)",
        //        "#5 D:\\xampp\\htdocs\\follow\\vendor\\yiisoft\\yii2\\base\\Module.php(528): yii\\base\\Controller->runAction('index', Array)",
        //        "#6 D:\\xampp\\htdocs\\follow\\vendor\\yiisoft\\yii2\\web\\Application.php(103): yii\\base\\Module->runAction('v1/suggestion/i...', Array)",
        //        "#7 D:\\xampp\\htdocs\\follow\\vendor\\yiisoft\\yii2\\base\\Application.php(386): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))",
        //        "#8 D:\\xampp\\htdocs\\follow\\api\\web\\index.php(17): yii\\base\\Application->run()",
        //        "#9 {main}"
        //    ]
        //}
//            throw new \Exception('权限认证失败','401');
//        }
//        $user = Userinfo::find()->where(['token' => $token])->asArray()->one();
//        if (empty($user)) {
////            $this->user_info = $user;
//            //拿到用户信息后 需要校验用户权限
////            if($this->validateAuth($this->module->requestedRoute, $user['user_auth'], $user['function_auth']) == false){
////                $this->error('Permission Denied.', -1);
////            }
//
//            throw new \Exception('权限认证失败(请重新登陆)','401');
//        }
        //todo 把权限认证的逻辑放这里
    }

//    public function validateAuth($url, $user_auth, $function_auth)
//    {
//        if(empty($user_auth) || empty($function_auth)){
//            return false;
//        }
//
//        list($controller, $action) = explode('/', $url);
//        if(!in_array($action,['add','one','search','update'])){
//            return true;
//        }
////        function 对应的是action
//        $function_id = explode(',', $function_auth);
//        $function = [];
//        foreach ($function_id as $val){
//            $function = array_merge($function, $this->function[$val]);
//        }
//        if(!in_array($action, $function)){
//            return false;
//        }
//
//        //menu 对应的是控制器
//        $menu_id = explode(',', $user_auth);
//        $menu = [];
//        foreach ($menu_id as $val){
//            $menu = array_merge($menu, $this->menu[$val]);
//        }
//        if(!in_array($controller, $menu)){
//            return false;
//        }
//
//        return true;
//    }

    public function actions()
    {
        return parent::actions(); // TODO: Change the autogenerated stub
    }

//    public function actionIndex(){
//        $model = $this->modelClass;
//        return new ActiveDataProvider(
//            [
//                'query' => $model::find()->asArray(),
//                'pagination' => ['pageSize'=>5]
//            ]
//        );
//    }

    public function success($data = [], $msg = 'success', $code = 200)
    {
        $response = \Yii::$app->response;
        $response->setStatusCode($code, $msg);
        return $data;
    }

    public function error($msg = 'failed', $code = 400, $data = [])
    {
        $response = \Yii::$app->response;
        $response->setStatusCode($code, $msg);
        return $data;
//        print_r(\Yii::$app->response);die;
//        $response->data = [
//        'r' => ($response->getStatusCode() >= 200 && $response->getStatusCode()< 300)? 0:1,
//        'code' => $response->getStatusCode(),
//        'msg' => $response->statusText,
//        'data' => $response->data,
//    ];
    }

    //todo 页数可配
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * search 统一用post 参数用post参数
     * @return null
     */
    public function actionSearch()
    {
        $search = Yii::$app->request->post();
        $search = array_filter($search);

//        if (empty($search)) {
//            return null;
//        }
//        $keys = Yii::$app->request->post('keys');
//        $value = Yii::$app->request->post('value');

        $pageNum = Yii::$app->request->get('page', '1');
        $pageSize = Yii::$app->request->get('per-page', '5');

        $sort = Yii::$app->request->get('sort', '');
        $expand = Yii::$app->request->get('expand', '');

//        $keys_ary = explode(',', $keys);
//        $where = ['or'];
//        foreach ($keys_ary as $val) {
//            $where[] = ['like', $val, $value];
//        }
        //分页的逻辑
        $org_model = $this->modelClass;
        $models = $org_model::find()->offset(($pageNum - 1) * $pageSize)->limit($pageSize)->where($search);

        //排序逻辑
        if (!empty($sort)) {
            $sort_by = substr($sort, 0, 1);
            $sort_val = substr($sort, 1);

            if ($sort_by == ' ') {
                $by = "$sort_val ASC";
                $models = $models->orderby($by);
            } elseif ($sort_by == '-') {
                $by = "$sort_val DESC";
                $models = $models->orderby($by);

            }
        }

        $models = $models->asArray()->all();

	if($expand == 'follow'){
            foreach ($models as &$model){
                $model['follow'] = ProcessFollow::find()->where(['process_id'=> $model['id']])->asArray()->one();
            }
        }

        if($expand == 'price'){
            foreach ($models as &$model){
//                print_r($model['id']);die;
                $model['price'] = SamplePrice::find()->where(['sample_id'=> $model['id']])->asArray()->one();
            }
        }
        $count = $org_model::find()->where($search)->count();

        return ['items' => $models, '_meta' => ['totalCount'=>$count,'pageCount'=>floor($count/$pageSize),'currentPage'=>$pageNum,'per-page'=> $pageSize]];

//        $search = Yii::$app->request->post();
//        if (empty($search)) {
//            return null;
//        }
//
//        $pageNum = Yii::$app->request->post('page', '1');
//        $pageSize = Yii::$app->request->post('per-page', '5');
//
//        //todo 这里加个分页
//        $model = $this->modelClass;
//        $models = $model::find()->offset(($pageNum - 1) * $pageSize)->limit($pageSize)->where($search)->asArray()->all();
//
//        return $models;
    }

    /**
     * search 模糊查询
     * @return null
     */
    public function actionSearchLike()
    {
        $keys = Yii::$app->request->post('keys');
        $value = Yii::$app->request->post('value');

        $pageNum = Yii::$app->request->get('page', '1');
        $pageSize = Yii::$app->request->get('per-page', '5');

        $sort = Yii::$app->request->get('sort', '');
        $expand = Yii::$app->request->get('expand', '');

        $keys_ary = explode(',', $keys);
        $where = ['or'];
        foreach ($keys_ary as $val) {
            $where[] = ['like', $val, $value];
        }
        //分页的逻辑
        $org_model = $this->modelClass;
        $models = $org_model::find()->offset(($pageNum - 1) * $pageSize)->limit($pageSize)->where($where);

        //排序逻辑
        if (!empty($sort)) {
            $sort_by = substr($sort, 0, 1);
            $sort_val = substr($sort, 1);

            if ($sort_by == ' ') {
                $by = "$sort_val ASC";
                $models = $models->orderby($by);
            } elseif ($sort_by == '-') {
                $by = "$sort_val DESC";
                $models = $models->orderby($by);

            }
        }

        $models = $models->asArray()->all();

        if($expand == 'price'){
            foreach ($models as &$model){
                $model['price'] = SamplePrice::find()->where(['sample_id'=> $model['id']])->asArray()->one();
            }
        }
	    if($expand == 'follow'){
            foreach ($models as &$model){
                $model['follow'] = ProcessFollow::find()->where(['process_id'=> $model['id']])->asArray()->all();
            }
        }

        $count = $org_model::find()->where($where)->count();

        return ['items' => $models, '_meta' => ['totalCount'=>$count,'pageCount'=>floor($count/$pageSize),'currentPage'=>$pageNum,'per-page'=> $pageSize]];
    }

    public function actionSelect(){
        $column = Yii::$app->request->post('column');
        $org_model = $this->modelClass;

        $res = $org_model->select("$column")->groupBy($column)->asArray()->all();

        return ['items' => $res];
    }
}
