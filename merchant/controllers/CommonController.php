<?php
namespace merchant\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class CommonController extends Controller
{
    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }
        $actionName=strtolower($action->id);

        $controllerName=strtolower($action->controller->id);


        if (Yii::$app->admin->can($controllerName. '/*')) {
            return true;
        }

        if (Yii::$app->admin->can($controllerName. '/'. $actionName)) {
            return true;
        }


        //登录页面不验证
        if($controllerName. '/'. $actionName == 'merchant-admin/login'){
            return true;
        }

        //首页不验证
        if($controllerName. '/'. $actionName == 'merchant-index/index'){
            return true;
        }

        //主页不验证
        if($controllerName. '/'. $actionName == 'merchant-index/home'){
            return true;
        }


        if (Yii::$app->request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            echo  json_encode(['status' => 2, 'info' => '权限不足']);
        } else {
            if (!Yii::$app->admin->isGuest) {
                $html=<<<HTML
                    <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="middle-box text-center animated fadeInDown" style="max-width: 400px;z-index: 100;margin: 0 auto;padding-top: 40px;">
                        <h2 style="
                            font-size: 24px;
                            margin-top: 20px;
                            margin-bottom: 10px;
                            font-weight: 500;
                            color: #676a6c;">
                            RbacError (#401)
                        </h2>
                        <div class="error-desc" style="color: #676a6c;
                            font-size: 14px;">对不起，您现在还没获此操作的权限!
                        </div>
                    </div>
                    </div>
HTML;
                echo $html;
            } else {

                return $this->redirect(['merchant-admin/login']);
            }
        }
    }




    /**
     * 上传图片(单图)
     * @param $name
     * @return array|string
     */
    public function Upimg($name)
    {
        $uploadedFile = UploadedFile::getInstanceByName($name);

        if ($uploadedFile === null || $uploadedFile->hasError) {
            return '文件不存在';
        }

        //创建时间
        $ymd = date("Ymd");

        //存储到本地的路径
        $save_path = \Yii::getAlias('@api') . '/web/uploads/app_img/' . $ymd . '/';

        //存储到数据库的地址
        $save_url = '/uploads' . '/app_img/' . $ymd . '/';

        //file_exists() 函数检查文件或目录是否存在
        //mkdir() 函数创建目录

        if (!file_exists($save_path)) {
            mkdir($save_path, 0777, true);
        }
        //图片名称
        $file_name = $uploadedFile->getBaseName();


        //图片格式
        $file_ext = $uploadedFile->getExtension();


        //新文件名
        $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;


        //图片信息
        $uploadedFile->saveAs($save_path . $new_file_name);

        return $save_url.$new_file_name;
    }


}
