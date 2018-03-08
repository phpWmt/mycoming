<?php
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-sm-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>添加优惠卷</h5>
                    <div class="ibox-tools">


                    </div>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal m-t myform" action="<?php echo Url::to(['coupon/add'])?>" method="post">
                        <input name="_csrf-backend" type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">优惠卷名称：</label>
                            <div class="col-sm-8">
                                <div style="width:100%">
                                    <input type="text" name="name" placeholder="例如：(满减卷100元)  注意名重复" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">优惠卷类型：</label>
                            <div class="radio i-checks type">
                                <label>满减卷
                                    <input type="radio" checked="" name="coupon_type" value="1">
                                    <i></i>
                                </label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">优惠卷详情：</label>
                            <div class="input-group col-sm-7" id="coupon_details" style="padding-left: 15px;">
                                <span class="input-group-addon">购物满</span>
                                <input type="number" step="0.01" class="input-sm form-control" name="max_price" required datatype="*" nullmsg="不可为空">
                                <span class="input-group-addon">元可抵扣</span>
                                <input type="number" step="0.01" class="input-sm form-control" name="deductible" required datatype="*" nullmsg="不可为空">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">有效时间：</label>
                            <div class="input-group col-sm-7" style="padding-left: 15px;">
                                <span class="input-group-addon">开始&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <input type="text" id="begin_time" class="input-sm form-control time" name="begin_time" placeholder="点击此处选择开始时间" required datatype="*" nullmsg="不可为空">
                                <span class="input-group-addon">结束时间</span>
                                <input type="text" id="end_time" class="input-sm form-control time" name="end_time" placeholder="点击此处选择结束时间" required datatype="*" nullmsg="不可为空">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3">
                                <button class="btn btn-primary" id="submit" type="submit">添加优惠卷</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>


