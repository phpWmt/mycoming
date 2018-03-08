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
<?= \common\widgets\Alert::widget()?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>发放优惠卷-用户列表</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-5 p-m">
                            <form method="get" action="/user/search">
                                <div class="input-group list-group col-sm-6">
                                    <input type="text" name="keyword" placeholder="请输入手机号、昵称" class="input-sm form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary">搜索</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <p>
                        <button style="width: 50%" type="button" class="btn btn-block  btn-primary btn-outline" id="add_user">
                            <i class="glyphicon glyphicon-user"></i>&nbsp;共有客户<?php echo count($lists)?>人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <i class="glyphicon glyphicon-th-list"></i>&nbsp;<b>优惠卷:&nbsp;</b><?php echo $coupon['name']?>&nbsp;&nbsp;
                            <b >购物满：
                            <?php echo($coupon["full_price"]); ?>&nbsp;元
                             可抵扣：
                            <?php echo($coupon["cat_price"]); ?>&nbsp;元
                            </b>
                        </button>
                    </p>

                    <a href="<?php echo Url::to(['coupon/add-coupon','id'=>$id])?>" style="width: 50%" type="button" class="btn btn-block  btn-primary" ><i class="glyphicon glyphicon-plus"></i>&nbsp;全部发放</a>




                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center" width="6%">
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" class="all-checks">
                                    </label>
                                </th>
                                <th class="text-center">头像</th>
                                <th class="text-center">手机号</th>
                                <th class="text-center">昵称</th>
                                <th class="text-center">状态</th>
                                <th class="text-center">是否已发放</th>
                                <th class="text-center">注册时间</th>
                                <th class="text-center">上次登录时间</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (is_array($lists)): foreach ($lists as $k => $v): ?>
                                <tr>
                                    <td align="center">
                                        <label class="checkbox-inline i-checks">
                                            <input type="checkbox" value="<?php echo $v->id ?>">
                                        </label>
                                    </td>
                                    <td align="center">
                                        <img class="goods_img" src="<?php echo Yii::$app->params['API_HOST'].$v->cover; ?>">
                                    </td>
                                    <td align="center">
                                        <?php echo $v->phone; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $v->nickname; ?>
                                    </td>
                                    <td align="center">
                                        <?php if ($v->status == 1): ?>
                                            <a href="javascript:;" class="status off" id="<?php echo $v->id; ?>"
                                               title="账户正常">
                                                <i class="fa fa-lg fa-check text-navy" data-status="1"></i>
                                            </a>
                                        <?php elseif ($v->status == 2): ?>
                                            <a href="javascript:;" class="status" id="<?php echo $v->id; ?>"
                                               title="账户锁定则不允许登录">
                                                <i class="fa fa-lg fa-lock text-warning" data-status="0"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>

                                    <td align="center">
                                        <?php echo \backend\models\Coupon::return_status($v->id,$id)?>
                                    </td>

                                    <td align="center">
                                        <?php echo $v->create_time; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $v->last_time; ?>
                                    </td>

                                    <td align="center">

                                        <button data-id="<?php echo $v['id'] ?>"  data-coup_id="<?php echo $id ?>" href="javascript:void (0)" type="button" class="btn btn-success btn-outline btn-xs del btn-rounded "><i class="glyphicon glyphicon-plus"></i>&nbsp;发放优惠卷</button>

                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="col-sm-12 page">
                            <div class="pull-right">
                                <?= LinkPager::widget([
                                    'pagination'     => $pages,
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
    
        //单个发放     
        $(".del").click(function () {
            var dele = $(this);
            var id= $(this).attr('data-id');
            var coup_id= $(this).attr('data-coup_id');
            var d = dialog({
                title: '友情提示',
                id: 'del_pro',
                content: '您确定要发放优惠卷吗？',
                ok: function () {
                    $.ajax({
                        url: "/coupon/issue",
                        type: "post",
                        dataType: "json",
                        data:{
                            'id':id,'coup_id':coup_id,
                            '_csrf-backend':$('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status === 1) {
                                var status=dialog({content: data.info}).showModal();
                                setTimeout(function (){
                                status.close();
                                dele.closest('tr').remove();
                                }, 800);
                                 window.location.reload();
                            }else{ 
                                dialog({title: "提示",content: data.info,ok: true}).showModal();
                            } 
                        }
                    });
                },
                cancel: true
            });
            d.showModal();
        }); 
        
JS;
$this->registerJs($js);
?>
</body>