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

$css=<<<CSS
.setting_logo{
    width: 50px;
    height: 40px;
}
h3 {
    color: #000;
    font-weight: 600;
}
CSS;
$this->registerCss($css);
?>
<?= \common\widgets\Alert::widget() ?>
    <div class="col-sm-12">
        <div class="panel blank-panel">

            <div class="panel-heading">
                <div class="panel-title m-b-md">
                    <h3><i class="fa fa-cog">　</i>订单管理</h3>
                </div>
                <div class="panel-options">

                    <ul class="nav nav-tabs">

                        <li class="active">
                            <a data-toggle="tab" onclick='location.href="<?php echo Url::to(['merchant-order/comment','grade'=>3])?>"' href="" aria-expanded="true">
                                <img class="setting_logo" style="height: inherit" src="/img/svg/good.png"/>&nbsp;&nbsp;&nbsp;好评
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" onclick='location.href="<?php echo Url::to(['merchant-order/comment','grade'=>2])?>"' href="" aria-expanded="false">
                                <img class="setting_logo" style="height: inherit" src="/img/svg/middle.png"/>&nbsp;&nbsp;&nbsp;中评
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" onclick='location.href="<?php echo Url::to(['merchant-order/comment','grade'=>1])?>"' href="" aria-expanded="false">
                                <img class="setting_logo" style="height: inherit" src="/img/svg/poor.png"/>&nbsp;&nbsp;&nbsp;差评
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- start-->
            <div class="panel-body">
                <div id="width" class="tab-pane active">
                    <div  class="tab-pane">
                        <div class="col-sm-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-sm-5 p-m">
<!--                                                <form method="get" action="/merchant-order/index">-->
<!--                                                    <div class="input-group list-group col-sm-6">-->
<!--                                                        <input type="text" name="keyword" placeholder="请输订单号"-->
<!--                                                               class="input-sm form-control">-->
<!--                                                        <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>-->
<!--                                                    </div>-->
<!--                                                </form>-->
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center" width="6%">
                                                        <label class="checkbox-inline i-checks">
                                                            <input type="checkbox" class="all-checks">
                                                        </label>
                                                    </th>
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
                                                        <td class="text-center" width="6%">
                                                            <label class="checkbox-inline i-checks">
                                                                <input type="checkbox" class="all-checks">
                                                            </label>
                                                        </td>
                                                        <td align="center">
                                                            <a href="<?php echo Url::to(['merchant-user/list','keyword'=>$value['user']['nickname']])?>" title="点击查看"><?php echo $value['user']['nickname']; ?></a>
                                                        </td>

                                                        <td align="center">
                                                            <?php echo $value['entrepot']['entrepot_name']; ?>
                                                        </td>

                                                        <td align="center">
                                                            <a href="<?php echo Url::to(['merchant-goods/list','keyword'=>$value['goods']['title']])?>" title="点击查看"><?php echo $value['goods']['title']; ?></a>
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
                                                            <?php $imgData = explode('*',$value['img']) ?>

                                                            <?php if ($value['isImg'] == 1):?>
                                                                <?php if(!empty($imgData)):foreach ($imgData as $v): ?>
                                                                    <a class="fancybox img-circle"  href="<?php echo Yii::$app->params['API_HOST'].$v?>" title="评论图">
                                                                        <img alt="image" src="<?php echo Yii::$app->params['API_HOST'].$v?>">
                                                                    </a>
                                                                <?php endforeach;endif;?>
                                                            <?php else:?>
                                                                <a href="#">
                                                                    无图片
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
                                                                <a href="<?php echo Url::to(['merchant-user/status-content','id'=>$value['id'],'status'=>0])?>" class="btn btn-xs btn-danger btn-rounded"><i class="glyphicon glyphicon-remove"></i>&nbsp; 隐藏</a>
                                                            <?php else: ?>
                                                                <a href="<?php echo Url::to(['merchant-user/status-content','id'=>$value['id'],'status'=>1])?>" class="btn btn-xs btn-primary btn-rounded"><i class="glyphicon glyphicon-ok"></i>&nbsp; 显示</a>
                                                            <?php endif;?>
                                                        </td>

                                                    </tr>
                                                <?php endforeach;endif; ?>
                                                </tbody>
                                            </table>
                                            <div class="col-sm-6 page">
                                                <span><strong><?php echo $page->totalCount; ?></strong>条记录</span>
                                                <div class="pull-right">
                                                    <?= LinkPager::widget([
                                                        'pagination'     => $page,
                                                        'nextPageLabel'  => '下一页',
                                                        'prevPageLabel'  => '上一页',
                                                        'firstPageLabel' => '首页',
                                                        'lastPageLabel'  => '尾页',
                                                    ]); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--stop-->


                </div>
            </div>

        </div>
    </div>
    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="/js/content.min.js?v=1.0.0"></script>
    <script src="/js/plugins/fancybox/jquery.fancybox.js"></script>
    <script>
        $(document).ready(function(){$(".fancybox").fancybox({openEffect:"none",closeEffect:"none"})});
    </script>
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
    //删除

    $('.del').click(function() {
     var id = $(this).attr('id'); //订单ID
      $.ajax({
            url:"/merchant-order/destroy",
            data:{id:id},
            type:"post",
            success:function(data) {
            if(data.status === 1) {
                var status=dialog({content: data.info}).showModal();
                setTimeout(function (){
                status.close();
                dele.closest('tr').remove();
                }, 800);
            }else{ 
                dialog({title: "提示",content: data.info,ok: true}).showModal();
            } 
            }

      })
    })
JS;
$this->registerJs($js);
?>