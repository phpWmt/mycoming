<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/15
 * Time: 15:18
 */
namespace merchant\controllers;
use merchant\models\ArticleCate;
use merchant\traits\TreeTrait;
use Yii;
use merchant\models\Cate;
use merchant\models\GodownType;

class MerchantCateController extends CommonController {
    use TreeTrait;


    //添加分类
    public function actionCreate()
    {

        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();

        $model=empty($post['model'])?new Cate():new ArticleCate();
        $model->name=$post['name'];
        $model->pid=$post['pid'];
        $model->is_show=2;
        $model->apply=1;
        if($model->save(false)){
            return ['status' => 1, 'info' => '申请成功,待审核！'];
        }
    }


    //添加子品牌
    public function actionAdd(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $image = $this->Upimg("files");  //img存储的图片字段
            if($image == '文件不存在'){
                Yii::$app->getSession()->setFlash('success', '请添加品牌图片！');
                return $this->redirect(['merchant-cate/list']);
            }else{
                $model = new ArticleCate();
                $model->name=$post['name'];
                $model->pid=$post['id'];
                $model->img=$image;
                $model->is_show=2;
                $model->apply=1;

                if($model->save(false)){
                    Yii::$app->getSession()->setFlash('success', '申请成功,待审核！');
                    return $this->redirect(['merchant-cate/list']);
                }
            }
        }
    }



    //显示或隐藏
    public function actionOperation(){
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();
        if($post['type'] == 'brand'){//品牌
            $model = new ArticleCate();
        }else if($post['type'] == 'class'){//分类
            $model = new Cate();
        }
        //操作
        if($post['action'] == 'show'){//显示
            //查询是否是一级分类
            $data=$model::find()->where(['pid'=>$post['id']])->asArray()->all();
            if ($data){
                foreach ($data as $v){
                    $res = $model->updateAll(['is_show'=>1],['id'=>$v['id']]);
                }
             }
            $res = $model->updateAll(['is_show'=>1],['id'=>$post['id']]);

        }else if($post['action'] == 'hide'){//隐藏
            //查询是否是一级分类
            $data=$model::find()->where(['pid'=>$post['id']])->asArray()->all();
            if ($data){
                foreach ($data as $v){
                    $res = $model->updateAll(['is_show'=>2],['id'=>$v['id']]);
                }
            }
            $res = $model->updateAll(['is_show'=>2],['id'=>$post['id']]);
        }
        //返回
        if ($res){
            return ['status' => 1, 'info' => '操作成功'];
        }
    }


    //分类列表
    public function actionList()
    {
        $cate=TreeTrait::generateTree(Cate::find()->asArray()->orderBy('sort ASC')->all());
        $article_cate=TreeTrait::generateTree(ArticleCate::find()->asArray()->all());
        return $this->render('list',['cate'=>$cate,'article_cate'=>$article_cate]);
    }



    //删除分类
    public function actionDelete()
    {
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();
        $model=empty($post['model'])?new Cate():new ArticleCate();
        $data=$model::find()->where(['pid'=>$post['id']])->asArray()->all();
        if ($data){
            return ['status' => 2, 'info' => '该分类下还有子分类请先删除子分类'];
        }
        $res=$model::findOne($post['id'])->delete();
        if ($res){
            return ['status' => 1, 'info' => '删除成功'];
        }
    }


    //修改分类
    public function actionUpdate()
    {
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();
        $model=empty($post['model'])?new Cate():new ArticleCate();
        $res=$model::updateAll(['name'=>$post['name'],'sort'=>$post['sort']],['id'=>$post['id']]);
        if ($res){
            return ['status' => 1, 'info' => '修改成功'];
        }else{
            return ['status' => 2, 'info' => '没做任何修改'];
        }
    }


    //添加库存类型
    public function actionGodownType(){
        $request=Yii::$app->request;
        if ($request->isPost){
            Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
            $post=$request->post();
            $model=new GodownType();
            $model->name=$post['name'];
            $model->sort=$post['sort'] ? $post['sort'] : '0';
            $model->pid=$post['pid'];
            if($model->save(false)){
                return ['status' => 1, 'info' => '添加成功'];
            }
        }else{
            //库存类型列表
            $GodownType=GodownType::find()->asArray()->all();
            return $this->render('godownType',['GodownType'=>$GodownType]);
        }
    }

    //库存类型 显示 或隐藏
    public function actionGodownOperation()
    {
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();
        //实例化
        $model=new GodownType();
        //操作
        if($post['action'] == 'show'){//显示

            $res = $model->updateAll(['is_show'=>1],['id'=>$post['id']]);

        }else if($post['action'] == 'hide'){//隐藏
            $res = $model->updateAll(['is_show'=>2],['id'=>$post['id']]);
        }
        //返回
        if ($res){
            return ['status' => 1, 'info' => '操作成功'];
        }
    }



    //删除库存类型
    public function actionGodownDelete()
    {
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();
        var_dump($post);die;
        $model=new GodownType();
        $res=$model::findOne($post['id'])->delete();

        if ($res){
            return ['status' => 1, 'info' => '删除成功'];
        }
    }



}