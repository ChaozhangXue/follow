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
    public $menu = [
        '1' => ['client-backup', 'client-contact', 'client', 'client-price', 'process','process-follow'],
        '2' => ['sample', 'sample-data'],
        '3' => ['client-data', 'sample-data', 'sample', 'sample-data'],
        '4' => ['exhibition', 'suggestion'],
        '5' => ['userinfo'],
    ];

    public $function = [
        '1' => ['view', 'index'],
        '2' => ['update','view'],
        '3' => ['update','create'],
        '4' => ['create'],
        '5' => ['search', 'search-like'],
        '6' => ['update'],
    ];

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
     * @return array
     * @throws \Exception
     */
    public function checkAccess($action, $model = null, $params = [])
    {
//        $token = Yii::$app->request->get('token','');
        $token = isset(Yii::$app->request->getHeaders()['token'])? Yii::$app->request->getHeaders()['token']:'';
        if (!empty($token)) {
            $val = explode('_', $token);
            if(!empty($val) && $val[0] == 1){
                $user = Userinfo::find()->where(['token' => $token])->asArray()->one();
                if (!empty($user)) {
                    //拿到用户信息后 需要校验用户权限
                    if ($this->validateAuth(Yii::$app->controller->id, Yii::$app->controller->action->id, $user['user_auth'], $user['function_auth']) == false) {
//                        throw new \Exception('权限认证失败(请重新登陆)', '401');
                        return $this->error('权限认证失败(请重新登陆)', 401);
                    }
                }
            }
        }
    }

    public function validateAuth($controller, $action, $user_auth, $function_auth)
    {
        if(empty($user_auth) || empty($function_auth)|| empty($controller)||empty($action)){
            return false;
        }

//        function 对应的是action
        $function_id = explode(',', $function_auth);
        $function = [];
        foreach ($function_id as $val){
            if(!empty($val) && isset($this->function[$val])){
                $function = array_merge($function, $this->function[$val]);
            }
        }
        if(!in_array($action, $function)){
            return false;
        }

        //menu 对应的是控制器
        $menu_id = explode(',', $user_auth);
        $menu = [];
        foreach ($menu_id as $val){
            if(!empty($val) && isset($this->menu[$val])){
                $menu = array_merge($menu, $this->menu[$val]);
            }
        }
        if(!in_array($controller, $menu)){
            return false;
        }

        return true;
    }

    public function actions()
    {
        return parent::actions(); // TODO: Change the autogenerated stub
    }

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

        $pageNum = Yii::$app->request->get('page', '1');
        $pageSize = Yii::$app->request->get('per-page', '5');

        $sort = Yii::$app->request->get('sort', '');
        $expand = Yii::$app->request->get('expand', '');

        //分页的逻辑
        $org_model = $this->modelClass;
        $models = $org_model::find()->offset(($pageNum - 1) * $pageSize)->limit($pageSize);

        foreach ($search as $key => $val){
            $models = $models->andWhere(['like', $key, trim($val)]);
        }

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

        if ($expand == 'follow') {
            foreach ($models as &$model) {
                $model['follow'] = ProcessFollow::find()->where(['process_id' => $model['id']])->asArray()->one();
            }
        }

        if ($expand == 'price') {
            foreach ($models as &$model) {
                $model['price'] = SamplePrice::find()->where(['sample_id' => $model['id']])->asArray()->one();
            }
        }
        $count = $org_model::find()->where($search)->count();

        return ['items' => $models, '_meta' => ['totalCount' => $count, 'pageCount' => floor($count / $pageSize), 'currentPage' => (int)$pageNum, 'per-page' => (int)$pageSize]];
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

        if ($expand == 'price') {
            foreach ($models as &$model) {
                $model['price'] = SamplePrice::find()->where(['sample_id' => $model['id']])->asArray()->one();
            }
        }
        if ($expand == 'follow') {
            foreach ($models as &$model) {
                $model['follow'] = ProcessFollow::find()->where(['process_id' => $model['id']])->asArray()->all();
            }
        }

        $count = $org_model::find()->where($where)->count();

        return ['items' => $models, '_meta' => ['totalCount' => $count, 'pageCount' => floor($count / $pageSize), 'currentPage' => (int)$pageNum, 'per-page' => (int)$pageSize]];
    }

    public function actionSelect($column)
    {
        $org_model = $this->modelClass;

        $res = $org_model::find()->select([$column,'id'])->groupBy($column)->asArray()->all();

        return $res;
    }

    /**
     * search 模糊查询
     * @return null
     */
    public function actionFilter()
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

        if ($expand == 'price') {
            foreach ($models as &$model) {
                $model['price'] = SamplePrice::find()->where(['sample_id' => $model['id']])->asArray()->one();
            }
        }
        if ($expand == 'follow') {
            foreach ($models as &$model) {
                $model['follow'] = ProcessFollow::find()->where(['process_id' => $model['id']])->asArray()->all();
            }
        }

        $count = $org_model::find()->where($where)->count();

        return ['items' => $models, '_meta' => ['totalCount' => $count, 'pageCount' => floor($count / $pageSize), 'currentPage' => $pageNum, 'per-page' => $pageSize]];
    }
}
