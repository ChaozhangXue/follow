<?php
namespace backend\controllers;

use yii\base\Controller;

/**
 * Site controller
 */
class FileController extends Controller
{
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionUpload()
    {
        $upload_path = '/var/www/html/follow/backend/web/upload/' . date('Ymd');
        $url = 'http://test1.delcache.com/upload/';
        if(!file_exists($upload_path)){
            mkdir($upload_path, 0777,true);
        }
        if (empty($_FILES)) {
            return true;
        } else {
            if ($_FILES["file"]["error"] > 0) {
                $this->error();
            } else {
                $name = time() . rand(0,9999);

                if (file_exists($upload_path .'/' . $name)) {
                    $this->success($url . $name);
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        $upload_path .'/' . $name);
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


