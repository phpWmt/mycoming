<script>
    function checkIsInteger(str)
    {
        //如果为空，则通过校验
        if(str == "")
            return true;
        if(/^(\-?)(\d+)$/.test(str))
            return true;
        else
            return false;
    }
    var errordialog=function(c){
        alert(c)
    }
    //检验商品数量
    function checkCounts(id) {
        var Counts = $("#" + id).val();
        if (Counts == "") {
            errordialog("请填写数量!");
            return false;
        }
        else if (!checkIsInteger(Counts)) {
            errordialog("商品数量不是整数!");
            return false;
        }
        else if (Counts < 1) {
            errordialog("商品数量不能小于1!");
            return false;
        }
        else {
            return true;
        }
    }
    function addQty(){
        checkCounts('txtQty');
        var qty = parseInt($('#txtQty').val());
        $('#txtQty').val(qty+1);
    }
    function subtractQty(){
        checkCounts('txtQty');
        var qty = parseInt($('#txtQty').val());
        if(qty <=1){
            errordialog("商品数量不能小于1");
            return;
        }
        $('#txtQty').val(qty-1);
    }
</script>

<body>
<div class="container">
    <header data-am-widget="header" class="am-header am-header-default my-header">
        <div class="am-header-left am-header-nav">
            <a href="#left-link" class="">
                <i class="am-header-icon am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="#title-link" class="">运动功能饮料</a>
        </h1>
        <div class="am-header-right am-header-nav">
            <a href="#right-link" class="">
                <i class="am-header-icon  am-icon-home"></i>
            </a>
        </div>
    </header>
    <!-- banner -->
    <div data-am-widget="slider" class="am-slider am-slider-a1" data-am-slider='{&quot;directionNav&quot;:false}'>
        <ul class="am-slides">
            <li>
                <img src="http://s.amazeui.org/media/i/demos/bing-1.jpg">
            </li>
            <li>
                <img src="http://s.amazeui.org/media/i/demos/bing-2.jpg">
            </li>
            <li>
                <img src="http://s.amazeui.org/media/i/demos/bing-3.jpg">
            </li>
            <li>
                <img src="http://s.amazeui.org/media/i/demos/bing-4.jpg">
            </li>
        </ul>
    </div>
    <div class="gray-panel">
        <div class="paoduct-title-panel">
            <h1 class="product-h1">运动功能饮料</h1>
            <p><span class="am-fr product-title-gray-text"><i class="am-icon-star"></i>收藏</span><span class="bold">价格：</span><span class="red2">￥60.00</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="product-title-gray-text">积分：300积分</span></p>
        </div>
        <div class="my-search-title-panel">
            <ul class="am-avg-sm-4 am-text-center am-text-sm">
                <li class="am-text-center">销量<br />0件</li>
                <li class="am-text-center">库存<br />0件</li>
                <li class="am-text-center">订单<br />0个</li>
                <li class="am-text-center">评价<br />0条</li>
            </ul>
        </div>
        <div class="my-search-title-panel">
            <p class="my-search-titp-p am-text-sm bold">尺码</p>
            <p class="size-p" id="sizep"><span data-size="S">S</span><span data-size="M">M</span><span data-size="L">L</span><span data-size="XL">XL</span><span data-size="XXL">XXL</span><input type="hidden" id="size" name="size" value="" /></p>
            <script>
                $(document).ready(function(e) {
                    $("#sizep span").click(function(){
                        $("#sizep span").removeClass('click');
                        $(this).addClass('click');
                        var s = $(this).attr('data-size');
                        $("#size").val(s);
                    });
                    $("#colorp span").click(function(){
                        $("#colorp span").removeClass('click');
                        $(this).addClass('click');
                        var s = $(this).attr('data-color');
                        $("#color").val(s);
                    });

                });
            </script>
            <hr data-am-widget="divider" style="" class="am-divider-default am-margin-bottom-sm"/>
            <p class="my-search-titp-p am-text-sm bold">颜色分类</p>
            <p class="size-p" id="colorp">
                <span data-color="酒红色">酒红色</span><span data-color="黑色">黑色</span><input type="hidden" id="color" name="color" value="" />
            </p>
            <hr data-am-widget="divider" style="" class="am-divider-default am-margin-bottom-sm"/>
            <p class="my-search-titp-p am-text-sm bold">数量</p>
            <div style="overflow:hidden">
                <form class="am-form-inline" role="form">
                    <button type="button" class="am-btn am-btn-default" style="float:left" onClick="subtractQty();" ><i class="am-icon-minus"></i></button>
                    <input type="number" name="txtQty" id="txtQty" class="am-form-field txt-qty am-text-center am-text-sm" value="1" style=" width:60px; margin-right:0px; height:37px; display:inline; float:left">
                    <button type="button" class="am-btn am-btn-default" style="float:left" onClick="addQty();"><i class="am-icon-plus"></i></button>
                </form>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider-default am-margin-bottom-sm"/>
            <div>
                <ul class="am-avg-sm-2 am-text-center">
                    <li class="am-text-center am-padding-sm"><button type="button" class="am-btn am-btn-success am-btn-block am-radius">加入购物车</button></li>
                    <li class="am-text-center am-padding-sm"><button type="button" class="am-btn am-btn-danger am-btn-block am-radius">立即购买</button></li>
                </ul>
            </div>
        </div>
        <div class="paoduct-title-panel">
            <h2 class="product-h1">商家信息</h2>
            <p><span class="am-fr product-title-gray-text"><a href="tel:88888888" class=" am-text-success"><i class="am-icon-phone"></i> 电话联系</a></span><span class="product-title-gray-text"><i class="am-icon-crosshairs"></i> 平区回笼观黄平路19号</span></p>
            <hr data-am-widget="divider" style="" class="am-divider-default am-margin-bottom-sm"/>
            <div style="overflow:hidden">
                <ul class="am-avg-sm-2 am-text-center am-padding-bottom-sm">
                    <li class="am-text-center"><a href="#"><i class="am-icon-bank"></i> 进店逛逛</a></li>
                    <li class="am-text-center"><a href="#"><i class=" am-icon-comments"></i> 联系卖家</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 商品详情 -->

    <div data-am-widget="tabs" class="am-tabs am-tabs-d2">
        <ul class="am-tabs-nav am-cf">
            <li class="am-active">
                <a href="[data-tab-panel-0]">详情</a>
            </li>
            <li class="">
                <a href="[data-tab-panel-1]">交易记录</a>
            </li>
            <li class="">
                <a href="[data-tab-panel-2]">评价</a>
            </li>
        </ul>
        <div class="am-tabs-bd">
            <div data-tab-panel-0 class="am-tab-panel am-active">【青春】那时候有多好，任雨打湿裙角。忍不住哼起，心爱的旋律。绿油油的树叶，自由地在说笑。燕子忙归巢，风铃在舞蹈。经过青春的草地，彩虹忽然升起。即使视线渐渐模糊，它也在我心里。就像爱过的旋律，没人能抹去。因为生命存在失望，歌唱，所以才要歌唱。</div>
            <div data-tab-panel-1 class="am-tab-panel ">

                <ul class="am-list am-list-static am-list-border am-list-striped am-text-sm">
                    <li>XXX于2015-6-5日购买成功</li>
                    <li>XXX于2015-6-5日购买成功</li>
                    <li>XXX于2015-6-5日购买成功</li>
                    <li>XXX于2015-6-5日购买成功</li>
                    <li>XXX于2015-6-5日购买成功</li>
                    <li>XXX于2015-6-5日购买成功</li>
                </ul>

            </div>
            <div data-tab-panel-2 class="am-tab-panel ">
                <div class="am-cf am-padding-sm" >
                    <ul class="am-comments-list am-comments-list-flip">
                        <li class="am-comment">
                            <a href="">
                                <img class="am-comment-avatar" src="/default/img1.jpg" alt=""/> <!-- 头像 -->
                            </a>

                            <div class="am-comment-main">
                                <header class="am-comment-hd">
                                    <div class="am-comment-meta">
                                        <a href="#link-to-user" class="am-comment-author">昵称</a>（他的用户名）
                                        <time datetime="2013-07-27T04:54:29-07:00" title="最后的通信时间" class="am-fr">2014-7-12 15:30</time>
                                    </div>
                                </header>
                                <div class="am-comment-bd am-text-sm">
                                    那，那是一封写给南部母亲的信。我茫然站在骑楼下，我又看到永远的樱子走到街心。
                                </div>
                            </div>
                        </li>
                        <li class="am-comment">
                            <a href="">
                                <img class="am-comment-avatar" src="default/img1.jpg" alt=""/> <!-- 头像 -->
                            </a>

                            <div class="am-comment-main">
                                <header class="am-comment-hd">
                                    <div class="am-comment-meta">
                                        <a href="#link-to-user" class="am-comment-author">昵称</a>（他的用户名）
                                        <time datetime="2013-07-27T04:54:29-07:00" title="最后的通信时间" class="am-fr">2014-7-12 15:30</time>
                                    </div>
                                </header>
                                <div class="am-comment-bd am-text-sm">
                                    其实雨下得并不大，却是一生一世中最大的一场雨。而那封信是这样写的，年轻的樱子知不知道呢？
                                </div
                                ></div>
                        </li>
                        <li class="am-comment"><!-- 头像显示在右手边 am-comment-flip -->
                            <a href="">
                                <img class="am-comment-avatar" src="default/img1.jpg" alt=""/> <!-- 头像 -->
                            </a>

                            <div class="am-comment-main">
                                <header class="am-comment-hd">
                                    <div class="am-comment-meta">
                                        <a href="#link-to-user" class="am-comment-author">昵称</a>（他的用户名）
                                        <time datetime="2013-07-27T04:54:29-07:00" title="最后的通信时间" class="am-fr">2014-7-12 15:30</time>
                                    </div>
                                </header>
                                <div class="am-comment-bd  am-text-sm">
                                    She's gone 我早知道
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
</body>

