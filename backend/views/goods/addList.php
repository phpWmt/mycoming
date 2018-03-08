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
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <br class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品详细规格添加</h3>

                </div><br/>
                <p>
                    <a href="<?php echo Url::to(['goods/remove','id'=>$id])?>" style="width: 20%;" type="button" class="btn btn-block btn-primary">全部删除</a>
                </p>
                <div class="ibox-content">

                    <form method="post" class="myform form-horizontal">
                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">

                        <input name="id" type="hidden" value="<?php echo $id?>">


                        <div class="row">
                            <label class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <div class="col-md-2" style="width:600px;">
                                <b><?php echo $strName?></b>
                            </div>
                            <div class="col-md-2" style="width:200px;">
                                <b>价格</b>
                            </div>
                            <div class="col-md-2" style="width:200px;">
                                <b>库存</b>
                            </div>
                        </div>
                        <?php if(!empty($dataSpec)):foreach ($dataSpec as $key=>$value):?>
                        <div class="form-group field-goods-title required">
                            <div id="server">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-2 control-label">商品规格<?php echo $key?>:</label>
                                        <div class="col-md-2" style="width:600px;">
                                            <input  type="text" name="spec[]"   value="<?php echo $value?>" placeholder="" readonly class="form-control" datatype="*" nullmsg="不可为空">
                                        </div>

                                        <div class="col-md-2" style="width:200px;">
                                            <input  type="text" name="price[]"   placeholder="价格" class="form-control" datatype="*" nullmsg="不可为空">
                                        </div>

                                        <div class="col-md-2" style="width:200px;">
                                            <input  type="text" name="total_num[]"   placeholder="库存" class="form-control" datatype="*" nullmsg="不可为空">
                                        </div>

                                        <div class="col-md-2" style="width:200px;"><button class="btn btn-default" onclick="del_this(this)" id="add_spec" type="button"><i class="fa fa-trash"></i></button></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;endif;?>

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

/* 必填 */
$(".myform").Validform({
    tiptype: 3,
    btnSubmit: ".btn_save",
    callback: function (submitForm) {
        $(submitForm).ajaxSubmit({
            url: "/goods/add-list",
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
