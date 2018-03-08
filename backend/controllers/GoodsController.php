<?php
/**
 * Created by PhpStorm.
 * User: twitf
 * Date: 2017/9/6
 * Time: 13:19
 */
namespace backend\controllers;

use backend\models\Cate;
use backend\models\ArticleCate;
use backend\models\Entrepot;
use backend\models\Goods;
use backend\models\Spec; //商品规格表
use backend\models\AloneSpec; //子商品规格表
use backend\models\GodownType;//库存类型

//出入库模型
use backend\models\EntrepotGoods;//仓库入库商品
use backend\models\EntrepotGoodsSpec;//商品入库规格子表
use backend\models\EntrepotSpec;//商品入库规格表
use backend\models\EntrepotGoodsClassify;//仓库商品分类
use backend\models\Godown;//入库订单表
use backend\models\GodownDetail;//出入库明细

use backend\traits\TreeTrait;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\data\Pagination;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;


class GoodsController extends CommonController {
    use TreeTrait;
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix" => Yii::$app->params['ADMIN_HOST'],//图片访问路径前缀 即后台域名
                    "imagePathFormat" => "/uploads/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                    "fileUrlPrefix" => Yii::$app->params['ADMIN_HOST'],//图片访问路径前缀 即后台域名
                    "filePathFormat" => "/uploads/file/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "fileRoot" => Yii::getAlias("@backend").'/web',
                ],
            ]
        ];
    }




    //商品列表
    public function actionList(){
        $model = Goods::find();

        $get=Yii::$app->request->get();

        if (!empty($get['keyword'])){
            $model->andWhere(['like','dyd_goods.title',trim($get['keyword'])]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','dyd_goods.create_time',$get['start_time'],$get['end_time']]);
        }

        if (!empty($get['cate_id'])){
            $cate=Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all();
            if (!empty($cate)){
                $cate=array_column(Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all(),'id');
                $model->andWhere(['in','cate_id',$cate]);
            }else{
                $model->andWhere(['cate_id'=>$get['cate_id']]);
            }
        }

        if (!empty($get['brand_id'])){
            $cate=ArticleCate::find()->select('id')->where(['pid'=>$get['brand_id']])->asArray()->all();
            if (!empty($cate)){
                $cate=array_column(ArticleCate::find()->select('id')->where(['pid'=>$get['brand_id']])->asArray()->all(),'id');
                $model->andWhere(['in','brand_id',$cate]);
            }else{
                $model->andWhere(['brand_id'=>$get['brand_id']]);
            }
        }

        $model->andWhere(['dyd_goods.status'=>1]);

        $model->joinWith('cate');  //分类
        $model->joinWith('brand');//品牌
        $model->joinWith('entrepot');//仓库
        $count = $model->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 15]);
        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id desc')
            ->asArray()
            ->all();


