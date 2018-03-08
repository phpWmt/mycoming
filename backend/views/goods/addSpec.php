<?php
use \kucha\ueditor\UEditor;
use yii\helpers\Url;
use backend\assets\AppAsset;
use yii\bootstrap\Alert;

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
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-cart-plus">　</i>商品规格添加</h3>
                </div>
                <div class="ibox-content">

                    <form method="post" class="myform form-horizontal">
                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">

                        <input name="id" type="hidden" value="<?php echo $id?>">

                                    <div class="form-group field-goods-title required">
                                        <label class="col-sm-2 control-label">商品规格:</label>
                                        <div id="server">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2" style="width:200px;">
                                                        <input  type="text" name="name[]"   placeholder="例如(颜色)" class="form-control" datatype="*" nullmsg="不可为空">
                                                    </div>

                                                    <div class="col-md-2" style="width:800px;">
                                                        <input  type="text" name="spec[]"   placeholder="多个规格用逗号隔开 例如(红色,白色,蓝色)" class="form-control" datatype="*" nullmsg="不可为空">
                                                        <span class="help-block m-b-none" style="color: red"><i class="fa fa-info-circle"></i> 重要提示:请使用<b>逗号</b>隔开。</span>
                                                    </div>

                                                    <div class="col-md-2" style="width:200px;">
                                                        <button class="btn btn-primary" id="add_spec" type="button">添加更多</button>
                                                    </div>

                                                </div>

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
        html+='<div class="col-md-2" style="width:200px;padding:0px 0px 0px 23px"><input  type="text" name="name[]" placeholder=""  class="form-control"></div>';
        html+='<div class="col-md-2" style="width:800px;padding:0px 0px 0px 23px"><input  type="text" name="spec[]" placeholder=""  class="form-control"></div>';
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
            url: "/goods/add-spec",
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
