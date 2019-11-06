<?php

namespace api\modules\v1\controllers;

use api\models\ProcessFollow;
use api\models\SamplePrice;
use Yii;
use api\controllers\BaseController;

class SampleController extends BaseController
{
    public $modelClass = 'api\models\Sample';

    /**
     * search 统一用post 参数用post参数
     * @return null
     */
    public function actionSearch()
    {
        $title = Yii::$app->request->post('title');
        $dibu_suplier = Yii::$app->request->post('dibu_suplier');
        $xiuhua_suplier = Yii::$app->request->post('xiuhua_suplier');

        $pageNum = Yii::$app->request->get('page', '1');
        $pageSize = Yii::$app->request->get('per-page', '5');

        $sort = Yii::$app->request->get('sort', '');
        $expand = Yii::$app->request->get('expand', '');

        //分页的逻辑
        $org_model = $this->modelClass;
        $models = $org_model::find()->offset(($pageNum - 1) * $pageSize)->limit($pageSize);

        if(!empty($title)){
            $models = $models->where(['like', 'title', $title]);
        }

        if(!empty($dibu_suplier)){
            $models = $models->where(['dibu_suplier'=> $dibu_suplier]);
        }
        if(!empty($xiuhua_suplier)){
            $models = $models->where(['xiuhua_suplier'=> $xiuhua_suplier]);
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
//                print_r($model['id']);die;
                $model['price'] = SamplePrice::find()->where(['sample_id' => $model['id']])->asArray()->one();
            }
        }
        $count = count($models);

        return ['items' => $models, '_meta' => ['totalCount' => $count, 'pageCount' => floor($count / $pageSize), 'currentPage' => $pageNum, 'per-page' => $pageSize]];
    }
}
