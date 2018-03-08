<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/5
 * Time: 15:28
 */
namespace backend\controllers;
use yii;
use yii\web\Response;
use backend\models\Rbac;
use yii\data\Pagination;
use yii\widgets\ActiveForm;

class RbacController extends CommonController {
    //创建或删除的数据
    public $attributes;
    //更新之前的数据
    public $changedAttributes;
    //更新之后的数据
    public $oldAttributes;

    public $id;


    //区分角色
    public function actionRolesIndex(){

        return $this->render('rolesIndex');
    }

    //角色列表
    public function actionRoles()
    {
        $model = Rbac::find();
        $get=Yii::$app->request->get();

        if (!empty($get['keyword'])){
            $model->andWhere(['or',['like','name',$get['keyword']],['like','description',$get['keyword']]]);
        }

        $count = $model->andwhere(['type' => 1,'data'=>serialize((int)$get['data'])])->count();

        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('roles', ['list' => $list, 'pages' => $pages,'status'=>$get['data']]);
    }


    /**
     * 添加角色
     */
    public function actionAddRoles()
    {
        $model=new Rbac(['scenario'=>'add_roles']);
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $post = Yii::$app->request->post();

            if ($model->load($post) && $model->validate()){

                $auth = Yii::$app->authManager;

                $role = $auth->createRole(null);

                $role->name = $model->name;
                $role->description = $model->description;

                $role->data = (int)$model->status;

                if ($auth->add($role)) {
                    $this->attributes=[
                        'name'=>$model->name,
                        'description'=>$model->description,
                        'type'=>$model->type,
                    ];
                    $this->id=$model->name;
                    yii\base\Event::trigger(yii\db\ActiveRecord::className(),yii\db\ActiveRecord::EVENT_AFTER_INSERT,new yii\base\Event(['sender'=>$this]));

                    $this->redirect(['rbac/roles-index']);

                }
            }else{
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }else{
            return $this->render('add-roles',['model'=>$model]);
        }
    }


    /**
     * 删除权限或角色
     */
    public function actionDeleteItem()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post=$request->post();
            if (empty($post['name'])||empty($post['type'])) {
                return ['status' => 2, 'info' => '参数不能为空'];
            }
            $auth = Yii::$app->authManager;
            if ($post['type']==2) {
                $obj=$auth->getPermission($post['name']);
            } else {
                $obj=$auth->getRole($post['name']);
            }

