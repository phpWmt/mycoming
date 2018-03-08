<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\bootstrap\Alert;

use backend\assets\AppAsset;

AppAsset::addJs($this, 'js/plugins/jasny/jasny-bootstrap.min.js');
AppAsset::addJs($this, '/js/plugins/dropzone/dropzone.js');
AppAsset::addJs($this, '/js/dropzone_demo.js');

AppAsset::addCss($this, '/css/plugins/dropzone/basic.css');
AppAsset::addCss($this, '/css/plugins/dropzone/dropzone.css');
AppAsset::addCss($this, 'css/plugins/jasny/jasny-bootstrap.min.css');


if( Yii::$app->getSession()->hasFlash('success') ) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('success'), //消息体
    ]);
}

?>
<body class="gray-bg">
<!--订单编号-->
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>订单详情</h3>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="form-group" style="font-size: 18px;">
                            <label class="col-sm-2 control-label" for="user-phone">订单编号:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['order_num']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                </div>

                <!--收货地址-->
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">收货人：</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['address']['receive']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">联系电话：</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['address']['phone']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">详细地址：</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['address']['province']?>&nbsp;<?php echo $order['address']['city']?>&nbsp<?php echo $order['address']['area']?>&nbsp;<?php echo $order['address']['detail']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                </div>

                <!--购买用户-->
                <div class="ibox-content">
                    <div class="form-group" >
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">购买用户:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['user']['nickname']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">手机号:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['user']['phone']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">用户头像:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error" >
                                    <a class="fancybox img-circle"  href="<?php echo  Yii::$app->params['API_HOST'].$order['user']['cover']?>" title="评论图">
                                        <img alt="image" src="<?php echo  Yii::$app->params['API_HOST'].$order['user']['cover']?>" style="width:20%;height:20%;border-radius:2px;cursor: pointer;">
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">用户状态:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error">
                                    <?php if($order['user']['status'] == 0):?>
                                        <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="buttons.html#"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;禁用</a>
                                    <?php else:?>
                                        <a class="btn btn-info btn-rounded btn-outline btn-xs" href="buttons.html#"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;正常</a>
                                    <?php endif;?>

                                </p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                </div>

                <!--所属仓库-->
                <div class="ibox-content">

                    <div class="form-group" >
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">所属仓库:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['entrepot']['entrepot_name']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">仓库地址:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error"><?php echo $order['entrepot']['entrepot_address']?></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="user-phone">仓库状态:</label>
                            <div class="col-sm-4">
                                <p class="help-block help-block-error">
                                    <?php if($order['user']['status'] == 0):?>
                                        <a class="btn btn-danger btn-rounded btn-outline btn-xs" href="buttons.html#"><i class="glyphicon glyphicon-remove"></i>&nbsp;&nbsp;禁用</a>
                                    <?php else:?>
                                        <a class="btn btn-info btn-rounded btn-outline btn-xs" href="buttons.html#"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;正常</a>
                                    <?php endif;?>
                                </p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<!--订单商品-->
