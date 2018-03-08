<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

?>
<body class="gray-bg">
<div class="wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><i class="fa fa-user-secret">　</i>用户统计</h3>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-5 p-m">
                            <form method="get" action="/user/search">
                                <div class="input-group list-group col-sm-4">
                                    <input type="text" name="keyword" placeholder="请输入手机号、昵称"
                                           class="input-sm form-control">
                                    <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-primary">搜索</button></span>
                                </div>
                            </form>
                            <!--                            <button id="delete_all" class="btn btn-sm btn-outline btn-danger m-l del_all" type="button">-->
                            <!--                                <i class="fa fa-user-times"></i>批量删除-->
                            <!--                            </button>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

$js = <<<JS

    $(document).ready(function () {
        $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"})
            // 全选
        $('.all-checks').on('ifChecked', function (event) {
            $("input[type='checkbox']").iCheck('check');
        });
        // 反选
        $('.all-checks').on('ifUnchecked', function (event) {
            $("input[type='checkbox']").iCheck('uncheck');
        });
    });

    $("#delete_all").click(function() {
       
        var id='';
        $('input[name="check"]:checked').each(function (i, obj) {
            id=$(obj).val()+','+id;
        });
        
        $(".myform").ajaxSubmit({
        url: "/room/update",
        type: "post",
        dataType: "json",
        success: function (data) {
            if(data.status === 1) {
                $("#update_status").text(data.info);
                setTimeout(function (){
               window.location.reload();
                }, 800);
            }else{
                $("#update_status").text(data.info);
            } 
        }
        });
    });
    //状态更改
    
    $('.status').click(function() {
      if ($(this).hasClass('off')){
          var status = '2';
      }else {
          var status = '1';
      }
     
      $.ajax({
            url:"/user/status",
            data:{id:$(this).attr('id'),status:status},
            type:"post",    
            success:function(e) {
                if (e == '1'){
                    
                    var success=dialog({content: '操作成功'}).showModal();
                        setTimeout(function () {
                            success.close();
                            window.location.reload();
                        }, 1000);
                }else {
                    layer.msg('请重试');
                    setTimeout(function (){
                        window.location.reload();
                    }, 800);
                }
            }
              
      })
    })
JS;
$this->registerJs($js);
?>
</body>