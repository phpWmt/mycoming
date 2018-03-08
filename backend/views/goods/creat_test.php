
<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;

AppAsset::addJs($this,'/js/plugins/dropzone/dropzone.js');
AppAsset::addCss($this,'/css/plugins/dropzone/basic.css');
AppAsset::addCss($this,'/css/plugins/dropzone/dropzone.css');
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
                    <?php
                    $form = ActiveForm::begin([
                        'action' => Url::to(['goods/create']),       //此处为请求地址 Url用法查看手册
                        'options' => ['class' => 'myform form-horizontal', 'method' => 'post','id'=>'manager_create'],
                        'enableAjaxValidation' => true,//开启ajax验证
                        'validateOnBlur'=>false,//关闭失去焦点验证
                        'validateOnChange'=>true,//在更改输入字段的值时执行验证
                        'fieldConfig'=>[
                            'template'=>'{label}<div class="col-sm-8">{input}{error}</div><div class="hr-line-dashed"></div>',
                            'labelOptions'=>['class'=>'col-sm-2 control-label']
                        ],
                    ]);
                    ?>


                    <div class="form-group field-goods-cover file-pretty">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods-cover">封面图片:</label>
                            <div class="col-sm-8">
                                <input type="hidden" name="Goods[cover]" value="">
                                <input type="file" id="goods-cover" name="Goods[cover]">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>

                    <div class="form-group">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="goods-num">商品封面:</label>
                            <div id="dropzone_title" class="dropzone col-sm-8 text-center" action="/goods/upload" style="border:dashed 2px;">
                                <button type="button" id="upload_img" class="btn btn-primary pull-right" style="position: absolute;right: 0.5rem;top: 0.5rem;">提交</button>
                            </div>

                            <div style="clear: both;"></div>
                            <div class="hr-line-dashed"></div>
                        </div>
                    </div>



                    <div class="form-group">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="goods-num">商品图片:</label>
                            <div id="dropzone" class="dropzone col-sm-8 text-center" action="/goods/upload" style="border:dashed 2px;">
                                <button type="button" id="upload_img" class="btn btn-primary pull-right" style="position: absolute;right: 0.5rem;top: 0.5rem;">提交</button>

                            </div>

                        <div style="clear: both;"></div>
                        <div class="hr-line-dashed"></div>
                    </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <?php echo Html::submitButton('保存内容', ['class' => 'btn btn-primary m-r-md btn_save']) ?>
                            <a class="btn btn-white" href="<?php echo Url::to(['manager/list']) ?>">取消</a>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>

</div>

<?php
$maxFilesize=get_cfg_var ("post_max_size")?(int)get_cfg_var ("post_max_size"):0;
$crsfValue=Yii::$app->request->csrfToken;

$img=array_filter(explode(',',$data->img));
$img_update=[];
foreach ($img as $k=>$v){
    $img_update[$k]['name']=basename($v);
    $img_update[$k]['size']=ceil(filesize(Yii::getAlias("@backend")."/web".$v));
    $img_update[$k]['url']=$v;
}