<?php
$js=<<<JS
    $(".i-checks").iCheck({checkboxClass: "icheckbox_square-green", radioClass: "iradio_square-green"});
        
            lay('.time').each(function(index,obj){
                var date_value=index==1?new Date():'';
                laydate.render({
                elem: obj,
                type: 'datetime',
                theme:'molv',//墨绿主题
                trigger: 'click',//日期只读
                value:date_value
                });
            });
            
    var url = '';
    var title = '';
    var p = 1;//页码默认等于1
    var indexes = '';//layer弹窗索引
    var layer_div = '';//layer弹窗dom
    var search = '';
    var user_id = '';
    var goods_id = '';
    $(document).ready(function () {
        $('.i-checks').iCheck({
            radioClass: 'iradio_square-green',
        });

        //优惠卷类型
        $('.type input[type="radio"]').on('ifChecked', function (event) {
            //alert(event.type + ' callback');
            if ($(this).val() == 2) {
                $('#coupon_details').html('<span class="input-group-addon">购物满</span>'+
                    '<input type="number" class="input-sm form-control" name="max_price" required>'+
                    '<span class="input-group-addon">可打</span>'+
                    '<input type="number" step="0.01" class="input-sm form-control" name="discount" required>'+'<span class="input-group-addon">折</span>');
                $('#condition').show();
            } else if ($(this).val() == 1) {
                $('#coupon_details').html('<span class="input-group-addon">购物满</span>' +
                    '<input type="number" step="0.01" class="input-sm form-control" name="max_price" required>' +
                    '<span class="input-group-addon">元可抵扣</span>' +
                    '<input type="number" step="0.01" class="input-sm form-control" name="deductible" required>');
                $('#condition').show();
            } else if ($(this).val() == 3) {
                $('#coupon_details').html('<span class="input-group-addon">购物满</span>' +
                    '<input type="number" step="0.01" class="input-sm form-control" name="max_price" required>' +
                    '<span class="input-group-addon">包邮</span>');
                $('#condition').show();
            } else {
                $('#coupon_details').html('<span class="input-group-addon">优惠金额</span><input type="number" step="0.01" class="input-sm form-control" name="deductible" required>')
                $('#condition').hide();
            }
        });

        //优惠卷指定限制
        $('.list input[type="radio"]').on('ifChecked', function (event) {
            //alert(event.type + ' callback');
            if ($(this).val() == 3) {
                $('#goods_list').hide();
                $('#user_list').show();
            } else {
                $('#user_list').hide();
            }
            if ($(this).val() == 1) {
                $('#goods_list').show();
                $('#goods_info').text('可选择以下商品不参加此营销活动');
            }
            if ($(this).val() == 2) {
                $('#goods_list').show();
                $('#goods_info').text('请选择参加此营销活动的商品');
            }
        });

        //确认按钮
        $(document).on('click', '.affirm', function () {
            var goods_type = $('input:radio[name="goods_type"]:checked').val();
            var result = '';
            if (goods_type == 3) {
                result += '<tr>'
                    + '<td>' + $(this).attr('data-account') + '<input hidden class="user_id" value="' + $(this).attr('data-id') + '"></td>'
                    + '<td>' + $(this).attr('data-phone') + '</td>'
                    + '<td>' + $(this).attr('data-real_name') + '</td>'
                    + '<td>' +
                    '<button type="button" class="btn btn-sm btn-outline btn-danger" onclick="$(this).parent().parent().remove()">删除</button>' +
                    '</td>'
                    + '</tr>';
                $('#user_list tbody').append(result);
            } else {
                result += '<tr>'
                    + '<td><img src="/' + $(this).attr('data-images').split('*')[0] + '" width="50px" height="50px"></td>'
                    + '<td>' + $(this).attr('data-goods_name') + '<input hidden class="goods_id" value="' + $(this).attr('data-id') + '"></td>'
                    + '<td>' + $(this).attr('data-type_name') + '</td>'
                    + '<td>' +
                    '<button type="button" class="btn btn-sm btn-outline btn-danger" onclick="$(this).parent().parent().remove()">删除</button>' +
                    '</td>'
                    + '</tr>';
                $('#goods_list tbody').append(result);
            }
            $(this).parent().parent().remove();

        });
        //搜索按钮
        $(document).on('click', '#search', function () {
            search = $(this).parent().parent().find('input').val();
            get_list();
        });
        //添加商品
        $('#add_goods').on('click', function () {
            url = '__URL__/goods';
            title = '添加商品';
            //初始化goods_id
            goods_id = '';
            $('#goods_list tbody').find('input[class="goods_id"]').each(function () {
                goods_id += $(this).val() + ',';
            });
            get_list();
        });
        //添加用户
        $('#add_user').on('click', function () {
            url = '__URL__/user';
            title = '添加用户';
            //初始化user_id
            user_id = '';
            $('#user_list tbody').find('input[class="user_id"]').each(function () {
                user_id += $(this).val() + ',';
            });
            get_list();
        });
    });

    function page(page_num) {
        p = page_num;
        get_list();
    }

    /**
     * 弹出层
     */
    function get_list() {
        var loading;
        var obj = $(this);
        var result = '';
        var table_html = '';
        //如果是当前的页码 则不提交
        if ($('.pagination li.active a').text == p) {
            p = '';
        }
        $.ajax({
            type: "post",
            url: url,
            data: {
                'p': p,
                'search': search,
                'user_id': user_id,
                'goods_id': goods_id
            },
            dataType: "json",
            beforeSend: function () {
                //防止重复提交
                obj.attr('disabled', true);
                loading = layer.load(1, {
                    shade: [0.1, '#fff'] //0.1透明度的白色背景
                });
            },
            success: function (data) {
                var len = data.list.length;
                var goods_type = $('input:radio[name="goods_type"]:checked').val();
                if (len > 0) {
                    if (goods_type == 3) {
                        for (var i = 0; i < len; i++) {
                            result += '<tr>'
                                + '<td>' + data['list'][i].account + '</td>'
                                + '<td>' + data['list'][i].phone + '</td>'
                                + '<td>' + data['list'][i].real_name + '</td>'
                                + '<td>' +
                                '<button data-id="' + data['list'][i].id + '" data-account="' + data['list'][i].account + '" data-phone="' + data['list'][i].phone + '" data-real_name="' + data['list'][i].real_name + '" type="button" class="btn btn-sm btn-outline btn-primary affirm">添加</button>' +
                                '</td>'
                                + '</tr>';
                        }
                    } else {
                        for (var i = 0; i < len; i++) {
                            var images = data['list'][i].images;
                            result += '<tr>'
                                + '<td><img src="/' + images.split('*')[0] + '" width="50px" height="50px"></td>'
                                + '<td>' + data['list'][i].goods_name + '</td>'
                                + '<td>' + data['list'][i].type_name + '</td>'
                                + '<td>' +
                                '<button data-id="' + data['list'][i].id + '" data-images="' + data['list'][i].images + '" data-goods_name="' + data['list'][i].goods_name + '" data-type_name="' + data['list'][i].type_name + '" type="button" class="btn btn-sm btn-outline btn-primary affirm">添加</button>' +
                                '</td>'
                                + '</tr>';
                        }
                    }
                    table_html += '<div class="ibox-content">'
                        + '<div class="row">'
                        + '<div class="col-sm-3">'
                        + '<div class="input-group">'
                        + '<input type="text" name="keyword" placeholder="请输入关键词" class="input-sm form-control">'
                        + '<span class="input-group-btn">'
                        + '<button type="button" class="btn btn-sm btn-primary" id="search"> 搜索</button>'
                        + '</span>'
                        + '</div>'
                        + '</div>'
                        + '</div>'
                        + '<div class="table-responsive">'
                        + '<table class="table table-striped">'
                        + '<thead>'
                        + '<tr>';
                    if (goods_type == 3) {
                        table_html += '<th>账号</th>'
                            + '<th>手机号</th>'
                            + '<th>姓名</th>'
                            + '<th>操作</th>';
                    } else {
                        table_html += '<th>图片</th>'
                            + '<th>商品名称</th>'
                            + '<th>分类名称</th>'
                            + '<th>操作</th>';
                    }

                    table_html += '</tr>'
                        + '</thead>'
                        + '<tbody>'
                        + result
                        + '</tbody>'
                        + '</table>'
                        + '<div class="col-sm-12" id="page">'
                        + '<span class="col-sm-3 pull-left">共<strong>' + data.count + '</strong>条记录</span>'
                        + '<div class="pull-right col-sm-8" >'
                        + data.page
                        + '</div>'
                        + '</div>'
                        + '</div>';
                    if (!document.getElementById('layui-layer' + indexes)) {
                        layer.open({
                            type: 1 //Page层类型
                            , area: ['800px', '500px']
                            , title: title
                            , shade: 0.6 //遮罩透明度
                            , maxmin: true //允许全屏最小化
                            , anim: 1 //0-6的动画形式，-1不开启
                            , content: table_html
                            , success: function (layero, index) {
                                layer_div = layero;
                                indexes = index;
                            }
                        });
                    } else {
                        layer_div.find('.ibox-content').remove();
                        layer_div.find('.layui-layer-content').prepend(table_html);
                    }
                } else {
                    layer.alert('暂无更多数据', {
                        icon: 5,
                        skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                    })
                }
            },
            complete: function () {
                layer.close(loading);
                //取消禁止提交
                obj.attr('disabled', false);
            },
            error: function () {
                layer.msg('网络故障，请刷新重试:(');
            }
        });
    }


    var start = {
        elem: "#begin_time",
        format: "YYYY-MM-DD hh:mm:ss",
        min: laydate.now(),
        max: "2099-06-16 23:59:59",
        istime: true,
        istoday: false,
        choose: function (datas) {
            end.min = datas;
            end.start = datas
        }
    };
    var end = {
        elem: "#end_time",
        format: "YYYY-MM-DD hh:mm:ss",
        min: laydate.now(),
        max: "2099-06-16 23:59:59",
        istime: true,
        istoday: false,
        choose: function (datas) {
            start.max = datas
        }
    };
    laydate(start);
    laydate(end);
    $('#submit').on('click', function () {
        var goods_type = $('input:radio[name="goods_type"]:checked').val();
        var data = '';
        if (goods_type == 3) {
            user_id = '';
            $('#user_list tbody').find('input[class="user_id"]').each(function () {
                user_id += $(this).val() + ',';
            });
            if (user_id == '') {
                layer.alert('请选择指定的用户', {
                    icon: 5,
                    skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                })
                return false;
            } else {
                data = {'user_id': user_id};
            }
        } else {
            goods_id = '';
            $('#goods_list tbody').find('input[class="goods_id"]').each(function () {
                goods_id += $(this).val() + ',';
            });
            if (goods_type == 2 && goods_id == '') {
                layer.alert('请选择指定的商品', {
                    icon: 5,
                    skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                });
                return false;
            }
            data = {'goods_id': goods_id};
        }
        $('.myform').ajaxForm({
            url: "__URL__/add",
            type: "post",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data.status === 'success') {
                    layer.msg(data.info);
                    setTimeout(function () {
                        window.location.href = '__URL__/index';
                    }, 500);
                } else {
                    layer.alert(data.info, {
                        icon: 5,
                        skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
                    })
                }
            }
        });
    });

JS;
$this->registerJs($js);
?>