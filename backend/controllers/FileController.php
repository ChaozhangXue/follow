<?php
namespace backend\controllers;

use yii\base\Controller;

/**
 * Site controller
 */
class FileController extends Controller
{
    public function actionUpload()
    {
        $url = 'http://test1.delcache.com/upload/';
        if (empty($_FILES)) {
            return true;
        } else {
            if ($_FILES["file"]["error"] > 0) {
                $this->error();
            } else {
                $name = time() . rand(0,9999);

                if (file_exists("upload/" . $name)) {
                    $this->success($url . $name);
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        '/var/www/html/follow/backend/web/upload/' . $name);
                    $this->success($url . $name);
                }
            }
        }

    }

    public function success($data){
        return json_encode([
            'r'=>0,
            'msg'=>'success',
            'data'=> $data
        ]);
    }

    public function error($data = ''){
        return json_encode([
            'r'=>1,
            'msg'=>'error',
            'data'=> $data
        ]);
    }
}