//        $commandQuery = clone $model; //$model 实例化的对象
//        echo $commandQuery->createCommand()->getRawSql();


        $cate=TreeTrait::generateTree(Cate::find()->where(['is_show'=>1])->asArray()->orderBy('sort ASC')->all());
        $article_cate=TreeTrait::generateTree(ArticleCate::find()->where(['is_show'=>1])->asArray()->orderBy('sort ASC')->all());

        return $this->render('list', ['list' => $list, 'pages' => $pages,'cate'=>$cate,'article_cate'=>$article_cate]);
    }





    //添加商品
    public function actionCreate(){
        $request=Yii::$app->request;

        if ($request->isPost){
            //处理json串
            Yii::$app->response->format=Response::FORMAT_JSON;
            //接受post数据
            $post=$request->post();

            if (!empty($post['paramName'])){
                return $this->actionUpload($post['paramName']);
            }else{
                if(empty($post['cover'])){
                    return ['status'=>2,'info'=>'封面图片不能为空'];die;
                }
                if (empty($post['img'])){
                    return ['status'=>2,'info'=>'商品图片不能为空'];die;
                }

                //添加商品
                $model =new Goods();
                $model->cover=implode(',',array_filter($post['cover']));
                $model->img=implode(',',array_filter($post['img']));
                $model->info=$post['content'];
                $model->cate_id=$post['cate_id'];
                $cate_name = Cate::find()->where(['id' => $post['cate_id']])->select('name')->one();
                $model->cate_name = $cate_name['name'];
                $model->brand_id=$post['brand_id'];
                $brand_name = ArticleCate::find()->where(['id' => $post['brand_id']])->select('name')->one();
                $model->brand_name=$brand_name['name'];
                $model->list_price=$post['list_price'];
                $model->title=$post['title'];
                $model->create_time=date('Y-m-d H:i:s',time());
                //添加商品 false不验证
                $result = $model->save(false);
                //返回商品ID
                $id = $model->attributes['id'];

                //返回添加商品规格
                if ($result){
                    return ['status'=>1,'info'=>'添加成功,请添加商品规格！','url'=>Url::to(['goods/add-spec?id='.$id])];
                }
            }
        }else{
            $model=new Goods();
            $cate=TreeTrait::generateTree(Cate::find()->where(['is_show'=>1])->asArray()->orderBy('sort ASC')->all());
            $article_cate=TreeTrait::generateTree(ArticleCate::find()->where(['is_show'=>1])->asArray()->orderBy('sort ASC')->all());
            $entrepot = Entrepot::find()->where(['status'=>1,'is_delete'=>1])->asArray()->select('id,entrepot_name')->all();
            return $this->render('create',['model'=>$model,'cate'=>$cate,'article_cate'=>$article_cate,'entrepot'=>$entrepot]);
        }
    }






    //添加一级商品规格
    public function actionAddSpec(){
        $request=Yii::$app->request;
        if($request->isGet){
            $id = $request->get('id'); //商品ID
            return $this->render('addSpec',['id'=>$id]);
        }else{
            $post = $request->post();
            $goodsId = $post['id'];

            //将两个数组合并为一个数组
            $a= $post['name'];
            $b= $post['spec'];
            foreach($a as $key=>$val){

                $data[$key]['name']=$a[$key];

                $data[$key]['spec']= str_replace("，",",","$b[$key]");
            }
            //实例化
            $spec = new Spec();
            foreach ($data as $value){
                $_Spec  = clone $spec; //克隆对象
                $_Spec->goods_id = $post['id'];
                $_Spec->name = $value['name'];
                $_Spec->spec = $value['spec'];
                $result = $_Spec->save(false);
            }

            //处理json串
            Yii::$app->response->format=Response::FORMAT_JSON;

            //返回
            if ($result){
                return ['status'=>1,'info'=>'添加成功','url'=>Url::to(['goods/add-list?id='.$goodsId])];
            }
        }
    }



    //添加 详细商品规格 详细信息
    public function actionAddList(){
        $request=Yii::$app->request;
        if($request->isGet) {
            $id = $request->get('id');

             //查询出该商品的一级规格
             $spec = Spec::find()->where(['goods_id'=>$id])->select('spec')->asArray()->all();

             $specName = array_column(Spec::find()->where(['IN','goods_id',$id])->select('name')->asArray()->all(),'name');

             //一级规格
             if(count($specName) == 1){
                 foreach ($spec as $value){
                     $dataSpec = explode(",",$value['spec']);
                 }
                 //拼接
                 $strName = '';
                 foreach ($specName as $value){
                     $strName .= $value." ";
                 }

             }else{
                 //多规格
                 // 定义集合
                 foreach ($spec as $key=>$value){
                     $sets[] =  explode(',',$value['spec']);
                 }

                 //计算多个集合的笛卡尔积
                 //返回所有规格合集
                 $dataSpec = $this->CartesianProduct($sets);

                 //拼接
                 $strName = '';
                 foreach ($specName as $value){
                     $strName .= $value." ";
                 }
             }

            return $this->render('addList', ['id' => $id,'dataSpec'=>$dataSpec,'strName'=>$strName]);
        }else{
            $post = $request->post();
            $goodsId = $post['id'];

            //将多个一维数组拼接成一个二维数组
            $a= $post['spec'];
            $b= $post['price'];
            $c= $post['total_num'];
            foreach($a as $key=>$val){
                $data[$key]['goods_id']=$goodsId;

                $data[$key]['spec']=$a[$key];

                $data[$key]['price']=$b[$key];

                $data[$key]['total_num']=$c[$key];
            }
            $result = $this->spec($data,$goodsId);

            //处理json串
            Yii::$app->response->format=Response::FORMAT_JSON;

            //返回
            if ($result){
                return ['status'=>1,'info'=>'商品规格添加成功','url'=>Url::to(['goods/list'])];
            }
        }
    }


    //删除一级规格 重新添加
    public function actionRemove(){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $id = Yii::$app->request->get('id');

        $result = Spec::deleteAll(['goods_id'=>$id]);

        //返回添加商品规格
        if ($result){
            Yii::$app->getSession()->setFlash('success', '删除成功,请添加商品规格！');
            return $this->redirect(['goods/add-spec?id='.$id]);
        }

    }


    //商品库 修改商品
    public function actionUpdate(){
        $request=Yii::$app->request;
        if ($request->isPost){
            \Yii::$app->response->format=\Yii\web\Response::FORMAT_JSON;
            $post=$request->post();
            if (!empty($post['paramName'])){
                return $this->actionUpload($post['paramName']);
            }else{

                if(empty($post['cover'])){
                    return ['status'=>2,'info'=>'封面图片不能为空'];
                }

                if (empty($post['img'])){
                    return ['status'=>2,'info'=>'轮播图片不能为空'];
                }
                $img=implode(',',array_filter($post['img']));

                $model =Goods::findOne($post['id']);
                $model->cover=implode(',',array_filter($post['cover']));
                $model->img=implode(',',array_filter($post['img']));
                $model->info=$post['info'];
                $model->cate_id=$post['cate_id'];
                $cate_name = Cate::find()->where(['id' => $post['cate_id']])->select('name')->one();
                $model->cate_name = $cate_name['name'];
                $model->brand_id=$post['brand_id'];
                $brand_name = ArticleCate::find()->where(['id' => $post['brand_id']])->select('name')->one();
                $model->brand_name=$brand_name['name'];
                $model->list_price=$post['list_price'];
                $model->title=$post['title'];
                $model->create_time=date('Y-m-d H:i:s',time());
                if ($model->save(false)){
                    return ['status'=>1,'info'=>'修改成功','url'=>Url::to(['goods/list'])];
                }
            }
        }else{
            $id=$request->get('id');

            $data=Goods::findOne($id);
            $cate=TreeTrait::generateTree(Cate::find()->asArray()->orderBy('sort ASC')->all());
            $article_cate=TreeTrait::generateTree(ArticleCate::find()->where(['is_show'=>1])->asArray()->orderBy('sort ASC')->all());
            return $this->render('update',['data'=>$data,'cate'=>$cate,'article_cate'=>$article_cate]);
        }
    }



    /**
     *  商品规 规格管理
     *
     */

    //商品库 规格管理
    public function actionSpecList(){
        $request=Yii::$app->request;
        if($request->isGet) {
            //商品ID
            $id = $request->get('id');

            //查询出一级
            $goods_spec_list = Spec::find()->where(['goods_id'=>$id])->asArray()->all();

            //查询出改商品的子规格
            $model = AloneSpec::find();

            //搜索
            if(!empty($request->get('keyword'))){
                $model->andWhere(['like', 'dyd_goods_alone_spec.spec',trim($request->get('keyword'))]);
            }

            $model->joinWith('goods');
            $goods_spec = $model->andWhere(['dyd_goods_alone_spec.goods_id'=>$id])->asArray()->all();
            return $this->render('specList',['goods_spec'=>$goods_spec,'goods_spec_list'=>$goods_spec_list,'goods_id'=>$id]);

        }

    }


    //商品库 修改子规格状态
    public function actionSpecStatus(){
        $get = Yii::$app->request->get();

        if(Yii::$app->request->isGet){

            $model = new AloneSpec();

            $resule = $model->updateAll(['status'=>$get['status']],['id'=>$get['id']]);

            if($resule){
                Yii::$app->getSession()->setFlash('success', '修改成功！');
                return $this->redirect(['goods/spec-list?id='.$get['goods_id']]);
            }

        }

    }


    //删除商品子规格
    //删除规格 减商品库存
    public function actionGoodsDeleteSpec(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $post =$request->post();

            //删除 商品库入库商品规格
            $result1 = AloneSpec::deleteAll(['id'=>$post['id']]);

            //商品库 减库存
            $postGods = Goods::findOne($post['goods_id']);  //实例化模型。传条件ID
            $postGods->updateCounters(['repertory'=>"-$post[num]"]);  //updateCounters 实现 减法 给负值：

            Yii::$app->response->format=Response::FORMAT_JSON;

            if ($result1){
                return ['status'=>1,'info'=>'删除成功'];
            }else{
                return ['status'=>2,'info'=>'删除失败'];
            }
        }
    }

    //增加库存 修改价格
    public function actionAddPermissions(){
        if(Yii::$app->request->isPost){
            Yii::$app->response->format=Response::FORMAT_JSON;
            $post = Yii::$app->request->post();

            //增加商品子规格 库存
            $postGods = AloneSpec::findOne($post['id']);  //实例化模型。传条件ID
            $postGods->updateCounters(['num'=>"$post[num]"]); //剩余库存
            $res1 = $postGods->updateCounters(['total_num'=>"$post[num]"]);//该规格总库存

            //增加商品库商品 库存
            $postGods = Goods::findOne($post['goods_id']);  //实例化模型。传条件ID
            $postGods->updateCounters(['repertory'=>"$post[num]"]); //剩余库存
            $res2 = $postGods->updateCounters(['total'=>"$post[num]"]);//该商品总库存

            //修改价格
            $model = new AloneSpec();
            $res3 = $model->updateAll(['price'=>$post['price']],['id'=>$post['id']]);

            //返回
            if($res1 && $res2 || $res3){
                return ['status'=>1,'info'=>'新增成功！'];
            }

        }
    }



    /**
     * php 计算多个集合的笛卡尔积
     * Date: 2017-01-10
     * Author: fdipzone
     * Ver: 1.0
     *
     * Func
     * CartesianProduct 计算多个集合的笛卡尔积
     */

    /**
     * 计算多个集合的笛卡尔积
     * @param Array $sets 集合数组
     * @return Array
     */
    function CartesianProduct($sets){

        // 保存结果
        $result = array();

        // 循环遍历集合数据
        for($i=0,$count=count($sets); $i<$count-1; $i++){

            // 初始化
            if($i==0){
                $result = $sets[$i];
            }

            // 保存临时数据
            $tmp = array();

            // 结果与下一个集合计算笛卡尔积
            foreach($result as $res){
                foreach($sets[$i+1] as $set){
                    $tmp[] = $res.','.$set;
                }
            }

            // 将笛卡尔积写入结果
            $result = $tmp;

        }

        return $result;

    }




    //添加商品规格 写入数据库
    public function spec($specs,$id){
        //子商品规格
        $AloneSpec = new AloneSpec();
          $num = '';
          foreach ($specs as $value){//规格
              //添加子商品规格 false不验证
              $_model = clone $AloneSpec; //克隆对象
              $_model->goods_id = $value['goods_id'];
              $_model->spec = $value['spec'];
              $_model->price = $value['price'];
              $_model->num = $value['total_num'];
              $_model->total_num = $value['total_num'];
              $num += $value['total_num'];
              $_model->add_time = date('Y-m-d H:i:s',time());
              $result = $_model->save(false);
          }
            //商品表
            $Goods = new Goods(); //子商品规格
            $resGoods = $Goods->updateAll(['repertory'=>$num,'total'=>$num],['id'=>$id]);

            if(!$resGoods){
                return ['status'=>2,'info'=>'商品数量添加失败！'];die;
            }
            //返回
            if ($result){
                return true;
            }else{
                return ['status'=>2,'info'=>'商品规格添加失败'];die;
            }

    }





