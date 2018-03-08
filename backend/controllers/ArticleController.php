<?php

namespace backend\controllers;

use backend\models\Article;
use backend\traits\TreeTrait;
use yii\data\Pagination;
use Yii;
use yii\web\Response;
use backend\models\ArticleCate;

class ArticleController extends CommonController
{
    use TreeTrait;

    //显示页面
    public function actionContent(){
        $this->layout = false;
        $content = Article::find()->asArray()->all();
        return $this->render('content',['content'=>$content]);
    }

    //详细 显示页面
    public function actionArticleContent(){
        $this->layout = false;
        if (Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');
            $info = Article::find()->where(['id'=>$id])->asArray()->one();
            return $this->render('articleContent',['content'=>$info]);
        }
    }


    public function actionList()
    {
        $model = Article::find();

        $keyword = trim(\Yii::$app->request->get('keyword'));
        $cate = trim(\Yii::$app->request->get('cate_id'));

        if (!empty($keyword)) {
            $model->andWhere(['like', 'title', $keyword]);
        }

        if (!empty($cate)) {
            $model->andWhere(['cate_id' => $cate]);
        }

//        $model->joinWith('articleCate');

        $count = $model->count();

        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);

        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id DESC')
            ->andWhere(['status'=>1])
            ->asArray()
            ->all();
        $article_cate=TreeTrait::generateTree(ArticleCate::find()->asArray()->orderBy('sort ASC')->all());

        return $this->render('list',['list' => $list, 'pages' => $pages,'article_cate'=>$article_cate]);

    }


    //添加
    public function actionCreate()
    {

        $request=Yii::$app->request;
        if ($request->isPost) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post=$request->post();

            if (empty($post['content'])) {
                return ['status' => 2, 'info' => '文章内容不能为空'];
            }

            $article=new Article();
            $article->title=$post['title'];
            $article->content=$post['content'];
            $article->create_time=date('Y-m-d H:i:s', time());
            $article->status=1;
//            $article->cate_id=$post['cate_id'];
            $article->admin_id=Yii::$app->admin->id;
            $article->admin_username=Yii::$app->admin->identity->username;
            if ($article->save(false)) {
                return ['status' => 1, 'info' => '添加成功', 'url' => '/article/list'];
            }
        } else {
            $article_cate=TreeTrait::generateTree(ArticleCate::find()->asArray()->orderBy('sort ASC')->all());

            return $this->render('create',['article_cate'=>$article_cate]);
        }
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix" => Yii::$app->params['ADMIN_HOST'],//图片访问路径前缀 即后台域名
                    "imagePathFormat" => "/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                    "scrawlPathFormat" => "/uploads/scrawl/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "scrawlRoot" => Yii::getAlias("@webroot"),
                    "filePathFormat" => "/uploads/file/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "fileRoot" => Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }


    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $post=$request->post();
            $article=Article::findOne($post['id']);
            $article->title=$post['title'];
//            $article->cate_id=$post['cate_id'];
            $article->content=$post['content'];
            $article->update_time=date('Y-m-d H:i:s', time());
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($article->save()) {
                return ['status' => 1, 'info' => '更新成功', 'url' => '/article/list'];
            }else{
                return ['status' => 2, 'info' => '没做任何修改'];
            }
        } else {
            $data = Article::findOne($request->get('id'));
            $article_cate=TreeTrait::generateTree(ArticleCate::find()->asArray()->orderBy('sort ASC')->all());
            return $this->render('update', ['data' => $data,'article_cate'=>$article_cate]);
        }
    }


    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id_array=array_filter(explode(',',Yii::$app->request->post('id')));
        $models=Article::find()->where(['in','id',$id_array])->all();

        foreach ($models as $model){
            $model->status=2;
            $model->update(false);
        }

        Yii::$app->response->format=Response::FORMAT_JSON;
        return ['status'=>1,'info'=>'删除成功'];
    }


    /*删除编辑器上传的图片*/
    public function actionDelete_img($content)
    {
        //匹配并删除图片
        $img_path = "/<img.*src=\"([^\"]+)\"/U";
        $matches = array();
        preg_match_all($img_path, $content, $matches);
        foreach ($matches[1] as $img_url) {
            //strpos(a,b) 匹配a字符串中是否包含b字符串 包含返回true
            if (strpos($img_url, 'emoticons')===false) {
                $host = Yii::$app->params['ADMIN_HOST'];
                //去掉图片的域名前缀
                $filepath = str_replace($host, '', $img_url);

                //if($filepath == $img_url) $filepath = substr($img_url, 1);

                @unlink('.'.$filepath);
                $filedir  = dirname($filepath);
                $files = scandir('.'.$filedir);
                if (count($files)<=2) {
                    @rmdir('.'.$filedir);//如果是./和../,直接删除文件夹
                }
            }
        }
        unset($matches);
    }
}
