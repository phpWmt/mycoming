<?php

namespace merchant\controllers;

use merchant\models\Admin;
use merchant\models\Rbac;
use merchant\traits\AdminTrait;
use yii\data\Pagination;
use Yii;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

class MerchantAdminController extends CommonController
{
    use AdminTrait;
    //验证码
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 6, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 5,//间距
                'height' => 34,//高度
                'width' => 130,  //宽度
                'offset' => 10, //设置字符偏移量 有效果
                'backColor' =>0xFFFFFF,
                'foreColor' =>0x0AA699,
//                'fontFile'=>'@merchant/web/fonts/SourceCodeProSemibold.ttf'
            ],
        ];
    }


    //添加管理员
    public function actionCreate()
    {
        $model = new Admin();
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ($model->Create($request->post())) {
                $this->redirect(['admin/list']);
                YII::$app->end();
            }
        }else{
            return $this->render('create',['model' => $model]);
        }
    }


    public function actionDelete()
    {
        $request=Yii::$app->request;
        if ($request->isPost){
            $post=$request->post();
            $id_array=array_filter(explode(',',$post['id']));
            $models=Admin::find()->where(['in','id',$id_array])->all();
            foreach ($models as $model){
                $model->delete();
            }
            Yii::$app->response->format=Response::FORMAT_JSON;
            return ['status'=>1,'info'=>'删除成功'];
        }
        return $this->render('delete');
    }


    //登录
    public function actionLogin()
    {

        $model = new Admin(['scenario' => 'login']);
        $request = Yii::$app->request;
        if ($request->isPost) {
            if ($model->login($request->post())) {
                $admin=Admin::findOne(['id'=>Yii::$app->admin->id]);
                $admin->updateAll(['last_time' => date('Y-m-d h:i:s', time()),'login_ip' => ip2long(Yii::$app->request->userIP)]);
                $admin->updateAllCounters(['login_num' => 1], ['id'=>Yii::$app->admin->id]);
                $this->redirect(['merchant-index/index']);
                Yii::$app->end();
            }else{
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }else{

            return $this->render('login', ['model' => $model]);
        }
    }

    public function actionUpdate()
    {
        $request=Yii::$app->request;
        if ($request->isPost){
            $model=new Admin(['scenario'=>'update']);

            if ($model->Update($request->post())) {
                $this->redirect(['admin/list']);
                YII::$app->end();
            }else{

                Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }else{
            $model=Admin::findOne($request->get('id'));
            $model->scenario = 'update';
            return $this->render('update',['model'=>$model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->admin->logout(false);
        $this->redirect(['merchant-admin/login']);
    }

    public function actionList(){
        $model = Admin::find();
        $keyword = trim(Yii::$app->request->get('keyword'));

        if (!empty($keyword)) {
            $model->andWhere(['like', 'username', $keyword]);
        }
        $count = $model->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $list = $model->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id')
            ->asArray()
            ->all();
        return $this->render('list', ['model' => $list, 'pages' => $pages]);
    }

    /**
     * 管理员授权
     * @param  [type] $aid 管理员ID
     * @return [type]      [description]
     */
    public function actionAssign()
    {
        if (Yii::$app->request->isPost) {
            $post=Yii::$app->request->post();
            Yii::$app->response->format=Response::FORMAT_JSON;
            $children = !empty($post['children']) ? $post['children'] : [];
            if (Rbac::grant((int)$post['aid'], $children)) {
                return ['status' => 1, 'info' => '授权成功'];
            }
        } else {
            $get=Yii::$app->request->get();
            $aid = (int)$get['id'];
            if (empty($aid)) {
                throw new \Exception('参数错误');
            }
            $admin=Admin::findOne($get['id']);
            $admin['id']=$aid;
            if (empty($admin)) {
                throw new \yii\web\NotFoundHttpException('管理员不存在');
            }

            $auth = Yii::$app->authManager;
            $roles = Rbac::getOptions($auth->getRoles(), null);
            $permissions = Rbac::getOptions($auth->getPermissions(), null);
            $children = Rbac::getChildrenByUser($aid);
            return $this->render('assign', ['children' => $children, 'roles' => $roles, 'permissions' => $permissions, 'admin' => $admin]);
        }
    }


    public function actionStatus()
    {
        $request=Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model=Admin::findOne($request->post('id'));
            $model->status=$request->post('status');
            if ($model->save(false)) {
                return ['status' => 1, 'info' => '修改成功'];
            } else {
                return ['status' => 2, 'info' => '非法操作'];
            }
        }
    }
}
