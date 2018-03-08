/**
 *
 * @param id  初始化的divID
 * @param paramName 上传的name名
 * @param maxFilesize 限制文件大小
 * @param maxFiles 限制文件数量
 * @param crsfValue crsf验证的值
 */
function createDropzone(id,paramName,maxFilesize,maxFiles,crsfValue,img_update=null){
    $("div#"+id).dropzone({
        params:{'_csrf-backend':crsfValue,'paramName':paramName},
        url:"/goods/create",
        addRemoveLinks: true, //添加移除文件
        autoProcessQueue: false, //自动上传
        uploadMultiple: true,//是否在一个请求中发送多个文件
        parallelUploads: 100,//并行处理多少个文件上传
        maxFilesize: maxFilesize,
        maxFiles: maxFiles,
        paramName:paramName,//后台接收时的name名称 例如title[0] title[1]......
        dictCancelUploadConfirmation: 'qeuren',
        acceptedFiles: ".jpg,.gif,.png,.git", //上传的类型
        //dictMaxFilesExceeded: "您最多只能上传5个文件！",
        dictResponseError: '文件上传失败!',
        dictFallbackMessage: "浏览器不受支持",
        init: function () {
            var myDropzone = this;
            this.element.querySelector("button[id=upload_img]").addEventListener("click",function (e) {
                e.preventDefault();
                e.stopPropagation();
                myDropzone.processQueue();
            });
            //判断是否回显
            if (img_update!=null){
                $.each(img_update,function(index,data){
                    var mockFile ={name:data.name, size: data.size,data_url:data.url,i:index};
                    myDropzone.emit("addedfile", mockFile);
                    myDropzone.emit("thumbnail", mockFile,data.url);
                    myDropzone.emit("complete", mockFile);
                    var existingFileCount = 1; // The number of files already uploaded
                    myDropzone.options.maxFiles = myDropzone.options.maxFiles - existingFileCount;
                });
            }
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
                        data: {"url":url,"_csrf-backend": $("meta[name='csrf-token']").attr("content")},
                        dataType: "json",
                        success:function (response) {
                            if (response.status===1){

                            }
                        }
                    });
                });
            });
            i=0;
            //上传成功后返回的信息
            this.on("successmultiple", function (files, response) {
                var paramName=this.options.paramName;
                var dz=$("#"+id).find(".dz-success a[class=dz-remove]");
                var dz_length=dz.length;
                if (dz_length===response.length){
                    dz.each(function(index,obj) {
                        obj.setAttribute("data-url",response[index]);
                        $("<input name="+paramName+"["+i+"]"+" type= hidden value="+response[index]+">").appendTo(obj);
                        i++;
                    });
                }else{
                    //当前- 实际 -  0-> start下标
                    var length=dz_length-response.length-1;
                    $("#"+id).find(".dz-success:gt("+length+") a[class=dz-remove]").each(function(index,obj) {
                        obj.setAttribute("data-url",response[index]);
                        $("<input name="+paramName+"["+i+"]"+" type= hidden value="+response[index]+">").appendTo(obj);
                        i++;
                    });
                }

            });
        }
    });
}
