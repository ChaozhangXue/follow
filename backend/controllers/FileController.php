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
        // 制定允许其他域名访问
        header("Access-Control-Allow-Origin:*");
        // 响应类型
        header('Access-Control-Allow-Methods:*');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with, content-type');

        $upload_path = '/www/wwwroot/follow/backend/web/upload/' . date('Ymd');
        $url = 'http://file.change-word.com/upload/' . date('Ymd') . '/';
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }
        if (empty($_FILES)) {
            return true;
        } else {
            $ext = isset(pathinfo($_FILES['file']['name'])['extension']) ? '.' . pathinfo($_FILES['file']['name'])['extension'] : '';
            if ($_FILES["file"]["error"] > 0) {
                return $this->error();
            } else {
                $name = time() . rand(0, 9999) . $ext;

                if (file_exists($upload_path . '/' . $name)) {
                    return $this->success($url . $name);
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        $upload_path . '/' . $name);
                    return $this->success($url . $name);
                }
            }
        }

    }

    public function success($data)
    {
        return json_encode([
            'r' => 0,
            'msg' => 'success',
            'data' => $data
        ]);
    }

    public function error($data = '')
    {
        return json_encode([
            'r' => 1,
            'msg' => 'error',
            'data' => $data
        ]);
    }
}