<form method="post" class="myform">
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">

                    <div class="ibox-content">
                        <?php if(!empty($order['detail'])):foreach ($order['detail'] as $value):?>

                            <!-- 仓库商品ID-->
                            <input name="egId[]" type="hidden" value="<?php echo $value['egId']?>">

                            <!-- 仓库规格ID-->
                            <input name="spec_id[]" type="hidden" value="<?php echo $value['spec_id']?>">

                            <!-- 规格-->
                            <input name="spec[]" type="hidden" value="<?php echo $value['spec']?>">

                            <!-- 商品单价-->
                            <input name="shop_price[]" type="hidden" value="<?php echo $value['shop_price']?>">

                            <!-- 已售数量-->
                            <input name="shop_num[]" type="hidden" value="<?php echo $value['shop_num']?>">

                            <div class="form-group">
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <p class="help-block help-block-error"><b>商品图片:</b>&nbsp;&nbsp;
                                            <a class="fancybox img-circle"  href="<?php echo  Yii::$app->params['API_HOST'].$value['img']['cover']?>" title="评论图">
                                                <img alt="image" src="<?php echo  Yii::$app->params['API_HOST'].$value['img']['cover']?>" style="width:30%;height:30%;border-radius:5px;cursor: pointer;">
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <p class="help-block help-block-error"><b>商品名称:</b>&nbsp;&nbsp;<?php echo $value['img']['title']?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <p class="help-block help-block-error"><b>商品分类:</b>&nbsp;&nbsp;<?php echo $value['img']['cate_name']?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <p class="help-block help-block-error"><b>商品品牌:</b>&nbsp;&nbsp;<?php echo $value['img']['brand_name']?></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>



                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <p class="help-block help-block-error"><b>商品规格:</b>&nbsp;&nbsp;<?php echo $value['spec']?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <p class="help-block help-block-error" style="color: #0a6aa1"><b>商品单价:</b>&nbsp;&nbsp;<?php echo $value['shop_price']?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <p class="help-block help-block-error" style="color: #0a6aa1"><b>购买数量:</b>&nbsp;&nbsp;<?php echo $value['shop_num']?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <p class="help-block help-block-error" style="color: red"><b>总价:</b>&nbsp;&nbsp;<?php echo $value['shop_num']*$value['shop_price']?></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>


                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <p class="help-block help-block-error"><b>商品简介:</b>&nbsp;&nbsp;
                                            <?php echo $value['img']['info']?>
                                        </p>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                            </div>
                        <?php endforeach;endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--详情-->
    <?php if($order['order_status'] != 0):?>
    <div class="wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="form-group" style="font-size: 15px;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="user-phone">订单状态:</label>
                                <div class="col-sm-4">
                                    <p class="help-block help-block-error"><?php echo \backend\models\Order::return_status($order['order_status']) ?></p>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="user-phone">商品总价:</label>
                                <div class="col-sm-4">
                                    <p class="help-block help-block-error">
                                        <a class="btn btn-danger btn-rounded btn-outline btn-xs btn-outline"><i class="glyphicon glyphicon-yen"></i>&nbsp;&nbsp;<?php echo $order['price']?></a>
                                    </p>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="user-phone">购买数量:</label>
                                <div class="col-sm-4">
                                    <p class="help-block help-block-error">
                                        <a class="btn btn-danger btn-rounded btn-outline btn-xs btn-outline"><i class="glyphicon glyphicon-resize-vertical"></i>&nbsp;&nbsp;<?php echo $order['total_num']?>&nbsp;&nbsp;</a>
                                    </p>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="user-phone">发货记录:</label>
                                <div class="col-sm-4">
                                    <p class="help-block help-block-error">
                                        <a class="btn btn-info btn-rounded btn-outline btn-sm" href="<?php echo Url::to(['merchant-order/look', 'id' => $id]) ?>"><i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;查看发货记录</a>
                                    </p>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--发货-->
        <?php else:?>
        <div class="wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">


                        <div class="ibox-content">

                            <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                            <!--  订单ID-->
                            <input name="order_id" type="hidden" value="<?php echo $order['id']?>">

                            <!--  收款金额-->
                            <input name="price" type="hidden" value="<?php echo $order['price']?>">

                            <div class="form-group" style="font-size: 16px;">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="user-phone">订单状态:</label>
                                    <div class="col-sm-4">
                                        <p class="help-block help-block-error"><?php echo \backend\models\Order::return_status($order['order_status']) ?></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="user-phone">商品总价:</label>
                                    <div class="col-sm-4">
                                        <p class="help-block help-block-error">
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs btn-outline"><i class="glyphicon glyphicon-yen"></i>&nbsp;&nbsp;<?php echo $order['price']?></a>
                                        </p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="user-phone">购买数量:</label>
                                    <div class="col-sm-4">
                                        <p class="help-block help-block-error">
                                            <a class="btn btn-danger btn-rounded btn-outline btn-xs btn-outline"><i class="glyphicon glyphicon-resize-vertical"></i>&nbsp;&nbsp;<?php echo $order['total_num']?></a>
                                        </p>
                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">收款金额：</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="pay_money" name="pay_money" placeholder="请填写收款金额！" required datatype="*" nullmsg="不可为空">
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">收款方式：</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="payment" required="true" required  datatype="*" nullmsg="不可为空">
                                            <option value=" ">收款方式选择</option>
                                            <option value="0">线下支付</option>
                                            <option value="1">支付宝</option>
                                            <option value="2">微信</option>

                                        </select>
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">快递公司：</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="express" required="true" required  datatype="*" nullmsg="不可为空">
                                            <option value=" ">快递公司选择</option>
                                            <?php foreach ($GodownTypeb as $value):?>
                                                <option value="<?php echo $value['delivery_name']?>"><?php echo $value['delivery_name']?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">快递编号：</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="express_num" name="express_num" placeholder="请填写快递编号！" required  datatype="*" nullmsg="不可为空">
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">快递电话：</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="express_phone" name="express_phone" placeholder="请填写快递电话！" required  datatype="*" nullmsg="不可为空">
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">快递物流信息：</label>
                                    <div class="col-sm-9">
                                        <textarea name="express_info" style="width:1000px;height:80px;"  placeholder="请填写快递物流信息！"></textarea>
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6 text-center">
                                    <button type="button" class="btn btn-primary m-r-md btn_save">保存发货</button>
                                    <a class="btn btn-white" href="<?php echo Url::to(['order/list']) ?>">取消</a>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</form>
<?php endif;?>

<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/js/content.min.js?v=1.0.0"></script>
<script src="/js/plugins/fancybox/jquery.fancybox.js"></script>
<script>
    $(document).ready(function(){$(".fancybox").fancybox({openEffect:"none",closeEffect:"none"})});
</script>
<?php
$maxFilesize = get_cfg_var("post_max_size") ? (int)get_cfg_var("post_max_size") : 0;
$crsfValue = Yii::$app->request->csrfToken;
$js = <<<JS
/* 必填 */
$(".myform").Validform({
    tiptype: 3,
    btnSubmit: ".btn_save",
    callback: function (submitForm) {
        $(submitForm).ajaxSubmit({
            url: "/merchant/merchant-order/order-record",
            type: "post",
            dataType: "json",
            success: function (data) {
                console.log(data);
                if(data.status === 1) {
                   
                    dialog({content: data.info}).showModal();
                    setTimeout(function () {window.location.href = data.url;}, 800);
                } else {
                    dialog({title: '友情提示', content: data.info, ok: true}).showModal();
                }
            }
        });
        return false;
    }
});

JS;
$this->registerJs($js);
?>
</body>

