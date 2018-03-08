function createDropzone(clientOptions){
    Dropzone.autoDiscover = false;
    $("div#"+this.options.id).dropzone({
        clientOptions,
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
                        data: {"url":this.options.delUrl,"_csrf-backend": $("meta[name='csrf-token']").attr("content")},
                        dataType: "json",
                        success:function (response) {
                            if (response.status===1){

                            }
                        }
                    });
                });
            });

            //上传成功后返回的信息
            this.on("successmultiple", function (files, response) {
                var paramName=this.options.paramName;
                var dz=$("#"+this.options.id).find(".dz-success a[class=dz-remove]");
                var dz_length=dz.length;
                if (dz_length===response.length){
                    dz.each(function(index,obj) {
                        obj.setAttribute("data-url",response[index]);
                        $("<input name="+paramName+index+" type= hidden value="+response[index]+">").appendTo(obj);
                    });
                }else{
                    //当前- 实际 - 0下标
                    var length=dz_length-response.length-1;
                    $("#"+this.options.id).find(".dz-success:gt("+length+") a[class=dz-remove]").each(function(index,obj) {
                        obj.setAttribute("data-url",response[index]);
                    });
                }
            });
        }
    });
}
