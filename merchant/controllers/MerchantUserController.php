<?php

namespace merchant\controllers;


use merchant\models\User;
use merchant\traits\AdminTrait;
use merchant\models\Clientele;
use merchant\models\Comment;
use Yii;
use yii\data\Pagination;
use yii\web\Response;

class MerchantUserController extends CommonController
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
        //仓库ID
        $entrepot_id = Yii::$app->admin->getIdentity()['entrepot'];

        //实例化
        $model = Clientele::find();

        $keyword = Yii::$app->request->get('keyword');

        if(!empty($keyword)){
            $model->andwhere(['or',
                ['like', 'dyd_user.phone', trim($keyword)],
                ['like', 'dyd_user.nickname', trim($keyword)]
            ]);
        }

        $model->joinWith('user');//仓库
        $model->andwhere(["dyd_clientele.entrepot_id"=>$entrepot_id,'dyd_clientele.is_del'=>1]);
        $count = $model->count();
        $page  = new Pagination(['totalCount' =>$count, 'pageSize' => 15]);

        $lists = $model->offset($page->offset)
            ->limit($page->limit)
            ->orderBy('id DESC')
            ->asArray()
            ->all();

        return $this->render('lists', ['lists' => $lists, 'pages' => $page]);
    }


    /**
     *更新用户数据
     */
    public function actionUpdate()
    {

        $conn  = Yii::$app->db;
        $model = new User();
        $model->load(\Yii::$app->request->post());
        $model->setScenario('create');
        if ($model->validate()) {
            $id = $this->request->post('User')['id'];

            if ($conn->createCommand()->update('shop_user', $this->request->post('User'), 'id=' . $id)->execute()) {
                Yii::$app->getSession()->setFlash('success', '修改成功');
                $this->redirect(['user/list']);
            }
        } else {

        }

    }



    /**用户详情
     * @return string
     */
    public function actionShow()
    {

        $id   = $this->request->get('id'); //仓库表用户ID

        $user_id   = $this->request->get('user_id'); //用户ID

        //实例化
        $model = Clientele::find();

        $model->joinWith('user');//仓库

        $lists = $model->where(["dyd_clientele.id"=>$id])
            ->orderBy('id DESC')
            ->asArray()
            ->one();

        //查询该用户的评论
        $coment = Comment::find();
        $comentList = $coment->where(['user_id'=>$user_id,'entrepot_id'=>Yii::$app->admin->getIdentity()['entrepot']])->asArray()->all();

        return $this->render('show', ['lists' => $lists,'comentList'=>$comentList]);

    }



//    /**搜索用户
//     *
//     * @return string
//     */
//    public function actionSearch()
//    {
//        $keyword = $this->request->get('keyword');
//
//        $this->user->andwhere(['or',
//                               ['like', 'phone', $keyword],
//                               ['like', 'username', $keyword],
//                               ['like', 'nickname', $keyword]
//        ]);
//
//        $page  = new Pagination(['totalCount' => $this->user->count(), 'pageSize' => 15]);
//        $lists = $this->user->offset($page->offset)
//            ->limit($page->limit)->orderBy('id DESC')->all();
//
//        return $this->render('lists', ['lists' => $lists, 'pages' => $page]);
//    }

    /**
     *修改用户状态
     */
    public function actionStatus()
    {
        $id     = $this->request->post('id');
        $status = $this->request->post('status');

        $conn  = Yii::$app->db;
        $lists = $conn->createCommand("UPDATE shop_user SET status = $status WHERE id = $id");
        echo $lists->execute();
    }

    public function actionCount()
    {
        return $this->render('count');
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
               return $this->redirect(['merchant-order/comment']);
           }
       }
    }


    //添加备注
    public function actionRemark(){
        $post = Yii::$app->request->post();
        if(Yii::$app->request->isPost){
            //实例化
            $model = new Clientele();
            $res = $model->updateAll(['remark'=>$post['content']],['id'=>$post['id']]);
            if($res){
                Yii::$app->getSession()->setFlash('success', '备注成功！');
                return $this->redirect(['merchant-user/list']);
            }
        }
    }

    //删除客户
    public function actionDelete(){
        $post = Yii::$app->request->post();
        if(Yii::$app->request->isPost){
            $model = new Clientele();
            $res = $model->updateAll(['is_del'=>0],['id'=>$post['id']]);
            if($res){
                //处理json串
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ['status'=>1,'info'=>'删除成功！'];
            }
        }
    }



}
