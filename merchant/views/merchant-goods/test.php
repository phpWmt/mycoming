
<?php
//use backend\assets\AppAsset;
//AppAsset::addJs($this,'/js/plugins/dropzone/dropzone.js');
//AppAsset::addCss($this,'/css/plugins/dropzone/basic.css');
//AppAsset::addCss($this,'/css/plugins/dropzone/dropzone.css');
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>文件上传</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="form_file_upload.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="form_file_upload.html#">选项1</a>
                            </li>
                            <li><a href="form_file_upload.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <?php
                use twitf\dropzone\Dropzone;
                Dropzone::widget([
                    'id'=>'test_zone',
                    'addRemoveLinks'=> true, //添加移除文件
                    'autoProcessQueue'=> false, //自动上传
                    'uploadMultiple'=> true,//是否在一个请求中发送多个文件
                    'parallelUploads'=> 100,//并行处理多少个文件上传
                    'maxFilesize'=> $maxFilesize,
                    'maxFiles'=> 5,
                    'paramName'=>"title",//后台接收时的name名称 例如title[0] title[1]......
                    'dictCancelUploadConfirmation'=> 'qeuren',
                    'acceptedFiles'=> ".jpg,.gif,.png,.git", //上传的类型
                    //dictMaxFilesExceeded'=> "您最多只能上传5个文件！",
                    'dictResponseError'=> '文件上传失败!',
                    'dictFallbackMessage'=> "浏览器不受支持",
                ]);

                ?>

                <div class="ibox-content">
                    <form id="my-awesome-dropzone" class="dropzone" action="<?php echo \yii\helpers\Url::to(['goods/upload']) ?>">
                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <div class="dropzone-previews"></div>
                        <button type="submit" class="btn btn-primary pull-right">提交</button>
                    </form>

                    <div>
                        <div class="m"><small>DropzoneJS是一个开源库，提供拖放文件上传与图片预览：<a href="https://github.com/enyo/dropzone" target="_blank">https://github.com/enyo/dropzone</a></small>，百度前端团队提供的
                            <a href="http://fex.baidu.com/webuploader/" target="_blank">Web Uploader</a>也是一个非常不错的选择，值得一试！</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
//$maxFilesize=get_cfg_var ("post_max_size")?(int)get_cfg_var ("post_max_size"):0;
//$js=<<<JS
//    Dropzone.options.myAwesomeDropzone = {
//        addRemoveLinks: true, //添加移除文件
//        autoProcessQueue: false, //自动上传
//        uploadMultiple: true,//是否在一个请求中发送多个文件
//        parallelUploads: 5,//并行处理多少个文件上传
//        maxFilesize: $maxFilesize,
//        maxFiles: 5,
//        paramName:"title",//后台接收时的name名称 例如title[0] title[1]......
//        dictCancelUploadConfirmation: 'qeuren',
//        acceptedFiles: ".jpg,.gif,.png,.git", //上传的类型
//        //dictMaxFilesExceeded: "您最多只能上传5个文件！",
//        dictResponseError: '文件上传失败!',
//        dictFallbackMessage: "浏览器不受支持",
//        //dictFileTooBig: "文件过大上传文件最大支持20MB.",
//        // Dropzone settings
//        init: function () {
//            var myDropzone = this;
//
//            this.element.querySelector("button[type=submit]").addEventListener("click",function (e) {
//                    e.preventDefault();
//                    e.stopPropagation();
//                    myDropzone.processQueue();
//                });
//
//            this.on("queuecomplete",function(file) {
//                //上传完成后触发的方法
//                this.on("removedfile",function(file){
//                    //删除文件时触发的方法
//                    alert("删除文件");
//                });
//            });
//
//        }
//
//    }
//JS;
//$this->registerJs($js);
//?>
</body>