/****************************************************************************************************************************************************/
/*******************************************************************商品出入库************************************************************************/
/****************************************************************************************************************************************************/
    /**
     * 商品出入库

     * @return 单个商品入库多个仓库

     * @return array|string
     */
    public function actionGodown(){

        $request=Yii::$app->request;

        if ($request->isPost){
            //处理json串
            Yii::$app->response->format=Response::FORMAT_JSON;
            //接受post数据
            $post=$request->post();

            //判断商品入库数量
            $countEntrepot = count($post['entrepot']);//店铺数量
            $repertory = $post['repertory'];//该商品剩余库存

            //判断入库数量
            $num = "";
            foreach ($post['total_num'] as $value){
                $num +=$value;
            }

            //入库库存总数
            //商品库存*店铺总数
            $totalNum = $num*$countEntrepot;


            //入库库存总数不能大于商品剩余库存
            if($totalNum > $repertory){
                return ['status'=>2,'info'=>"<B style='text-align:center;color: red'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;入库失败,该商品库存不足!</B></br>剩余库存:<B>$repertory</B>.入库总数为:<B>$totalNum</B></br>入库店铺数:<B>$countEntrepot</B>.单个店铺入库:<B>$num</B>"];die;
            }


            //将两个一维数组合并为一个二维数组
            $a= $post['spec_id'];

            $b= $post['total_num'];

            foreach($a as $key=>$val){

                $data[$key]['spec_id']=$a[$key];

                $data[$key]['total_num']=$b[$key];
            }

            $model=AloneSpec::find();
            $modelSpec=Spec::find();
            //该商品子商品规格
            $arr=ArrayHelper::index($model->where(['IN','id',array_column($data,'spec_id')])->groupBy('id')->asArray()->all(),'id');
            //该商品规格
            $arrSpec= array_column($modelSpec->where(['IN','goods_id',$post['goods_id']])->select('name')->asArray()->all(),'name');

            //查询出每个规格
            foreach ($data as $key => $value){
                if (array_key_exists($value['spec_id'],$arr)){
                    $arr[$value['spec_id']]['add_total_num']=$value['total_num'];
                }
            }


            /**
             *  商品入库
             *
             *  循环输出仓库
             *
             *  判断：入库商品不能重复
             */
            foreach ($post['entrepot'] as $value) {
                //查询出仓库名
                $entrepotName = Entrepot::find()->where(['id'=>$value])->select('entrepot_name')->asArray()->one();

                 //判断仓库是否已入库该商品
                 $goodRersult = EntrepotGoods::find()->where(['entrepot_id'=>$value,'goods_id'=>$post['goods_id']])->select('id')->asArray()->one();

                  //判断
                  if(empty($goodRersult)){

                      $result = $this->entrepotGoods($value, $post, $arr, $totalNum, $countEntrepot, $arrSpec);

                  }else{
                      return ['status'=>2,'info'=>"<B style='text-align:center;color: red'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$entrepotName[entrepot_name]</b> 已入库该商品,不可重复入库！</B>"];

                      return true;
                  }

            }


            //返回
            if ($result) {
                return ['status'=>1,'info'=>"<b>$entrepotName[entrepot_name]</b> 商品入库成功!",'url'=>Url::to(['goods/list'])];
            } else {
                return ['status' => 2, 'info' => '商品入库失败'];
                die;
            }


            }else{
            //商品ID
            $id = Yii::$app->request->get('id');

            $entrepot = Entrepot::find()->where(['status'=>1,'is_delete'=>1])->asArray()->select('id,entrepot_name')->all(); //仓库

            $Goods = Goods::find()->where(['id'=>$id])->asArray()->one(); //商品

            $AloneSpec = AloneSpec::find()->where(['goods_id'=>$id])->asArray()->all(); //商品规格

            $GodownType = GodownType::find()->where(['is_show'=>1])->asArray()->select('id,name')->all(); //库存类型

            return $this->render('godown',['goods'=>$Goods,'AloneSpec'=>$AloneSpec,'entrepot'=>$entrepot,'GodownType'=>$GodownType]);
        }
    }




    /**
     * 商品入库
     * @param $entrepotId  仓库ID
     * @param $post    商品数据
     * @param $spec   商品规格
     *  @param $totalNum   该商品入库数量
     *  @$countEntrepot   店铺数量
     *  @$arrSpec   一级规格
     */
    public function entrepotGoods($entrepotId,$post,$spec,$totalNum,$countEntrepot,$arrSpec){

        $EntrepotGoods = new EntrepotGoods();
        $EntrepotGoods->godown_id = "IN".-date('Ymd',time())."-".rand(1,10000);
        $EntrepotGoods->entrepot_id = $entrepotId;
        $EntrepotGoods->classify_id = $post['classify_id'];
        $EntrepotGoods->brand_id = $post['brand_id'];
        $EntrepotGoods->goods_id = $post['goods_id'];
        $EntrepotGoods->title = $post['title'];
        $EntrepotGoods->is_recom = $post['is_recom'];
        if(!empty($post['recom_reason'])){ //推荐原因
            $EntrepotGoods->recom_reason = $post['recom_reason'];
        }
        $EntrepotGoods->godown_type = $post['godown_type'];
        $EntrepotGoods->admin_name = Yii::$app->admin->getIdentity()['username'];
        $EntrepotGoods->addTime = date('Y-m-d H:i:s');

        //入库总数量
        $num = "";
        foreach ($post['total_num'] as $value){
            $num +=$value;
        }
        $EntrepotGoods->total_num = $num;

        //入库后剩余库存
        $EntrepotGoods->num = $num;

        //入库
        $result = $EntrepotGoods->save(false);

        //仓库入库商品ID
        $goods_id = $EntrepotGoods->attributes['id'];


        if(!empty($goods_id)){
            //实例化
            $Goods = new Goods(); //商品表
            //公式 商品剩余库存 = （$num 该仓库入库总数量） * 仓库数量
            $repertory = $post['repertory']-$num*$countEntrepot;
            //仓库入库成功 减去商品库存
            $Goods->updateAll(['repertory'=>$repertory],['id'=>$post['goods_id']]);


            //添加规格
            $this->specValue($goods_id,$entrepotId,$spec,$arrSpec);

            //添加子规格
            $this->entrepotGoodsSpec($goods_id,$entrepotId,$spec,$countEntrepot);

            //店铺分类
            $this->entrepotGoodsClassify($entrepotId,$post['classify_id']);

            //出入库明细
            $this->godownDetail($entrepotId,$post);
        }

        //返回
        if ($result){
            return true;
        }else{
            return ['status'=>2,'info'=>'添加商品入库失败'];die;
        }

    }




    /**
     * 拼接 页面显示规格
     * @param $id   商品ID
     * @param $entrepotId    仓库ID
     * @param $arr   商品规格
     * @$arrSpec   一级商品规格
     */
    public function specValue($id,$entrepotId,$arr,$arrSpec){
        //循环拼接出商品子规格
        $specValue = [];
        foreach ($arr as $key=>$value){
            $specValue[] = explode(',',$value['spec']);
        }

        //相同规格拼接
        $arrValue=array();
        foreach($specValue as $k=>$v) {
            foreach ($v as $key => $val) {
                $arrValue[$key][] = $val;
            }
        }

        //合并拼接
        $str = '';
        $num1=count($arrValue);
        for($i=0;$i<$num1;$i++) {
            $num2 = count($arrValue[0]);
            for ($j = 0; $j < $num2; $j++) {
                $str  .= $arrValue[$i][$j].",";
            }
            $str  .= '%,';
        }


        $newstr = substr($str,0,strlen($str)-3);
        //逗号分割的字符串转换成数组，去重后，转换回以逗号分割的字符串
        $strA = explode(',%,',$newstr);
        $strDd = [];
        foreach ($strA as $strVal){
            $strDd[] =   implode(',',array_unique(explode(',',$strVal)));;
        }


        //拼接数组
        $a= $strDd;
        $b= $arrSpec;
        foreach($a as $key=>$val){
            $dValue[$key]['name']=$b[$key];

            $dValue[$key]['key']=$a[$key];
        }

        //添加规格
        $model = new EntrepotSpec();

        foreach ($dValue as $value){
            $_model  = clone $model; //克隆对象
            $_model->goods_id = $id;
            $_model->entrepot_id = $entrepotId;
            $_model->name = $value['name'];
            $_model->spec = $value['key'];
            $_model->addTime = date('Y-m-d H:i:s',time());
            $result = $_model->save(false);
        }

        //返回
        if($result){
            return true;
        }else{
            return ['status'=>2,'info'=>'商品规格入库失败'];die;
        }

    }



    /**
     * 添加商品规格
     *
     * @param $id     仓库入库商品ID
     * @param $entrepotId  店铺ID
     * @param $spec    规格数据
     *@param $countEntrepot    店铺总数
     *
     */
    public function entrepotGoodsSpec($id,$entrepotId,$spec,$countEntrepot){
        //实例化
        $EntrepotGoodsSpec = new EntrepotGoodsSpec(); //仓库子商品规格
        $AloneSpec = new AloneSpec(); //子商品规格

        //每个规格循环添加
         foreach ($spec as $value){
             $_model  = clone $EntrepotGoodsSpec; //克隆对象
             $_model->entrepot_id = $entrepotId;
             $_model->spec_id = $value['id'];
             $_model->good_id = $id;
             $_model->sepc = $value['spec'];
             $mumber = $value['add_total_num']*$countEntrepot;
             $_model->num = $mumber;
             $_model->price = $value['price'];
             $_model->total_num = $value['add_total_num'];
             $_model->status = 1;
             $_model->addTime = date('Y-m-d H:i:s',time());
             $result = $_model->save(false);
             //修改子商品规格 库存数量
             $resGoods = $AloneSpec->updateAll(['num'=>$value['num']-$mumber],['id'=>$value['id']]);
         }

         //返回
         if($result && $resGoods){
             return true;
         }else{
             return ['status'=>2,'info'=>'商品规格入库失败'];die;
         }

    }

    //仓库商品分类
    public function entrepotGoodsClassify($entrepotId,$classify_id){
        //查询 该仓库有此分类不添加
        $res  = EntrepotGoodsClassify::find()->where(['entrepot_id'=>$entrepotId,'classify_id'=>$classify_id])->asArray()->one();
        if(!$res){
            $EntrepotGoodsClassify = new EntrepotGoodsClassify();
            $_model  = clone $EntrepotGoodsClassify; //克隆对象
            $_model ->entrepot_id = $entrepotId;
            $_model ->classify_id = $classify_id;
            $_model->status = 1;
            $_model->addTime = date('Y-m-d H:i:s',time());
            $result = $_model->save(false);
            //返回
            if($result){
                return true;
            }else{
                return ['status'=>2,'info'=>'仓库入库分类失败'];die;
            }
        }



    }


    //添加 入库明细
    public function godownDetail($entrepotId,$post){

        $GodownDetail = new GodownDetail();

        $_model  = clone $GodownDetail; //克隆对象

         //入库规格
        $specStr = '';
         foreach ($post['spec_id'] as $specId){
             $specStr .= $specId.',';
         }

        //入库
        $_model->number = "IN".-date('Ymd',time())."-".rand(1,10000);
        $_model->goods_id = $post['goods_id'];
        $_model->spec = substr($specStr,0,strlen($specStr)-1);
        $_model->entrepot_id = $entrepotId;
        $_model->godown_type = $post['godown_type'];
        $num = '';
        foreach ($post['total_num'] as $value){
            $num += $value;
        }
        $_model->add_num = '+'.$num;

        $_model->number_num = $num;

        $_model->status = 2;
        $result = $_model->save(false);

        //出库明细
        $this->outDetail($entrepotId,$post);

        //返回
        if($result){
            return true;
        }else{
            return ['status'=>2,'info'=>'仓库入库明细添加失败'];
        }

    }

    //添加 出库明细
    public function outDetail($entrepotId,$post){
        $GodownDetail = new GodownDetail();
        $_model  = clone $GodownDetail; //克隆对象
        //出入库规格
        $specStr = '';
        foreach ($post['spec_id'] as $specId){
            $specStr .= $specId.',';
        }

        //出库
        $_model->number = "OUT".-date('Ymd',time())."-".rand(1,10000);
        $_model->goods_id = $post['goods_id'];
        $_model->spec = substr($specStr,0,strlen($specStr)-1);
        $_model->entrepot_id = $entrepotId;
        $_model->godown_type = $post['godown_type'];
        $num = '';
        foreach ($post['total_num'] as $value){
            $num += $value;
        }
        $_model->num = '-'.$num;
        $_model->number_num = $post['repertory']-$num;
        $_model->status = 1;
        $results = $_model->save(false);
        //返回
        if($results){
            return true;
        }else{
            return ['status'=>2,'info'=>'仓库出库明细添加失败'];
        }
    }



    //出入库明细列表
    public function actionListDetail(){
        $model = GodownDetail::find();

        $get=Yii::$app->request->get();
        if (!empty($get['keyword'])){
            $model->andWhere(['like','dyd_godown_detail.number',trim($get['keyword'])]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','dyd_godown_detail.add_time',$get['start_time'],$get['end_time']]);
        }
        if (!empty($get['status'])){
            $model->andWhere(['dyd_godown_detail.status'=>$get['status']]);
        }



        $model->joinWith('goods');  //商品表
        $model->joinWith('entrepot');  //商品表
        $model->joinWith('godownType');  //入库类型
        $count = $model->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 15]);
        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id desc')
            ->asArray()
            ->all();

        return $this->render('listDetail', ['list' => $list,'pages'=>$pages]);
    }

     //删除出入库记录
     public function actionRecordDelete(){

         $res = GodownDetail::deleteAll(['id' => Yii::$app->request->post('id')]);

         Yii::$app->response->format=Response::FORMAT_JSON;

         if($res){
             return ['status'=>1,'info'=>'删除成功'];
         }else{
             return ['status'=>2,'info'=>'删除失败'];
         }

  }


    //库存列表
    public function actionGoodsInventory(){
        $model = EntrepotGoodsSpec::find();

        $get=Yii::$app->request->get();

        if (!empty($get['keyword'])){
            $model->andWhere(['like','dyd_entrepot_goods.title',$get['keyword']]);
        }

        if (!empty($get['entrepot_id'])){
            $model->andWhere(['like','dyd_entrepot_goods_spec.entrepot_id',$get['entrepot_id']]);
        }

        if (!empty($get['spec'])){
            $model->andWhere(['like','dyd_entrepot_goods_spec.sepc',trim($get['spec'])]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','create_time',$get['start_time'],$get['end_time']]);
        }

        if (!empty($get['cate_id'])){
            $cate=Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all();
            if (!empty($cate)){
                $cate=array_column(Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all(),'id');
                $model->andWhere(['in','cate_id',$cate]);
            }else{
                $model->andWhere(['cate_id'=>$get['cate_id']]);
            }
        }


        $model->joinWith('entrepot');  //仓库

        $model->joinWith('goods');  //商品

        $count = $model->count();

        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 15]);

        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id desc')
            ->asArray()
            ->all();

        //查询所有仓库
        $entrepot = Entrepot::find()->select('id,entrepot_name')->asArray()->all();

        return $this->render('goodsInventory', ['list' => $list,'pages'=>$pages,'entrepot'=>$entrepot]);
    }



    //商品库存 子规格增加库存
    public function actionSpecIncrease(){
        $id = Yii::$app->request->get('Add_id'); //仓库规格ID

        $return_id = Yii::$app->request->get('id');


        if(Yii::$app->request->isPost){
            //增加
            $post = Yii::$app->request->post();

            //仓库规格ID
            $entrepot_spec_id = $post['entrepot_spec_id'];
            //商品库规格ID
            $goods_spec_id = $post['goods_spec_id'];
            //新增数量
            $num = $post['number'];

            //加库存
            //仓库商品规格加库存
            $postGods = EntrepotGoodsSpec::findOne($entrepot_spec_id);  //实例化模型。传条件ID
            $postGods->updateCounters(['num'=>"$num"]);  //updateCounters 实现 减法 给负值：
            $postGods->updateCounters(['total_num'=>"$num"]);  //updateCounters 实现 减法 给负值：
            //查询仓库商品ID
            $entrepot_goods_id = EntrepotGoodsSpec::find()->where(['id'=>$entrepot_spec_id])->asArray()->select('id,good_id')->one();//仓库商品ID
            //仓库商品加库存
            $EntrpotGods = EntrepotGoods::findOne($entrepot_goods_id['good_id']);  //实例化模型。传条件ID
            $EntrpotGods->updateCounters(['num'=>"$num"]);
            $EntrpotGods->updateCounters(['total_num'=>"$num"]);



            //减库存
            //减去商品库的规格库存
            $goodsGods = AloneSpec::findOne($goods_spec_id);  //实例化模型。传条件ID
            $goodsGods->updateCounters(['num'=>"-$num"]);  //updateCounters 实现 减法 给负值：
            //查询商品库ID
            $goods_goods_id = AloneSpec::find()->where(['id'=>$goods_spec_id])->asArray()->select('goods_id')->one();//商品库ID
            //给商品库减库存
            $goods_Gods = Goods::findOne($goods_goods_id['goods_id']);  //实例化模型。传条件ID
            $res = $goods_Gods->updateCounters(['repertory'=>"-$num"]);

            //返回
            if($res){
                Yii::$app->getSession()->setFlash('success', '新增库存成功！');
                return $this->redirect(['goods/goods-inventory']);
            }


        }else{
            $model = EntrepotGoodsSpec::find();
            //子规格
            $model->joinWith('entrepot');  //仓库

            $model->joinWith('goods');  //商品

            $model->where(['dyd_entrepot_goods_spec.id'=>$id]);  //条件

            $list = $model->orderBy('id desc')
                ->asArray()
                ->one();

            //查询商品库该规格剩余数量
            $spec = EntrepotGoodsSpec::find()->where(['id'=>$id])->asArray()->select('spec_id')->one();

            $specNum = AloneSpec::find()->where(['id'=>$spec['spec_id']])->asArray()->select('id,num,status')->one();

            if($specNum['num'] == 0){
                Yii::$app->getSession()->setFlash('success', '商品库-该规格剩余库存剩余：<b>'.$specNum['num']."</b>&nbsp;无法添加！");
                return $this->redirect(['goods/goods-inventory']);
            }

            if($specNum['status'] == 0){
                Yii::$app->getSession()->setFlash('success', '商品库-该规格已被冻结无法添加！');
                return $this->redirect(['goods/goods-inventory']);
            }

            return $this->render('specDetail',['id'=>$id,'list'=>$list,'specNum'=>$specNum['num'],'goods_id'=>$specNum['id']]);
        }
    }





