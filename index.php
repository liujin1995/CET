<?php
SESSION_START();
if(!empty($_SERVER['QUERY_STRING'])){
header("location:http://www.unique-liu.com/cet/");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="baidu-site-verification" content="elifkrmPVG" />
<?php
require_once "sdk.php";
$jssdk = new JSSDK("wxca8373b65e268443", "d4624c36b6795d1d99dcf0547af5443d");
$signPackage = $jssdk->GetSignPackage();
$_SESSION['yzm']=$signPackage["signature"];
?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            // 所有要调用的 API 都要加到这个列表中
            'checkJsApi',
            'openLocation',
            'getLocation',
            'onMenuShareTimeline',
            'onMenuShareAppMessage'
          ]
    });
  wx.ready(function () {
     var wxTitle = "CET成绩查询-无证查询",
        wxDesc = "程序猿刘锦编写的查询CET成绩查询和无证查询系统。", 
        _imgurl = 'http://www.unique-liu.com/cet/slj.jpg',
        linkUrl = document.location.href + "?v" + Math.random();
        WeixinJSBridge.on('menu:share:timeline',function(argv){
            WeixinJSBridge.invoke('shareTimeline', {
                "imgUrl": _imgurl,
                "img_width": "120",
                "img_height": "120",
                "link": linkUrl,
                "desc": wxTitle,
                "title": wxTitle
            }, function() {});
        })
        WeixinJSBridge.on('menu:share:appmessage', function(argv){
            WeixinJSBridge.invoke('sendAppMessage', {
                "imgUrl": _imgurl,
                "link": linkUrl,
                "desc": wxDesc,
                "title": wxTitle
            }, function() {})
        })
        WeixinJSBridge.on('menu:share:weibo', function(argv) {
            WeixinJSBridge.invoke('shareWeibo', {
                "content": wxTitle,
                "url": linkUrl,
            }, function(res) {});
        })  });
</script>
<script>
wx.onMenuShareAppMessage({
          title: "CET成绩查询-无证查询",
          desc: "程序猿刘锦编写的查询CET成绩查询和无证查询系统。", 
          link: 'http://www.unique-liu.com/cet/',
          imgUrl: 'http://www.unique-liu.com/cet/slj.jpg',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            // alert('用户点击发送给朋友');
          },
          success: function (res) {
            // alert('已分享');
          },
          cancel: function (res) {
            // alert('已取消');
          },
          fail: function (res) {
            // alert(JSON.stringify(res));
          }
        });

        wx.onMenuShareTimeline({
          title: "CET成绩查询-无证查询",
          link: 'http://www.unique-liu.com/cet/',
          imgUrl: 'http://www.unique-liu.com/cet/slj.jpg',
          trigger: function (res) {
            // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            // alert('用户点击分享到朋友圈');
          },
          success: function (res) {
            // alert('已分享');
          },
          cancel: function (res) {
            // alert('已取消');
          },
          fail: function (res) {
            // alert(JSON.stringify(res));
          }
        });
</script>
<title>CET成绩查询</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="keywords" content="四级,六级,四六级,四级成绩查询,六级成绩查询,CET无证查询" />
<meta name="description" content="欢迎来到刘锦编写的CET成绩查询，一个关注IT技术分享，关注Unique-liu的网站，爱分享网络资源，分享学到的知识，分享生活的乐趣，网址是www.unique-liu.com" />

<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://res.wx.qq.com/open/libs/weui/0.3.0/weui.min.css"/>
<script>
(function(){
    var bp = document.createElement('script');
    bp.src = '//push.zhanzhang.baidu.com/push.js';
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
var signature='<?php echo $signPackage["signature"];?>';
</script>
<script language="javascript">
host = window.location.host;
if(host!='www.unique-liu.com'){
var a=window.document.location.pathname;
   window.location="http://www.unique-liu.com"+a;
}
</script>    
<script>
//domain_host='http://www.unique-liu.com';
domain_host='http://www.unique-liu.com';
</script>
<style>
.footer{
color: #9C9C9C;
font-size: 14px;
text-align: center;
margin-top: 30px;
}
.weibo_icon{
margin-bottom: -3px;
margin-right: 2px;
}
.weibo_txt{
color: #04BE02;
}
</style>
</head>
<body>
<div id="container">Loading....</div>
<div class="footer">
<p><a href="http://www.cet.edu.cn/news_show15.html" target="_black"><strong><font color="#ffa200">New</font>&nbsp;关于英语四六级听力试题调整说明</strong></a></p>
<p>成绩以最终成绩单为准.</p>
<p>2016 ©&nbsp;<a class="weibo_txt" href="http://www.unique-liu.com/">刘锦</a></p>
</div>
<!--<script>__REACT_DEVTOOLS_GLOBAL_HOOK__ = parent.__REACT_DEVTOOLS_GLOBAL_HOOK__</script>-->
<script src="./jq.js"></script>
<script type="text/javascript" src="./cet.js"></script>
<script>
  var onBridgeReady = function() {
        var wxTitle = "CET成绩查询-无证查询",
        wxDesc = "程序猿刘锦编写的查询CET成绩查询和无证查询系统。", 
        _imgurl = 'http://www.unique-liu.com/cet/slj.jpg',
        linkUrl = document.location.href + "?v" + Math.random();
        WeixinJSBridge.on('menu:share:timeline',function(argv){
            WeixinJSBridge.invoke('shareTimeline', {
                "imgUrl": _imgurl,
                "img_width": "120",
                "img_height": "120",
                "link": linkUrl,
                "desc": wxTitle,
                "title": wxTitle
            }, function() {});
        })
        WeixinJSBridge.on('menu:share:appmessage', function(argv){
            WeixinJSBridge.invoke('sendAppMessage', {
                "imgUrl": _imgurl,
                "link": linkUrl,
                "desc": wxDesc,
                "title": wxTitle
            }, function() {})
        })
        WeixinJSBridge.on('menu:share:weibo', function(argv) {
            WeixinJSBridge.invoke('shareWeibo', {
                "content": wxTitle,
                "url": linkUrl,
            }, function(res) {});
        })
    }

    $(function() {
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    });
    $(function(){
    var CheckSystem = {
        UA : navigator.userAgent.toLowerCase(),
        isNewsApp : function() {
            try{
                if(CheckSystem.UA.match(/qqnews/i) == 'qqnews'){
                    return true;
                }else{
                    return fasle;
                }
            }catch(e){}
        },
        isWeixin : function() {
            try{
                if(CheckSystem.UA.match(/MicroMessenger/i) == 'micromessenger'){
                    return true;
                }else{
                    return fasle;
                }
            }catch(e){}
        },
        isiPhone : function() {
            try{
                if(CheckSystem.UA.match(/iphone/i) == 'iphone'){
                    return true;
                }else{
                    return fasle;
                }
            }catch(e){}
        }
    }

</script>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?61a47386b3ebe8d207c7214a7003fec1";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>