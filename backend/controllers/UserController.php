<?php

namespace backend\controllers;


use backend\models\User;
use backend\traits\AdminTrait;
use merchant\models\Clientele;
use backend\models\Comment;
use Yii;
use yii\data\Pagination;
use yii\web\Response;
use backend\models\Feedback;
use backend\models\Message;
use backend\models\Coupon;
use backend\models\Order;
use backend\models\Address;

class UserController extends CommonController
{
    use AdminTrait;
    protected $user;
    protected $request;

    public function init()
    {
        $this->user    = User::find();
        $this->request = \Yii::$app->request;
    }


    /**用户列表
     *
     * @return string
     */
    public function actionList()
    {

        $this->user->where(['is_delete'=>1]);

        $lists = $this->user->all();
        $page  = new Pagination(['totalCount' => $this->user->count(), 'pageSize' => 15]);
        $lists = $this->user->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('id DESC')->all();

        return $this->render('lists', ['lists' => $lists, 'pages' => $page]);
    }


    /**
     * 回收站
     *
     * @return string
     */
    public function actionListDelete()
    {

        $get = $this->request->get();

        if (!empty($get['status'])){
            $this->user->andWhere(['status'=>$get['status']]);
        }

        if (!empty($get['keyword'])){
            $this->user->andwhere(['or',
                ['like', 'phone', trim($get['keyword'])],
                ['like', 'nickname', trim($get['keyword'])]
            ]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $this->user->andWhere(['between','create_time',$get['start_time'],$get['end_time']]);
        }

        $this->user->andWhere(['is_delete'=>0]);

        $page  = new Pagination(['totalCount' => $this->user->count(), 'pageSize' => 15]);
        $lists = $this->user->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('id DESC')->all();


        return $this->render('listDelete', ['lists' => $lists, 'pages' => $page]);
    }



    /**
     *更新用户数据
     */
    public function actionUpdate()
    {
        if(Yii::$app->request->isPost){
        $post = Yii::$app->request->post();

            $image = $this->Upimg("files");  //img存储的图片字段
            //实例化
            $model = new User();
            if($image == '文件不存在'){
                $res = $model->updateAll(
                    [
                        'phone'=>$post['phone'],
                        'nickname'=>$post['nickname'],
                        'update_time'=>date('Y-m-d H:i:s',time()),
                    ],
                    ['id'=>$post['id']]);
                if($res){
                    Yii::$app->getSession()->setFlash('success', '修改成功！');
                    return $this->redirect(['user/list']);
                }

            }else{
                $res = $model->updateAll(
                    [
                        'cover'=>$image,
                        'phone'=>$post['phone'],
                        'nickname'=>$post['nickname'],
                        'update_time'=>date('Y-m-d H:i:s',time()),
                    ],
                    ['id'=>$post['id']]);
                if($res){
                    Yii::$app->getSession()->setFlash('success', '修改成功！');
                    return $this->redirect(['user/list']);
                }
            }
        }else{
            $id = Yii::$app->request->get('id');
            //查询用户
            $list = User::find()->where(['id'=>$id])->asArray()->one();

            return $this->render('update', ['list' => $list,'id'=>$id]);
        }

    }




    /**用户详情
     * @return string
     */
    public function actionShow()
    {

        $user_id   = $this->request->get('id'); //用户ID
        //实例化
        $model = User::find();


        $lists = $model->where(["is_delete"=>1,'id'=>$user_id])
            ->orderBy('id DESC')
            ->asArray()
            ->one();

        //查询该用户的评论
        $coment = Comment::find();
        $comentList = $coment->where(['user_id'=>$user_id])->asArray()->all();

        return $this->render('show', ['lists' => $lists,'comentList'=>$comentList]);

    }


    /**搜索用户
     *
     * @return string
     */
    public function actionSearch()
    {
        $get = $this->request->get();

        if (!empty($get['status'])){
            $this->user->andWhere(['status'=>$get['status']]);
        }

        if (!empty($get['keyword'])){
            $this->user->andwhere(['or',
                ['like', 'phone', trim($get['keyword'])],
                ['like', 'nickname', trim($get['keyword'])]
            ]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $this->user->andWhere(['between','create_time',$get['start_time'],$get['end_time']]);
        }

        $this->user->andWhere(['is_delete'=>1]);

        $page  = new Pagination(['totalCount' => $this->user->count(), 'pageSize' => 15]);
        $lists = $this->user->offset($page->offset)
            ->limit($page->limit)->orderBy('id DESC')->all();


        return $this->render('lists', ['lists' => $lists, 'pages' => $page]);
    }


    /**
     *修改用户状态
     */
    public function actionStatus()
    {
        $id     = $this->request->get('id');
        $status = $this->request->get('status');

        $conn  = Yii::$app->db;
        $lists = $conn->createCommand("UPDATE dyd_user SET status = $status WHERE id = $id");

        if($lists->execute()){
            Yii::$app->getSession()->setFlash('success', '修改成功！');
            return $this->redirect(['user/list']);
        }else{
            Yii::$app->getSession()->setFlash('success', '修改失败！');
            return $this->redirect(['user/list']);
        }

    }

    public function actionCount()
    {
        return $this->render('count');
    }


    //加入回收站 还原
    public function actionDelete(){
        $post = Yii::$app->request->post();
        if(Yii::$app->request->isPost){
            $model = new User();
            $res = $model->updateAll(['is_delete'=>$post['is_delete']],['id'=>$post['id']]);
            //修改仓库表的用户状态
             $clientele = new Clientele();
             $clientele->updateAll(['is_del'=>$post['is_delete']],['user_id'=>$post['id']]);

            if($res){
                //处理json串
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ['status'=>1,'info'=>'状态修改成功！'];
            }
        }
    }


    //彻底删除用户
    public function actionDel(){
        $post = Yii::$app->request->post();

        if(Yii::$app->request->isPost){
            //删除用户
            $result = User::deleteAll(['id'=>$post['id']]);

            //删除仓库用户
            Clientele::deleteAll(['user_id'=>$post['id']]);

            //删除用户评论
            Comment::deleteAll(['user_id'=>$post['id']]);

            //删除用户优惠卷
            Coupon::deleteAll(['user_id'=>$post['id']]);

            //删除用户反馈
            Feedback::deleteAll(['user_id'=>$post['id']]);

            //删除系统通知消息
            Message::deleteAll(['user_id'=>$post['id']]);

            //删除用户订单
            Order::deleteAll(['user_id'=>$post['id']]);

            //删除收货地址
            Address::deleteAll(['user_id'=>$post['id']]);

            if($result){
                //处理json串
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ['status'=>1,'info'=>'删除成功！'];
            }
        }
    }





    //评论状态修改
    public function actionStatusContent(){
        $get= Yii::$app->request->get();
        if(Yii::$app->request->isGet){
            //实例化
            $model = new Comment();
            $res = $model->updateAll(['status'=>$get['status']],['id'=>$get['id']]);
            if($res){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['order/comment']);
            }
        }
    }



    //用户反馈
    public function actionFeedback(){
        $model = Feedback::find();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();

            //修改恢复状态
             $modelStatus = new Feedback();
             $modelStatus->updateAll(['status'=>1],['id'=>$post['id']]);

            //添加回复信息
            $m_model = new Message();
            $m_model->user_id = $post['user_id'];
            $m_model->type = 0;
            $m_model->title = "反馈内容回复";
            $m_model->info =  $post['info'];
            $m_model->addTime =  date('Y-m-d H:i:s',time());
            if($m_model->save(false)){
                Yii::$app->getSession()->setFlash('success', '回复成功！');
                return $this->redirect(['user/feedback']);
            }
            //推送
            tuisong($post['user_id'],"反馈内容回复"," $post[info]",1);

        }else{
            $get=Yii::$app->request->get();

            if (!empty($get['keyword'])){
                $model->where(['like','dyd_feedback.content',trim($get['keyword'])]);
            }

            $model->joinWith('user');
            $count = $model->count();
            $pages = new Pagination(['totalCount' => $count, 'pageSize' => 15]);
            $list = $model
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();
            return $this->render('feedback', ['lists' => $list, 'pages' => $pages]);
        }

    }

    //删除反馈信息
    public function actionFeedbackDelete(){

        $res = Feedback::deleteAll(['id' => Yii::$app->request->post('id')]);

        Yii::$app->response->format=Response::FORMAT_JSON;

        if($res){
            return ['status'=>1,'info'=>'删除成功'];
        }else{
            return ['status'=>2,'info'=>'删除失败'];
        }

    }


}
