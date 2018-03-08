<?php
use \kucha\ueditor\UEditor;
use yii\helpers\Url;
use merchant\assets\AppAsset;

AppAsset::addJs($this, '/merchantjs/plugins/jasny/jasny-bootstrap.min.js');
AppAsset::addJs($this, '/merchant/js/plugins/dropzone/dropzone.js');
AppAsset::addJs($this, '/merchant/js/dropzone_demo.js');

AppAsset::addCss($this, '/merchant/css/plugins/dropzone/basic.css');
AppAsset::addCss($this, '/merchant/css/plugins/dropzone/dropzone.css');
AppAsset::addCss($this, '/merchant/css/plugins/jasny/jasny-bootstrap.min.css');
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品添加</h3>
                </div>
                <div class="ibox-content">

                    <form method="post" class="myform form-horizontal">
                        <input name="_csrf-merchant" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <div class="form-group field-goods-title required">
                            <label class="col-sm-2 control-label">商品名称:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" datatype="*" nullmsg="不可为空">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group field-goods-cate_id required">
                            <label class="col-sm-2 control-label" for="goods-cate_id">商品分类</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="cate_id" required="true">
                                    <option value=" ">分类选择</option>
                                    <?php if(is_array($cate)&&!empty($cate)): foreach ($cate as $k=>$v):?>
                                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name'] ?></option>
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
                                <select class="form-control" name="brand_id" required="true">
                                    <option value=" ">品牌选择</option>
                                    <?php if(is_array($article_cate)&&!empty($article_cate)): foreach ($article_cate as $k=>$v):?>
                                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name'] ?></option>
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
                                <input type="number" class="form-control" name="list_price" min="0" step="number" placeholder="列表显示价格" datatype="*" nullmsg="不可为空">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods-num">封面图片:</label>
                            <div id="dropzone_cover" class="dropzone col-sm-8 text-center" style="border:dashed 2px;">
                                <button type="button" id="upload_img" class="btn btn-primary pull-right" style="position: absolute;right: 0.5rem;top: 0.5rem;">上传</button>
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
                            <label class="col-sm-2 control-label" for="goods-info">商品详情:</label>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <?php
                                    echo UEditor::widget([
                                        'name' => "content",
                                        'id' => 'content',
                                        'clientOptions' => [
                                            'initialFrameHeight' => '300',
                                            'autoHeightEnabled'=>false,
                                            'lang' => 'zh-cn',
                                        ]
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

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
<script>
    function del_this(obj){
        $(obj).parent('div').parent('div').parent('div').remove();
    }
</script>

<?php
$maxFilesize = get_cfg_var("post_max_size") ? (int)get_cfg_var("post_max_size") : 0;
$crsfValue = Yii::$app->request->csrfToken;
$js = <<<JS
    $("#add_spec").click(function(){
        var html='<div class="form-group">';
        html+='<label class="col-sm-2 control-label"></label>';
        html+='<div class="row">';
        html+='<div class="col-md-2" style="width:200px;padding:0px 0px 0px 23px"><input  type="text" name="color[]" placeholder="颜色"  class="form-control"></div>';
        html+='<div class="col-md-2" style="width:300px;padding:0px 0px 0px 23px"><input  type="text" name="spec[]" placeholder="规格"  class="form-control"></div>';
        html+='<label class="col-sm-3 control-label" style="width:80px;">价格：</label><div class="col-md-2" style="width:200px;padding:0px 0px 0px 23px"> <input name="price[]" oninput="if(value.length>7)value=value.slice(0,5)"  type="number"  placeholder="默认单位:元" class="form-control"></div>';
        html+='<label class="col-sm-3 control-label" style="width:80px;">库存：</label><div class="col-md-2" style="width:200px;padding:0px 0px 0px 23px"> <input name="total_num[]" oninput="if(value.length>7)value=value.slice(0,5)"  type="number" placeholder="库存数量" class="form-control"></div>';
        html+='<div class="col-md-2" style="width:200px;"><button class="btn btn-default" onclick="del_this(this)" id="add_spec" type="button"><i class="fa fa-trash"></i></button></div>';
        html+='</div></div>';
        $("#server").append(html);
    });

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });


     $("#sale_close").click(function () {
         alert(open);
        $("#sale_price").hide();
    });
    $("#sale_open").click(function () {
        alert(open);
        $("#sale_price").show();
    });
Dropzone.autoDiscover = false;
//封面一张
createDropzone('dropzone_cover','cover',$maxFilesize,1,"$crsfValue");
//轮番多张
createDropzone('dropzone','img',$maxFilesize,5,"$crsfValue");


/* 必填 */
$(".myform").Validform({
    tiptype: 3,
    btnSubmit: ".btn_save",
    callback: function (submitForm) {
        $(submitForm).ajaxSubmit({
            url: "/merchant/merchant-goods/create",
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
