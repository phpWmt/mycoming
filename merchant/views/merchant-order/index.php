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
                        <a data-toggle="tab" href="<?php echo Url::to(['merchant-order/index','order_status'=>'00'])?>" aria-expanded="true">
                            <img class="setting_logo" src="/img/svg/wechat.png"/>&nbsp;&nbsp;&nbsp;全部
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" onclick='location.href="<?php echo Url::to(['merchant-order/index','order_status'=>'01'])?>"' href="" aria-expanded="false">
                            <img class="setting_logo" src="/img/svg/alipay.png"/>&nbsp;&nbsp;&nbsp;待发货
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab" onclick='location.href="<?php echo Url::to(['merchant-order/index','order_status'=>1])?>"' href="" aria-expanded="false">
                            <img class="setting_logo" src="/img/svg/sms_yzx.png"/>&nbsp;&nbsp;&nbsp;待收货
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab"  onclick='location.href="<?php echo Url::to(['merchant-order/index','order_status'=>2])?>"'  href="" aria-expanded="false">
                            <img class="setting_logo" src="/img/svg/sms_dpj.png"/>&nbsp;&nbsp;&nbsp;待评价
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab"  onclick='location.href="<?php echo Url::to(['merchant-order/index','order_status'=>3])?>"' href="">
                            <img class="setting_logo" src="/img/svg/sms_ok.png"/>&nbsp;&nbsp;&nbsp;已完成
                        </a>
                    </li>

                    <li class="">
                        <a data-toggle="tab"  onclick='location.href="<?php echo Url::to(['merchant-order/index','order_status'=>4])?>"' href="" >
                            <img class="setting_logo" src="/img/svg/sms_no.png"/>&nbsp;&nbsp;&nbsp;已取消
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
                                            <form method="get" action="/merchant-order/index">
                                                <div class="input-group list-group col-sm-6">
                                                    <input type="text" name="keyword" placeholder="请输订单号"
                                                           class="input-sm form-control">
                                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>
                                                </div>
                                            </form>
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
                                                <th class="text-center"><b>订单编号</b></th>
                                                <th class="text-center"><b>购买用户</b></th>
                                                <th class="text-center"><b>订单价格</b></th>
                                                <th class="text-center"><b>支付运费</b></th>
                                                <th class="text-center"><b>所属仓库</b></th>
                                                <th class="text-center"><b>订单状态</b></th>
                                                <th class="text-center"><b>下单时间</b></th>
                                                <th class="text-center"><b>操作</b></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($lists as $key => $value): ?>
                                                <tr style="height: 60px">
                                                    <td align="center">
                                                        <label class="checkbox-inline i-checks">
                                                            <b><?php echo $value->id; ?></b>
                                                        </label>
                                                    </td>
                                                    <td align="center">
                                                        <b><?php echo $value->order_num; ?></b>
                                                    </td>
                                                    <td align="center" style="color: #3d4d5d">
                                                        <?php echo $value->user->nickname ? $value->user->nickname : '暂无昵称'; ?>
                                                    </td>
                                                    <td align="center">
                                                        <button type="button"  class="btn btn-success del btn-xs btn-outline btn-rounded">
                                                             <?php echo $value->price; ?>
                                                        </button>

                                                    </td>
                                                    <td align="center">
                                                        <button type="button"  class="btn btn-success del btn-xs btn-outline btn-rounded">
                                                             <?php echo $value->freight; ?>
                                                        </button>

                                                    </td>
                                                    <td align="center">
                                                             <?php echo $value->entrepot->entrepot_name; ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php echo \merchant\models\Order::return_status($value->order_status) ?>
                                                    </td>
                                                    <td align="center">
                                                        <?php echo $value->create_time; ?>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <b><i class='glyphicon glyphicon-dashboard'></i>&nbsp;<?php \merchant\models\order::return_time($value['create_time'])?></b>

                                                    </td>
                                                    <td align="center">
                                                        <?php if($value['order_status'] != 0):?>
                                                            <a href="  <?php echo Url::to(['merchant-order/look', 'id' => $value->id]) ?>">
                                                                <button type="button" class="btn btn-warning btn-xs btn-outline btn-rounded"><i
                                                                            class="glyphicon glyphicon-calendar"></i>&nbsp;明细/评论
                                                                </button>
                                                            </a>
                                                        <?php else:?>
                                                            <a>
                                                                <button type="button" class="btn  btn-xs btn-outline btn-rounded">
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </button>
                                                            </a>
                                                        <?php endif;?>

                                                        <?php if($value['order_status'] == 0):?>
                                                            <a href="  <?php echo Url::to(['merchant-order/show', 'id' => $value->id]) ?>">
                                                                <button type="button" class="btn btn-info btn-xs btn-outline btn-rounded">
                                                                    <i class="glyphicon glyphicon-edit"></i>&nbsp;订单发货
                                                                </button>
                                                            </a>
                                                        <?php else:?>
                                                            <a href="  <?php echo Url::to(['merchant-order/show', 'id' => $value->id]) ?>">
                                                                <button type="button" class="btn btn-success btn-xs btn-outline btn-rounded">
                                                                    <i class="glyphicon glyphicon-folder-close"></i>&nbsp;订单详情
                                                                </button>
                                                            </a>
                                                        <?php endif;?>
                                                        <button type="button" id="<?php echo $value->id ?>" class="btn btn-danger del btn-xs btn-outline btn-rounded"><i class="glyphicon glyphicon-trash"></i>&nbsp;删除</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <div class="col-sm-12 page">
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
            $(".del").click(function () {
            var id = $(this).attr('id'); //订单ID
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要删除该订单吗？请谨慎操作！',
                ok: function () {
                      $.ajax({
                        url:"/merchant/merchant-order/destroy",
                        data:{id:id},
                        type:"post",
                        success:function(data) {
                        if(data.status === 1) {
                            var status=dialog({content: data.info}).showModal();
                            setTimeout(function (){
                            status.close();
                            dele.closest('tr').remove();
                            }, 800);
                            window.location.reload()
                     }else{ 
                            dialog({title: "提示",content: data.info,ok: true}).showModal();
                        } 
                        }
        
                    })
                },
                cancel: true
            });
            d.showModal();
        });
JS;
$this->registerJs($js);
?>