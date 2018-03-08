<?php
use \kucha\ueditor\UEditor;
use yii\helpers\Url;
use backend\assets\AppAsset;

AppAsset::addJs($this, 'js/plugins/jasny/jasny-bootstrap.min.js');
AppAsset::addJs($this, '/js/plugins/dropzone/dropzone.js');
AppAsset::addJs($this, '/js/dropzone_demo.js');

AppAsset::addCss($this, '/css/plugins/dropzone/basic.css');
AppAsset::addCss($this, '/css/plugins/dropzone/dropzone.css');
AppAsset::addCss($this, 'css/plugins/jasny/jasny-bootstrap.min.css');
?>
<!--复选框样式-->
<style>
    input[type=radio],input[type=checkbox]  {
        display: inline-block;
        vertical-align: middle;
        width: 20px;
        height: 20px;
        margin-left: 5px;
        -webkit-appearance: none;
        background-color: transparent;
        border: 0;
        outline: 0 !important;
        line-height: 20px;
        color: #d8d8d8;
    }
    input[type=radio]:after  {
        content: "";
        display:block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        text-align: center;
        line-height: 14px;
        font-size: 16px;
        color: #fff;
        border: 2px solid #ddd;
        background-color: #fff;
        box-sizing:border-box;
    }

    input[type=checkbox]:after  {
        content: "";
        display:block;
        width: 20px;
        height: 20px;
        text-align: center;
        line-height: 14px;
        font-size: 16px;
        color: #fff;
        border: 2px solid #ddd;
        background-color: #fff;
        box-sizing:border-box;
    }
    input[type=checkbox]:checked:after  {
        border: 4px solid #ddd;
        background-color: #37AF6E;
    }

    input[type=radio]:checked:after  {
        content: "L";
        transform:matrix(-0.766044,-0.642788,-0.642788,0.766044,0,0);
        -webkit-transform:matrix(-0.766044,-0.642788,-0.642788,0.766044,0,0);
        border-color: #37AF6E;
        background-color: #37AF6E;
    }
