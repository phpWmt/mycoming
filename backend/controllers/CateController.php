<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/15
 * Time: 15:18
 */
namespace backend\controllers;
use backend\models\Article;
use backend\models\ArticleCate;
use backend\traits\TreeTrait;
use Yii;
use backend\models\Cate;
use backend\models\GodownType;
use yii\data\Pagination;

class CateController extends CommonController {
    use TreeTrait;

    //添加分类
    public function actionCreate()
    {
        Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
        $post=Yii::$app->request->post();
        $model=empty($post['model'])?new Cate():new ArticleCate();
        $model->name=$post['name'];
        $model->sort=$post['sort'];
        $model->pid=$post['pid'];
        if($model->save(false)){
            return ['status' => 1, 'info' => '添加成功'];
        }
    }

    //添加子品牌
    public function actionAdd(){
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $image = $this->Upimg("files");  //img存储的图片字段
            if($image == '文件不存在'){
                Yii::$app->getSession()->setFlash('success', '请添加品牌图片！');
                return $this->redirect(['cate/list']);
            }else{
                $model = new ArticleCate();
                $model->name=$post['name'];
                $model->pid=$post['id'];
                $model->img=$image;
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', '添加成功！');
                    return $this->redirect(['cate/list']);
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
        $cate=TreeTrait::generateTree(Cate::find()->where(['apply'=>0])->asArray()->orderBy('sort ASC')->all());
        $article_cate=TreeTrait::generateTree(ArticleCate::find()->where(['apply'=>0])->asArray()->all());

        //查询申请的分类
        $modelCate = Cate::find();
        $modelCate->where(['is_show'=>2,'apply'=>1]);
        $count = $modelCate->count();
        $pagesCate = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $listCate = $modelCate
            ->offset($pagesCate->offset)
            ->limit($pagesCate->limit)
            ->asArray()
            ->all();

        //查询申请的品牌
        $modelArticle = ArticleCate::find();
        $modelArticle->where(['is_show'=>2,'apply'=>1]);
        $count = $modelArticle->count();
        $pagesArticle = new Pagination(['totalCount' => $count, 'pageSize' => 5]);
        $listArticle = $modelArticle
            ->offset($pagesArticle->offset)
            ->limit($pagesArticle->limit)
            ->asArray()
            ->all();

        return $this->render('list',['cate'=>$cate,'article_cate'=>$article_cate,'listCate'=>$listCate,'pagesCate'=>$pagesCate,'listArticle'=>$listArticle,'pagesArticle'=>$pagesArticle]);
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

        $model=new GodownType();
        $res=$model::findOne($post['id'])->delete();

        if ($res){
            return ['status' => 1, 'info' => '删除成功'];
        }
    }


    /*****************************************************************************************************************/
                                //分类 品牌 审核
    /*****************************************************************************************************************/

    //通过审核 分类
    public function actionStatus(){
        $get = Yii::$app->request->get();

        if(Yii::$app->request->isGet){
            $model = new Cate();
            $resule = $model->updateAll(['is_show'=>$get['status'],'apply'=>0],['id'=>$get['id']]);

            if($resule){
                Yii::$app->getSession()->setFlash('success', '审核通过！');
                return $this->redirect(['cate/list']);
            }

        }
    }


    //删除申请分类
    public function actionDel(){
        $request=Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
            $res = EntrepotGoodsSpec::deleteAll(['id' => $id]);
            if ($res) {
                return ['status' => 1, 'info' => '删除成功'];
            }
        }
    }


    //通过审核 品牌
    public function actionStatusBrand(){
        $get = Yii::$app->request->get();

        if(Yii::$app->request->isGet){
            $model = new ArticleCate();
            $resule = $model->updateAll(['is_show'=>$get['status'],'apply'=>0],['id'=>$get['id']]);

            if($resule){
                Yii::$app->getSession()->setFlash('success', '审核通过！');
                return $this->redirect(['cate/list']);
            }

        }
    }

    //删除申请分类
    public function actionDelBrand(){
        $request=Yii::$app->request;
        if ($request->isPost) {
            $id = $request->post('id');
            Yii::$app->response->format = Yii\web\Response::FORMAT_JSON;
            $res = ArticleCate::deleteAll(['id' => $id]);
            if ($res) {
                return ['status' => 1, 'info' => '删除成功'];
            }
        }
    }


}