<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

use yii\bootstrap\Alert;

if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
}

?>
<?= \common\widgets\Alert::widget() ?>
<body class="gray-bg">

<!--订单评论-->
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>评论记录</h3>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"><b>评论用户</b></th>
                                <th class="text-center"><b>商品仓库</b></th>
                                <th class="text-center"><b>商品名称</b></th>
                                <th class="text-center"><b>商品图片</b></th>
                                <th class="text-center"><b>商品规格</b></th>
                                <th class="text-center"><b>评论内容</b></th>
                                <th class="text-center"><b>评论图片</b></th>
                                <th class="text-center"><b>好评/中评/差评</b></th>
                                <th class="text-center"><b>评论时间</b></th>
                                <th class="text-center"><b>显示/隐藏</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($listsComment)):foreach ($listsComment as $key => $value): ?>
                                <tr>

                                    <td align="center">
                                        <a href="<?php Url::to(['merchant-user/index','keyword'=>$value['user']['nickname']])?>" title="点击查看"><?php echo $value['user']['nickname']; ?></a>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['entrepot']['entrepot_name']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['goods']['title']; ?>
                                    </td>

                                    <td align="center">
                                        <img class="goods_img" src="<?php echo Yii::$app->params['API_HOST'].$value['goods']['cover']?>">
                                    </td>

                                    <td align="center">
                                        <?php echo $value['spec']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['content']; ?>
                                    </td>

                                    <td class="project-people">
                                        <?php $imgData = explode(',',$value['img']) ?>

                                        <?php if ($value['isImg'] == 1):?>
                                            <?php if(!empty($imgData)):foreach ($imgData as $v): ?>
                                                <a href="#">
                                                    <img alt="image" class="img-circle" src="<?php echo Yii::$app->params['API_HOST'].$v?>">
                                                </a>
                                            <?php endforeach;endif;?>
                                        <?php else:?>
                                            <a href="#">
                                                <img alt="image" class="img-circle" src="/img/svg/wechat.svg">
                                            </a>
                                        <?php endif;?>

                                    </td>

                                    <td align="center">
                                        <?php if($value['grade'] == 3):?>
                                            <a class="btn btn-xs btn-danger btn-outline btn-rounded"><i class="fa fa-heart"></i> 好评</a>
                                        <?php elseif ($value['grade'] == 2):?>
                                            <a class="btn btn-xs btn-warning btn-outline btn-rounded"><i class="glyphicon glyphicon-thumbs-up"></i> 中评</a>
                                        <?php else:?>
                                            <a class="btn btn-xs btn-default btn-outline btn-rounded"><i class="glyphicon glyphicon-thumbs-down"></i> 差评</a>&nbsp;
                                        <?php endif;?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['addTime']; ?>
                                    </td>

                                    <td align="center">

                                        <?php if($value['status'] == 1):?>
                                            <a href="<?php echo Url::to(['user/status-content','id'=>$value['id'],'status'=>0])?>" class="btn btn-xs btn-danger btn-rounded"><i class="fa fa-heart"></i> 隐藏</a>
                                        <?php else: ?>
                                            <a href="<?php echo Url::to(['user/status-content','id'=>$value['id'],'status'=>1])?>" class="btn btn-xs btn-primary btn-rounded"><i class="fa fa-pencil"></i> 显示</a>
                                        <?php endif;?>
                                    </td>

                                </tr>
                            <?php endforeach;endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--收款记录-->
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>收款记录</h3>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"><b>订单编号</b></th>
                                <th class="text-center"><b>付款方式</b></th>
                                <th class="text-center"><b>订单金额</b></th>
                                <th class="text-center"><b>实收款项</b></th>
                                <th class="text-center"><b>时间</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($listsPay)):foreach ($listsPay as $key => $value): ?>
                                <tr>

                                    <td align="center">
                                        <?php echo $value['order']['order_num']; ?>
                                    </td>

                                    <td align="center">
                                        <?php if($value['payment'] == 0):?>
                                            线下支付
                                        <?php elseif ($value['payment'] == 1):?>
                                            支付宝
                                        <?php else:?>
                                            微信
                                        <?php endif;?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['order_moner']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['pay_money']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['add_time']; ?>
                                    </td>

                                </tr>
                            <?php endforeach;endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--发货记录-->
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>发货记录</h3>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"><b>订单编号</b></th>
                                <th class="text-center"><b>商品</b></th>
                                <th class="text-center"><b>规格</b></th>
                                <th class="text-center"><b>价格</b></th>
                                <th class="text-center"><b>数量</b></th>
                                <th class="text-center"><b>时间</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($listsRecord)):foreach ($listsRecord as $key => $value): ?>
                                <tr>

                                    <td align="center">
                                        <?php echo $value['order']['order_num']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['goods']['title']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['spec']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['shop_price']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['shop_num']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['add_time']; ?>
                                    </td>

                                </tr>
                            <?php endforeach;endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--出入库记录-->
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>出入库记录</h3>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"><b>编号</b></th>
                                <th class="text-center"><b>订单编号</b></th>
                                <th class="text-center"><b>商品</b></th>
                                <th class="text-center"><b>数量</b></th>
                                <th class="text-center"><b>出库/入库</b></th>
                                <th class="text-center"><b>时间</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($listsDetailed)):foreach ($listsDetailed as $key => $value): ?>
                                <tr>

                                    <td align="center">
                                        <?php echo $value['number']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['order']['order_num']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['goods']['title']; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo $value['num']; ?>
                                    </td>

                                    <?php if($value["status"] == 1):?>
                                        <td align="center">
                                            <a class="btn btn-info btn-rounded btn-outline btn-xs">出库</a>
                                        </td>
                                    <?php else:?>
                                        <td align="center">
                                            <a class="btn btn-primary btn-rounded btn-outline btn-xs">入库</a>
                                        </td>
                                    <?php endif;?>

                                    <td align="center">
                                        <?php echo $value['add_time']; ?>
                                    </td>

                                </tr>
                            <?php endforeach; endif;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="wrapper-content animated fadeInRight"></div>
<?php
$js = <<<JS

    $(document).ready(function () {
        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"})
            // 全选
        $('.all-checks').on('ifChecked', function (event) {
            $("input[type='checkbox']").iCheck('check');
        });
        // 反选
        $('.all-checks').on('ifUnchecked', function (event) {
            $("input[type='checkbox']").iCheck('uncheck');
        });
    });

    $("#delete_all").click(function() {

        var id='';
        $('input[name="check"]:checked').each(function (i, obj) {
            id=$(obj).val()+','+id;
        });

        $(".myform").ajaxSubmit({
        url: "/room/update",
        type: "post",
        dataType: "json",
        success: function (data) {
            if(data.status === 1) {
                $("#update_status").text(data.info);
                setTimeout(function (){
               window.location.reload();
                }, 800);
            }else{
                $("#update_status").text(data.info);
            }
        }
        });
    });
    //状态更改

    $('.del').click(function() {

     var id = $(this).attr('id');
     alert(id)
      $.ajax({
            url:"/order/destroy",
            data:{id:id},
            type:"post",
            success:function(e) {
                if (e == 'success'){

                    var success=dialog({content: '操作成功'}).showModal();
                        setTimeout(function () {
                            success.close();
                            window.location.reload();
                        }, 1000);
                }else {
                    layer.msg('请重试');
                    setTimeout(function (){
                        window.location.reload();
                    }, 800);
                }
            }

      })
    })
JS;
$this->registerJs($js);
?>
</body>