/*************************************************************************************************************************************************/
    public function actionAjaxReturn($status,$info){
        \Yii::$app->response->format=\Yii\web\Response::FORMAT_JSON;
        return ['status'=>$status,'info'=>$info];
    }



    //上传商品图片
    public function actionUpload($name){

        $uploadedFile=UploadedFile::getInstancesByName($name);

        $img_info=[];
        foreach ($uploadedFile as $k=>$v){
            if ($v === null || $v->hasError) {
                return '文件不存在';
            }
            //创建时间
            $ymd = date("Ymd");
            //存储到本地的路径
            $save_path = \Yii::getAlias('@api') . '/web/uploads/admin_img/' . $ymd .'/';
            //存储到数据库的地址
            $save_url = '/uploads' . '/admin_img/' . $ymd . '/';

            if (!file_exists($save_path)) {
                mkdir($save_path, 0777, true);
            }
            //图片名称
            $file_name = $v->getBaseName();
            //图片格式
            $file_ext = $v->getExtension();
            //新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            //图片信息
            $v->saveAs($save_path . $new_file_name);

            $img_info[]=$save_url.$new_file_name;
            //$img_info[$name.'['.$k.']']=['path' => $save_path, 'url' => $save_url, 'name' => $file_name, 'new_name' => $new_file_name, 'ext' => $file_ext];
        }
        Yii::$app->response->format=Response::FORMAT_JSON;
        return $img_info;
    }


    public function actionDeleteImg(){
            $post=Yii::$app->request->post();
            @unlink(Yii::getAlias('@backend').'/web'.$post['url']);
            $filedir  = dirname($post['url']);
            $files = @scandir(Yii::getAlias('@backend').'/web'.$filedir);
            if (count($files)<=2) {
                @rmdir(Yii::getAlias('@backend').'/web'.$filedir);//如果是./和../,直接删除文件夹
            }
            Yii::$app->response->format=Response::FORMAT_JSON;
            return ['status'=>1];
    }



    //回收站
    public function actionUpdateDelete(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $id=$request->post('id');

            $model = new Goods();

            $resule = $model->updateAll(['status'=>2],['id'=>$id]);

            Yii::$app->response->format=Response::FORMAT_JSON;

            if ($resule){
                return ['status'=>1,'info'=>'加入回收站成功！'];
            }else{
                return ['status'=>2,'info'=>'加入回收站失败'];
            }
        }
    }


    //回收站列表
    public function actionRecycle(){
        $model = Goods::find();

        $get=Yii::$app->request->get();



        if (!empty($get['keyword'])){
            $model->andWhere(['like','dyd_goods.title',trim($get['keyword'])]);
        }

        if (!empty($get['start_time'])&&!empty($get['end_time'])){
            $model->andWhere(['between','dyd_goods.create_time',$get['start_time'],$get['end_time']]);
        }

        if (!empty($get['cate_id'])){
            $cate=Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all();
            if (!empty($cate)){
                $cate=array_column(Cate::find()->select('id')->where(['pid'=>$get['cate_id']])->asArray()->all(),'id');
                $model->andWhere(['in','cate_id',$cate]);
            }else{
                $model->andWhere(['cate_id'=>$get['cate_id']]);
            }
        }

        if (!empty($get['brand_id'])){
            $cate=ArticleCate::find()->select('id')->where(['pid'=>$get['brand_id']])->asArray()->all();
            if (!empty($cate)){
                $cate=array_column(ArticleCate::find()->select('id')->where(['pid'=>$get['brand_id']])->asArray()->all(),'id');
                $model->andWhere(['in','brand_id',$cate]);
            }else{
                $model->andWhere(['brand_id'=>$get['brand_id']]);
            }
        }


        $model->andWhere(['dyd_goods.status'=>2]);

        $model->joinWith('cate');  //分类
        $model->joinWith('brand');//品牌
        $model->joinWith('entrepot');//仓库
        $count = $model->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $list = $model
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id desc')
            ->asArray()
            ->all();


//        $commandQuery = clone $model; //$model 实例化的对象
//        echo $commandQuery->createCommand()->getRawSql();


        $cate=TreeTrait::generateTree(Cate::find()->where(['is_show'=>1])->asArray()->orderBy('sort ASC')->all());
        $article_cate=TreeTrait::generateTree(ArticleCate::find()->where(['is_show'=>1])->asArray()->orderBy('sort ASC')->all());

        return $this->render('recycle', ['list' => $list, 'pages' => $pages,'cate'=>$cate,'article_cate'=>$article_cate]);
    }



    //回收站 批量删除
    public function actionDelete(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $id=$request->post('id');

            $id_array=array_filter(explode(',',$id));



            foreach ($id_array as $id){
                //删除商品
                Goods::deleteAll(['id' => $id]);
                //删除一级规格
                Spec::deleteAll(['goods_id' => $id]);
                //删除子规格
                AloneSpec::deleteAll(['goods_id' => $id]);
                //山出入库明细
                GodownDetail::deleteAll(['goods_id' => $id]);

                //查询入库商品
                $res = $this->entrepotDelete($id);
            }
            Yii::$app->response->format=Response::FORMAT_JSON;
            if ($res){
                return ['status'=>1,'info'=>'删除成功'];
            }else{
                return ['status'=>2,'info'=>'该商品不存在'];
            }
        }
    }


    //批量删除删除入库的商品
    public function entrepotDelete($id){
        $res = EntrepotGoods::find()->where(['goods_id'=>$id])->asArray()->all();
        foreach ($res as $value){
            //删除入库商品
            $res1 = EntrepotGoods::deleteAll(['id' => $value['id']]);

            //删除入库一级规格
            $res2 = EntrepotSpec::deleteAll(['goods_id' => $value['id']]);

            //删除入库规格
            $res3 = EntrepotGoodsSpec::deleteAll(['good_id' => $value['id']]);

            //返回
            if($res1 &&  $res2 &&  $res3){
               return true;
            }else{
                Yii::$app->response->format=Response::FORMAT_JSON;
                return ['status'=>2,'info'=>'入库商品删除失败！'];
            }

        }
    }


    //查看规格
    public function actionLookSpec(){
        $spec = Yii::$app->request->get();

        return $this->render('lookSpec',['spec'=>$spec]);
    }




    //回收站 还原
    public function actionUpdateRestore(){
        $request=Yii::$app->request;
        if ($request->isPost){
            $id=$request->post('id');

            $model = new Goods();

            $resule = $model->updateAll(['status'=>1],['id'=>$id]);

            Yii::$app->response->format=Response::FORMAT_JSON;

            if ($resule){
                return ['status'=>1,'info'=>'还原成功！'];
            }else{
                return ['status'=>2,'info'=>'还原失败'];
            }
        }
    }







    /*********************************************************************
     * @return array|string
     * 配置方法
     */

    /**
     * @param $image
     * @param $width
     * @param $height
     * @param string $mode
     * @return ImageInterface|static*创建一个缩略图。
     *
     如果一个缩略维度被设置为“null”，另一个则根据纵横比自动计算
     *原始图像。注意，在本例中，计算的缩略图维度可能因源图像而异。
     *
     如果两个维度都被指定，那么得到的缩略图将恰好是指定的宽度和高度。它是如何
     *实现取决于模式。
     *
     *如果使用“ImageInterface::THUMBNAIL_OUTBOUND”模式,这是违约,缩略图是这样
     *最小的边等于原始图像中对应边的长度。以外的多余
     *缩放缩略图的区域将被裁剪，返回的缩略图将有精确的宽度和高度
     *指定。
     *
     *如果缩略图模式是‘ImageInterface::THUMBNAIL_INSET’,原始图像完全是按比例缩小它
     *包含在缩略图尺寸内。其余的都是可以通过的背景填充的
     [图像:$ thumbnailBackgroundColor]]and[[Image:$ thumbnailBackgroundAlpha]]。
     *
     * @ param字符串|资源| ImageInterface $ image图像接口，资源或包含文件路径的字符串
     * @param int $宽度的宽度以像素为创建缩略图
     * @param int $ height以像素为单位创建缩略图
     * @ param字符串$ mode模式，以在指定的宽度和高度的情况下调整原始图像的大小
     * @return ImageInterface
     */
    private static function thumbnail($image, $width, $height, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND){
       Image::thumbnail($image,100,100,ManipulatorInterface::THUMBNAIL_INSET)
           ->save(Yii::getAlias('@backend/web/uploads/test.jpg'),['quality' => 100]);
    }

    /**
     * 文字水印
     * @param $image 图片路径
     * @param $text  文字水印内容
     * @param $fontFile 水印字体文件存放路径
     * @param array $start 水印开始位置
     * @param array $fontOptions 水印配置
     */
    private static function text($image, $text, $fontFile='@backend/web/fonts/msyh.ttc',$start=[10,10],$fontOptions=['size'=>15,'color'=>'1BB394']){
        Image::text($image,'老司机666',$fontFile,$start,$fontOptions)
            //quality 图片生成质量
            ->save(Yii::getAlias('@backend/web/uploads/text.jpg'),['quality' => 100]);
    }

    /**
     * 图片水印
     * @param $image 图片路径
     * @param $watermarkImage 水印图片路径
     * @param array $start 开始位置
     */
    private static function watermark($image, $watermarkImage, $start = [0, 0]){
        Image::watermark($image,$watermarkImage, $start)
            ->save('@backend/web/uploads/watermark.jpg',['quality' => 100]);
    }



    /**
     * 裁剪图片
     * @param $image  图片路径
     * @param $width  裁剪的宽度
     * @param $height 裁剪的高度
     * @param array $start 开始位置
     */
    private static function crop($image, $width, $height, $start = [0, 0]){
        Image::crop($image, $width, $height, $start)
            ->save('@backend/web/uploads/crop.jpg',['quality' => 100]);
    }


}