$mockFile =json_encode($img_update);
$js=<<<JS
$('.file-pretty input[type="file"]').prettyFile();
    //取消自动初始化
    Dropzone.autoDiscover = false;
    $("div#dropzone").dropzone({
        params:{'_csrf-backend':'$crsfValue'},
        url:"/goods/create",
        addRemoveLinks: true, //添加移除文件
        autoProcessQueue: false, //自动上传
        uploadMultiple: true,//是否在一个请求中发送多个文件
        parallelUploads: 100,//并行处理多少个文件上传
        maxFilesize: $maxFilesize,
        maxFiles: 5,
        paramName:"title",//后台接收时的name名称 例如title[0] title[1]......
        dictCancelUploadConfirmation: 'qeuren',
        acceptedFiles: ".jpg,.gif,.png,.git", //上传的类型
        //dictMaxFilesExceeded: "您最多只能上传5个文件！",
        dictResponseError: '文件上传失败!',
        dictFallbackMessage: "浏览器不受支持",
        //dictFileTooBig: "文件过大上传文件最大支持20MB.",
        // Dropzone settings
        init: function () {
            var myDropzone = this;
    
            this.element.querySelector("button[id=upload_img]").addEventListener("click",function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
            });
            //回显图片
            $.each($mockFile,function(index,data){
                var mockFile ={name:data.name, size: data.size,data_url:data.url,i:index};
                myDropzone.emit("addedfile", mockFile);
                myDropzone.emit("thumbnail", mockFile,data.url); 
                myDropzone.emit("complete", mockFile);
            });
            
            
            this.on("queuecomplete",function(file) {
                //上传完成后触发的方法
                this.on("removedfile",function(file){
                        //删除文件时触发的方法
                        //获取图片地址
                        var url=file.previewElement.getElementsByTagName("a")[0].getAttribute("data-url");
                        file.previewElement.classList.add("dz-success");
                        $.ajax({
                            type: "post",
                            url: "/goods/delete-img",
                            data: {"url":url,'_csrf-backend': $('meta[name="csrf-token"]').attr('content')},
                            dataType: "json",
                            success: function (response) {
                                if (response.status===1){
                                    
                                }
                            }
                        });
                });
            });
            //上传成功后显示
            this.on("sendingmultiple", function () {});
            
            //上传成功后返回的信息
            this.on("successmultiple", function (files, response) {
                var paramName=this.options.paramName;
                var dz=$('#dropzone').find('.dz-success a[class=dz-remove]');
                var dz_length=dz.length;
                if (dz_length===response.length){
                    dz.each(function(index,obj) {
                        obj.setAttribute("data-url",response[index]);
                        $("<input name="+paramName+index+" type= hidden value="+response[index]+">").appendTo(obj);
                        //obj.addChild("<input id="+paramName+index+"> type='hidden' value="+response[index]+">");
                    });
                }else{
                    //当前- 实际 - 0下标
                    var length=dz_length-response.length-1;
                    $('#dropzone').find(".dz-success:gt("+length+") a[class=dz-remove]").each(function(index,obj) {
                            obj.setAttribute("data-url",response[index]);
                    }); 
                }
                console.log(response[index]);
            });
            this.on("errormultiple", function (files, response) {});
            this.on("addedfile", function(file) { 
            //上传文件时触发的事件
            });
        }
    });
        $("div#dropzone_title").dropzone({
        params:{'_csrf-backend':'$crsfValue'},
        url:"/goods/create",
        addRemoveLinks: true, //添加移除文件
        autoProcessQueue: false, //自动上传
        uploadMultiple: true,//是否在一个请求中发送多个文件
        parallelUploads: 100,//并行处理多少个文件上传
        maxFilesize: $maxFilesize,
        maxFiles: 1,
        paramName:"title",//后台接收时的name名称 例如title[0] title[1]......
        dictCancelUploadConfirmation: 'qeuren',
        acceptedFiles: ".jpg,.gif,.png,.git", //上传的类型
        //dictMaxFilesExceeded: "您最多只能上传5个文件！",
        dictResponseError: '文件上传失败!',
        dictFallbackMessage: "浏览器不受支持",
        //dictFileTooBig: "文件过大上传文件最大支持20MB.",
        // Dropzone settings
        init: function () {
            var myDropzone = this;
    
            this.element.querySelector("button[id=upload_img]").addEventListener("click",function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
            });
            
            this.on("queuecomplete",function(file) {
                //上传完成后触发的方法
                this.on("removedfile",function(file){
                        //删除文件时触发的方法
                        //获取图片地址
                        var url=file.previewElement.getElementsByTagName("a")[0].getAttribute("data-url");
                        file.previewElement.classList.add("dz-success");
                        $.ajax({
                            type: "post",
                            url: "/goods/delete-img",
                            data: {"url":url,'_csrf-backend': $('meta[name="csrf-token"]').attr('content')},
                            dataType: "json",
                            success: function (response) {
                                if (response.status===1){
                                    
                                }
                            }
                        });
                });
            });
            //上传成功后显示
            this.on("sendingmultiple", function () {});
            
            //上传成功后返回的信息
            this.on("successmultiple", function (files, response) {
                var paramName=this.options.paramName;
                var dz=$('#dropzone_title').find('.dz-success a[class=dz-remove]');
                var dz_length=dz.length;
                if (dz_length===response.length){
                    var i=0;
                    dz.each(function(index,obj) {
                        obj.setAttribute("data-url",response[index]);
                        $("<input name="+paramName[i]+" type= hidden value="+response[index]+">").appendTo(obj);
                        //obj.addChild("<input id="+paramName+index+"> type='hidden' value="+response[index]+">");
                        i++;
                    });
                }else{
                    //当前- 实际 - 0下标
                    var length=dz_length-response.length-1;
                    $('#dropzone_title').find(".dz-success:gt("+length+") a[class=dz-remove]").each(function(index,obj) {
                            obj.setAttribute("data-url",response[index]);
                    }); 
                }
            });
            this.on("errormultiple", function (files, response) {});
            this.on("addedfile", function(file) { 
            //上传文件时触发的事件
            });
        }
    });
JS;
$this->registerJs($js);
?>
</body>
