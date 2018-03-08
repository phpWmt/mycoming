<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>用户注册</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="amazeui/css/amazeui.min.css"/>
    <link rel="stylesheet" href="default/style.css"/>
    <script src="amazeui/js/jquery.min.js"></script>
    <script src="amazeui/js/amazeui.min.js"></script>
</head>

<body>
<div class="container">
    <header data-am-widget="header" class="am-header am-header-default my-header">
        <div class="am-header-left am-header-nav">
            <a href="#left-link" class="">
                <i class="am-header-icon am-icon-chevron-left"></i>
            </a>
        </div>
        <h1 class="am-header-title">
            <a href="#title-link" class="">用户注册</a>
        </h1>
        <div class="am-header-right am-header-nav">
            <a href="#right-link" class="">
                <i class="am-header-icon  am-icon-home"></i>
            </a>
        </div>
    </header>
    <div class="cart-panel">
        <form class="am-form">
            <div class="am-form-group am-form-icon">
                <i class="am-icon-user" style="color:#329cd9"></i>
                <input type="text" class="am-form-field  my-radius" placeholder="请输入您的用户名">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-lock" style="color:#329cd9"></i>
                <input type="password" class="am-form-field  my-radius" placeholder="请输入您的密码">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-lock" style="color:#e9c740"></i>
                <input type="password" class="am-form-field  my-radius" placeholder="请重复输入一次密码">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-envelope" style="color:#78c3ca"></i>
                <input type="text" class="am-form-field  my-radius" placeholder="请输入邮箱号码">
            </div>
            <div class="am-form-group am-form-icon">
                <i class="am-icon-phone" style="color:#f09513"></i>
                <input type="text" class="am-form-field  my-radius" placeholder="请输入联系电话">
            </div>
            <div class="am-checkbox">
                <label>
                    <input type="checkbox"> 我已阅读并同意<a href="#">《协议》</a>
                </label>
            </div>
            <p class="am-text-center"><button type="submit" class="am-btn am-btn-danger am-radius am-btn-block">立即注册</button></p>
        </form>
    </div>

    <footer data-am-widget="footer" class="am-footer am-footer-default" data-am-footer="{  }">
        <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>
        <div class="am-footer-miscs ">
            <p>CopyRight©2014 AllMobilize Inc.</p>
            <p>京ICP备13033158</p>
        </div>
    </footer>
    <!--底部-->
    <div data-am-widget="navbar" class="am-navbar am-cf my-nav-footer " id="">
        <ul class="am-navbar-nav am-cf am-avg-sm-4 my-footer-ul">
            <li>
                <a href="/wap/" class="">
                    <span class="am-icon-home"></span>
                    <span class="am-navbar-label">首页</span>
                </a>
            </li>
            <li>
                <a href="###" class="">
                    <span class=" am-icon-phone"></span>
                    <span class="am-navbar-label">电话</span>
                </a>
            </li>
            <li>
                <a href="###" class="">
                    <span class=" am-icon-comments"></span>
                    <span class="am-navbar-label">聊天</span>
                </a>
            </li>
            <li>
                <a href="#" class="">
                    <span class=" am-icon-map-marker"></span>
                    <span class="am-navbar-label">地图</span>
                </a>
            </li>
            <li style="position:relative">
                <a href="javascript:;" onClick="showFooterNav();" class="">
                    <span class="am-icon-user"></span>
                    <span class="am-navbar-label">会员</span>
                </a>
                <div class="footer-nav" id="footNav">
                    <span class=" am-icon-bank"><a href="#">买家中心</a></span>
                    <span class="am-icon-suitcase"><a href="#">卖家中心</a></span>
                    <span class="am-icon-usd"><a href="#">我的钱包</a></span>
                    <span class="am-icon-user"><a href="#">个人资料</a></span>
                    <span class="am-icon-th-list"><a href="#">帮助中心</a></span>
                    <span class="am-icon-comments"><a href="#">消息中心</a></span>
                    <span class="am-icon-power-off"><a href="#">安全退出</a></span>
                </div>
            </li>

        </ul>
        <script>
            function showFooterNav(){
                $("#footNav").toggle();
            }
        </script>
    </div>
</div>
</body>
</html>