</style>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品出入库</h3>
                </div>
                <div class="ibox-content">

                    <form method="post" class="myform form-horizontal">

                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">



                        <!--剩余库存总数-->
                        <input name="repertory" type="hidden" value="<?php echo  $goods['repertory']?>">

                        <div class="form-group field-goods-title required">
                            <label class="col-sm-2 control-label">商品名称:</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="goods_id" readonly  value="<?php echo $goods['id']?>">
                                <input type="text" class="form-control"  name="title" readonly  value="<?php echo $goods['title']?>">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <div class="form-group field-goods-title required">
                            <label class="col-sm-2 control-label">商品分类:</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="classify_id" readonly value="<?php echo $goods['cate_id']?>">
                                <input type="text" class="form-control"  readonly value="<?php echo $goods['cate_name']?>" datatype="*" nullmsg="不可为空">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <div class="form-group field-goods-title required">
                            <label class="col-sm-2 control-label">商品品牌:</label>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="brand_id" readonly value="<?php echo $goods['brand_id']?>">
                                <input type="text" class="form-control"  readonly value="<?php echo $goods['brand_name']?>" >
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <div class="form-group field-goods-title required">
                            <label class="col-sm-2 control-label">商品单价:</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control"  readonly value="<?php echo $goods['list_price']?>" datatype="*" nullmsg="不可为空">
                            </div>
                            <label class="col-sm-2 control-label"  style="width:100px;">剩余库存：</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" style="color:red" readonly value="<?php echo $goods['repertory']?>" datatype="*" nullmsg="不可为空">
                            </div>
                            <label class="col-sm-2 control-label"  style="width:100px;">总库存：</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control"  readonly value="<?php echo $goods['total']?>" datatype="*" nullmsg="不可为空">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="hr-line-dashed"></div>

                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <div class="form-group field-goods-title required">
                            <label class="col-sm-2 control-label">商品描述:</label>
                            <div class="col-sm-6">
                                <textarea rows="8" cols="100" style="color: black;font-size: 16px"><?php echo  strip_tags($goods['info'])?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods-num">封面图片:</label>
                            <div class="col-sm-8">
                                <div id="content_show_img">
                                    <div class="file-box" style="margin-top: 10px;width:100px;">
                                        <div class="file"><span class="corner"></span>
                                            <div class="icon" style="height:100%;padding: 0px;" >
                                                <img src="<?php echo Yii::$app->params['API_HOST'].$goods['cover']?>" style="width:100%;height:100%;cursor: pointer;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods-num">商品图片:</label>
                            <div class="col-sm-8">
                                <div id="content_show_img">
                                    <?php $img = explode(',',$goods['img']); ?>
                                    <?php foreach ($img as $v):?>
                                    <div class="file-box" style="margin-top: 10px;width:100px;">
                                        <div class="file"><span class="corner"></span>
                                            <div class="icon" style="height:100px;padding: 0px;" >
                                                <img src="<?php echo Yii::$app->params['API_HOST'].$v?>" style="width:100%;height:100%;cursor: pointer;">
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>

                        </div>

                        <div class="form-group" id="is_sale">
                            <label class="col-sm-2 control-label" for="goods-num" style="color: #000000;">仓库选择:</label>
                            <div class="col-sm-8">
                                <?php if(!empty($entrepot)):foreach ($entrepot as $value):?>
                                    <label class="checkbox-inline i-checks">
                                        <input type="checkbox" name="entrepot[]"  onclick="check()" value="<?php echo $value['id']?>" datatype="*" nullmsg="不可为空"><?php echo $value['entrepot_name']?>
                                    </label>
                                <?php endforeach;endif;?>
                                <span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i>&nbsp;可以选择多个仓库添加！请注意每个规格入库数量，不能超过剩余库存。</span>
                            </div>
                        </div>


                        <?php if (!empty($AloneSpec)):foreach ($AloneSpec as $key=>$value):?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" style="color:#000000">商品规格:</label>
                            <div id="permissions" class="col-sm-10">

                                <!-- 规格复选框 -->
                                <input type="checkbox"  onclick="javascript:check(this,<?php echo $value['id']?>)" name="spec_id[]" value="<?php echo $value['id']?>"  checked datatype="*" nullmsg="不可为空">

                                <div class="col-md-2" style="width:350px;">
                                    <input  type="text"   maxlength="7" readonly value="<?php echo $value['spec']?>" onkeyup="value=value.replace(/[^0-9.]/g,'')" required placeholder="默认单位:元" class="form-control">
                                </div>

                                <label class="col-sm-3 control-label"  style="width:80px;">价格：</label>
                                <div class="col-md-2" style="width:150px;">
                                    <input  type="text"   maxlength="7" readonly value="<?php echo $value['price']?>" onkeyup="value=value.replace(/[^0-9.]/g,'')" required placeholder="默认单位:元" class="form-control">
                                </div>

                                <label class="col-sm-3 control-label" style="width:100px;">剩余库存：</label>
                                <div class="col-md-2" style="width:150px;">
                                    <input  type="text"  style="color:red" value="<?php echo $value['num']?>"  readonly class="form-control">
                                </div>

                                <label class="col-sm-3 control-label" style="width:100px;">入库数量：</label>
                                <div class="col-md-2" style="width:200px;">
                                    <input  type="number" id="<?php echo $value['id']?>" name="total_num[]" maxlength="7" style="color:red"  value="<?php echo intval($value['num']/count($entrepot))?>" onkeyup="value=value.replace(/[^0-9]/g,'')" required placeholder="入库数量"  class="form-control">
                                </div>

                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <?php endforeach;endif;?>

                        <div class="form-group" id="is_sale">
                            <label class="col-sm-2 control-label" for="goods-num" style="color: #000000;" >库存类型:</label>
                            <div class="col-sm-8">
                                <?php if(!empty($GodownType)):foreach ($GodownType as $value):?>
                                    <label class="checkbox-inline i-checks">
                                        <input type="radio" datatype="*" nullmsg="不可为空" name="godown_type"  value="<?php echo $value['id']?>" ><?php echo $value['name']?>
                                    </label>
                                <?php endforeach;endif;?>
                            </div>
                        </div>


                        <div class="form-group" id="is_sale">
                            <label class="col-sm-2 control-label" for="goods-num">是否推荐:</label>
                            <div class="col-sm-8">
                                <label class="checkbox-inline i-checks">
                                    <input type="radio" name="is_recom" checked value="0">不推荐
                                </label>
                                <label class="checkbox-inline i-checks">
                                    <input type="radio" name="is_recom" value="1">推荐
                                </label>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group" id="sale_price">
                            <label class="col-sm-2 control-label" for="goods-price">推荐原因:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="不推荐,推荐原因可不用填写！" name="recom_reason" min="0" step="number">
                            </div>
                        </div>


                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primary m-r-md btn_save">保存内容</button>
                                <a class="btn btn-white" href="<?php echo Url::to(['goods/list']) ?>">取消</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>



<div class="col-sm-3" id="addShow" >
    <div class="ibox ">
        <div class="ibox-content">
            <div class="spiner-example">
                <div class="sk-spinner sk-spinner-chasing-dots">
                    <div class="sk-dot1"></div>
                    <div class="sk-dot2"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--复选框事件-->
<script>
    function click() {

    }

    function check(obj,id){
        if($(obj).prop("checked")){
            //选中操作
            //恢复该input的name值
            $("input#"+id).attr("name","total_num[]")
        }else{
            //取消选中操作
            //移除该input的name值
                $("input#"+id).removeAttr("name");
        }
    }
</script>
<?php

$js = <<<JS


    
//单选框
$('.i-checks').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
});


/* 必填 */
$(".myform").Validform({

    tiptype: 3,
    btnSubmit: ".btn_save",
    callback: function (submitForm) {

        $(submitForm).ajaxSubmit({
            url: "/goods/godown",
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
