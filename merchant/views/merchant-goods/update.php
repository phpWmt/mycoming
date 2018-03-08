<?php
use yii\helpers\Url;
use backend\assets\AppAsset;

AppAsset::addJs($this, 'js/plugins/jasny/jasny-bootstrap.min.js');
AppAsset::addJs($this, '/js/plugins/dropzone/dropzone.js');
AppAsset::addJs($this, '/js/dropzone_demo.js');

AppAsset::addCss($this, '/css/plugins/dropzone/basic.css');
AppAsset::addCss($this, '/css/plugins/dropzone/dropzone.css');
AppAsset::addCss($this, 'css/plugins/jasny/jasny-bootstrap.min.css');
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品修改</h3>
                </div>
                <div class="ibox-content">

                    <form method="post" class="myform form-horizontal">

                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <input name="id" type="hidden" value="<?php echo $data->id?>">
                        <div class="form-group field-goods-title required">
                            <label class="col-sm-2 control-label">商品名称:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $data->title ?>" name="title" datatype="*" nullmsg="不可为空">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>



                        <div class="form-group field-goods-cate_id required">
                            <label class="col-sm-2 control-label" for="goods-cate_id">商品分类</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="goods_cate" name="cate_id" required="true">
                                    <option value=" ">分类选择</option>
                                    <?php if(is_array($cate)&&!empty($cate)): foreach ($cate as $k=>$v):?>
                                        <option value="<?php echo $v['id']; ?>" disabled><?php echo $v['name'] ?></option>
                                        <?php if(!empty($v['children'])): foreach ($v['children'] as $k1=>$v1):?>
                                            <option value="<?php echo $v1['id']; ?>"><?php echo '　　'.$v1['name'] ?></option>
                                            <?php if(!empty($v1['children'])): foreach ($v1['children'] as $k2=>$v2):?>
                                                <option value="<?php echo $v2['id']; ?>"><?php echo '　　　　'.$v2['name'] ?></option>
                                            <?php endforeach;endif;?>
                                        <?php endforeach;endif;?>
                                    <?php endforeach;endif;?>
                                </select>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group field-goods-cate_id required">
                            <label class="col-sm-2 control-label" for="goods-cate_id">商品品牌</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="goods_banerd" name="brand_id" required="true">
                                    <option value=" ">品牌选择</option>
                                    <?php if(is_array($article_cate)&&!empty($article_cate)): foreach ($article_cate as $k=>$v):?>
                                        <option value="<?php echo $v['id']; ?>" disabled><b><?php echo $v['name'] ?></b></option>
                                        <?php if(!empty($v['children'])): foreach ($v['children'] as $k1=>$v1):?>
                                            <option value="<?php echo $v1['id']; ?>"><?php echo '　　'.$v1['name'] ?></option>
                                            <?php if(!empty($v1['children'])): foreach ($v1['children'] as $k2=>$v2):?>
                                                <option value="<?php echo $v2['id']; ?>"><?php echo '　　　　'.$v2['name'] ?></option>
                                            <?php endforeach;endif;?>
                                        <?php endforeach;endif;?>
                                    <?php endforeach;endif;?>
                                </select>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group field-goods-price required">
                            <label class="col-sm-2 control-label" for="goods-price">商品单价:</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="list_price"  value="<?php echo $data->list_price ?>" min="0" step="number" placeholder="列表显示价格" datatype="*" nullmsg="不可为空">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods-num">封面图片:</label>
                            <div id="dropzone_cover" class="dropzone col-sm-8 text-center" style="border:dashed 2px;">
                                <button type="button" id="upload_img" class="btn btn-primary pull-right"
                                        style="position: absolute;right: 0.5rem;top: 0.5rem;">上传
                                </button>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods-num">商品图片:</label>
                            <div id="dropzone" class="dropzone col-sm-8 text-center" style="border:dashed 2px;">
                                <button type="button" id="upload_img" class="btn btn-primary pull-right"
                                        style="position: absolute;right: 0.5rem;top: 0.5rem;">上传
                                </button>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group field-goods-info required">
                            <label class="col-sm-2 control-label" for="goods-info">商品简介:</label>
                            <div class="col-sm-8">
                            <textarea class="form-control" name="info" rows="8" datatype="*" nullmsg="不可为空"><?php echo strip_tags($data->info) ?></textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <button type="button" class="btn btn-primary m-r-md btn_save">保存内容</button>
                                <a class="btn btn-white" href="<?php echo Url::to(['merchant-manager/list']) ?>">取消</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<?php

$maxFilesize = get_cfg_var("post_max_size") ? (int)get_cfg_var("post_max_size") : 0;
$crsfValue = Yii::$app->request->csrfToken;

$update=function ($img_data){
    $return_arr=[];
    $img=array_filter(explode(',',$img_data));

    foreach ($img as $k=>$v){
        $return_arr[$k]['name']=basename($v);
        $return_arr[$k]['size']=ceil(filesize(Yii::getAlias("@api")."/web".$v));
        $return_arr[$k]['url']= Yii::$app->params['API_HOST'].$v;
    }
    return json_encode($return_arr);
};
$img_json=$update($data->img);
$cover_json=$update($data->cover);

$js = <<<JS
$("#goods_banerd").val($data->brand_id);
$("#goods_cate").val($data->cate_id);
$(":radio[name='is_hot'][value='" + $data->is_hot + "']").prop("checked", "checked");
$(":radio[name='is_sale'][value='" + $data->is_sale + "']").prop("checked", "checked");
$('.i-checks').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
});

var img_json=$img_json;
var cover_json=$cover_json;
Dropzone.autoDiscover = false;
//封面一张
createDropzone('dropzone_cover','cover',$maxFilesize,1,"$crsfValue",cover_json);
//轮番多张
createDropzone('dropzone','img',$maxFilesize,5,"$crsfValue",img_json);

/* 必填 */
$(".myform").Validform({
    tiptype: 3,
    btnSubmit: ".btn_save",
    callback: function (submitForm) {
        $(submitForm).ajaxSubmit({
            url: "/merchant/merchant-goods/update",
            type: "post",
            dataType: "json",
            success: function (data) {
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