            if ($auth->remove($obj)) {

                $this->attributes=[
                    'name'=>$obj->name,
                    'description'=>$obj->description,
                    'type'=>$obj->type,
                ];
                $this->id=$post['name'];
                yii\base\Event::trigger(
                    yii\db\ActiveRecord::className(),
                    yii\db\ActiveRecord::EVENT_AFTER_DELETE,
                    new yii\base\Event(['sender'=>$this])
                );
                return ['status' => 1, 'info' => '删除成功'];
            } else {
                return ['status' => 2, 'info' => '此权限或角色已经不存在'];
            }
        }
    }


    /**
     * 更新权限或角色
     */
    public function actionUpdateItem()
    {

        $request = Yii::$app->request;
        $model=new Rbac();
        $model->scenario='update';
        if ($request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $post=$request->post();
            if ($model->load($post) && $model->validate()){
                $auth = Yii::$app->authManager;
                if ($post['Rbac']['type']==2) {
                    $obj=$auth->getPermission($post['Rbac']['name']);
                    $url='rbac/permissions';
                } else {
                    $obj=$auth->getRole($post['Rbac']['update_name']);
                    $url='rbac/roles';
                }
                $obj->name=$post['Rbac']['name'];
                $obj->description=$post['Rbac']['description'];
                if ($auth->update($post['Rbac']['update_name'], $obj)) {

                    $this->changedAttributes=[
                        'name'=>$post['Rbac']['update_name'],
                        'description'=>$post['Rbac']['update_description'],
                    ];
                    $this->oldAttributes=[
                        'name'=>$post['Rbac']['name'],
                        'description'=>$post['Rbac']['description'],
                    ];
                    $this->id=$post['Rbac']['name'];
                    yii\base\Event::trigger(
                        yii\db\ActiveRecord::className(),
                        yii\db\ActiveRecord::EVENT_AFTER_UPDATE,
                        new yii\base\Event(['sender'=>$this])
                    );
                    die;
                    $this->redirect([$url]);
                }
            }else{
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }else{
            $auth = Yii::$app->authManager;
            $get=$request->get();
            $title['type']=$get['type'];
            if ($get['type']==2) {
                $obj=$auth->getPermission($get['name']);
                $title['title']='修改权限';
                $title['description']='权限名称';
                $title['name']='权限标识';
                $title['url']='rbac/permissions';
            } else {
                $obj=$auth->getRole($get['name']);
                $title['title']='修改角色';
                $title['description']='角色名称';
                $title['name']='角色标识';
                $title['url']='rbac/roles';
            }
            return $this->render('update-item', ['title'=>$title,'data'=>$obj,'model'=>$model]);
        }
    }



    //权限区分
    public  function actionIndex(){

        return $this->render('index');
    }


    /**
     * 权限列表
     */
    public function actionPermissions()
    {
        $status = Yii::$app->request->get('status');

        $model=Rbac::find()->where(['type' => 2,'data'=>serialize((int)$status)]);

        $count=$model->count();
        if (!empty(Yii::$app->request->get('keyword'))){
            $keyword=Yii::$app->request->get('keyword');
            $model->andWhere(['or',['like','name',$keyword],['like','description',$keyword]]);
        }
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('permissions', ['list' => $list, 'pages' => $pages,'status'=>$status]);
    }



    /**
     * 添加权限
     */
    public function actionAddPermissions()
    {
        $auth = Yii::$app->authManager;
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            //防止权限重复
            $permission = Yii::$app->request->post();

            if (!$auth->getPermission($permission['name'])) {
                $obj = $auth->createPermission($permission['name']);
                $obj->description = $permission['description'];
                $obj->type = 2;
                $obj->data = (int)$permission['status'];

                if ($auth->add($obj)) {

                    //日志
//                    yii\base\Event::trigger(yii\db\ActiveRecord::className(), yii\db\ActiveRecord::EVENT_AFTER_INSERT, new yii\base\Event(['sender'=>$this]));

                    return ['status' => 1, 'info' => '添加成功'];
                }
            } else {
                return ['status' => 2, 'info' => '该权限已经存在,请不要重复添加'];
            }
        } else {

            return $this->render('add-permissions');
        }
    }




    /**
     * 分配权限
     * @param  [type] $name 当前角色名称
     * @return [type]       渲染视图
     */
    public function actionAssignItem()
    {

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (Rbac::addChild($post['children'], $post['name'])) {

                Yii::$app->getSession()->setFlash('success', '分配成功！');
                return $this->redirect(['rbac/roles-index']);

            }
        } else {
            $status = Yii::$app->request->get('status');

            $name = htmlspecialchars(Yii::$app->request->get('name'));

            $auth = Yii::$app->authManager;

            //获取当前角色的信息
            $parent = $auth->getRole($name);

            //获取当前角色所属的权限和规则
            $children = Rbac::getChildrenByName($name);

            //获取所有角色
            $roles = Rbac::getOptions($auth->getRoles(), $parent,$status);

            //获取所有规则
            $permissions = Rbac::getOptions($auth->getPermissions(), $parent,$status);


            return $this->render('assign-item', ['parent' => $parent, 'roles' => $roles, 'permissions' => $permissions, 'children' => $children]);
        }
    }


    public function getAttributes($names=null){
        if ($names === null) {
            return false;
        }
    }

    public function getAttributeLabel($name){
        $attr=[
            'name' => '名称',
            'type' => 'Type',
            'description' => '描述',
            'rule_name' => '规则名称',
            'data' => 'Data',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
        if (true === array_key_exists($name,$attr)) {
            return $attr[$name];
        }
    }

    public static function tableName(){
        return Rbac::tableName();
    }
}