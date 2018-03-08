<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/15
 * Time: 11:37
 */
namespace merchant\controllers;

use yii\data\Pagination;
use merchant\models\Log;
use Yii;
use yii\web\Response;
class LogController extends CommonController {

    public function actionList(){
        $model=Log::find();
        $get=Yii::$app->request->get();
        if (!empty($get['admin_username'])){
            $model->andWhere(['like','admin_username',$get['admin_username']]);
        }
        if (!empty($get['route'])){
            $model->andWhere(['like','route',$get['route']]);
        }
        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','created_at',$get['start_time'],$get['end_time']]);
        }
        $count=$model->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('list',['list'=>$list,'pages'=>$pages]);
    }

    public function actionContent(){
        $id=\Yii::$app->request->get('id');
        $data=Log::findOne($id);
        return $this->render('content',['content'=>$data->description]);
    }

    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id_array=array_filter(explode(',',Yii::$app->request->post('id')));

        $models=Log::find()->where(['in','id',$id_array])->all();

        foreach ($models as $model){
            $model->status=2;
            $model->update(false);
        }

        return ['status'=>1,'info'=>'删除成功'];
    }

}