<?php
/** 
 * Photos
 *
 * @package Custom
 *  
 * @author FKUN
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (!Utils::isPjax()) {
    $this->need('includes/head.php');
    $this->need('includes/header.php');
}
?>
<head>
    <meta charset="UTF-8">
    <script src="jscss/jquery-3.5.1.min.js"></script>
    <script src="jscss/fancybox/jquery.fancybox.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jscss/fancybox/jquery.fancybox.min.css">
    <script src="jscss/waterfall-light.js"></script>
<style type="text/css">
body{
    /* margin-top: 0px; */
	/* padding: 0; */
	/* background-color: #333; */
}
.box{
	float: left;
	overflow: hidden;
    border: 3px solid #283b3c;
	border-radius: 14px;	
    box-shadow: 1px 1px 10px #000;	
}
.box img{
    width: 100%;
    border-radius: 8px;
    object-fit: cover;
    justify-content: center;
    align-items: center;
}
.box h2{
	margin: 0px 0 0;
	padding: 0;
	font-size: 20px;
	color: white;
}
.box p{
	margin: 0;
    box-sizing:border-box;
    width: 100%;
    border: 0px solid #cccccc;
	padding: 4px 0px 5px 10px;
	font-size: 16px;
	color: floralwhite;

}
#picrow {
}
/* 未完成 懒加载header */
#headimg {
  background: linear-gradient(0deg, rgba(26,26,26,1), rgba(26,26,26,.5), rgba(26,26,26,0), rgba(26,26,26,0)), url(https://api.fkun.tech/img/other/blogheaderthumb.jpg);
  background-size: cover;
  height: 100vh;
  background-position: center;
  background-repeat: no-repeat;
  z-index: 1;
  filter: blur(15px);
  transition: all 0.7s;
}
.imgtxt{
    margin-top:30vh;
    left:30%;
    right:30%; 
    position:absolute;
    z-index:2;
}
.imgtxt h1{
    font-size:6rem;
    color: floralwhite;
    text-align: center;
    margin-top: 0vh;
}
.imgtxt h2{
    font-size:2rem;
    color: floralwhite;
    text-align: center;
    margin-top: 0vh;  
}
.imgtxt h3{
    font-size:1.2rem;
    color: floralwhite;
    text-align: center;
    margin-top: 30vh;  
}

</style>
</head>

<body>
<div class="imgtxt">
<h1 style="font-size: 7rem; font-family: 'ZCOOL XiaoWei', serif;">相片</h1>
<h2>用光和影定格大千世界</h2>
<h3>向下滑动开始浏览</a>
</div>
<div class ="bannerimg" id = "headimg">


</div>
    <div id="picrow">
        <?php
        $raw = file_get_contents('your api, number of Photos');//edit here
        $alltitle = file('title.txt');//edit here
        $allpicname = file('picname.txt');//edit here
        $imgthumba = "svg/FKUN_LOGO.svg";//edit here
        $imgnum = (int)$raw;
        for ($num = $imgnum; $num > 0; $num--) {
            $imgscr = "img/origin/web-" . $num . ".jpg";//edit here
            $imgthumb = "img/thumb/thumb-" . $num . ".jpg";
            echo '<div class="box" data-fancybox="fkunfotos" href="' . $imgscr . '">
            <div class="active">';
            $titlenum = $num-1;
            $imgtitle = $alltitle[$titlenum]; 
            $imgpicname = $allpicname[$titlenum];             
            $randnum = rand(0, 4);
            if ($randnum == 1) {
                $url = '<img src="gif/loading2.gif" data-imgurl="' . $imgthumb . '" title="点击查看大图" height="200px" />';
            } elseif ($randnum == 2) {
                $url = '<img src="gif/loading2.gif" data-imgurl="' . $imgthumb . '" title="点击查看大图" height="300px" />';
            } elseif ($randnum == 3) {
                $url = '<img src="gif/loading2.gif" data-imgurl="' . $imgthumb . '" title="点击查看大图" height="400px" />';
            } elseif ($randnum == 4) {
                $url = '<img src="gif/loading2.gif" data-imgurl="' . $imgthumb . '" title="点击查看大图" height="350px" />';
            } else {
                $url = '<img src="gif/loading2.gif" data-imgurl="' . $imgthumb . '" title="点击查看大图" height="350px" />';
            }
            $picname = '<h2>' . $imgpicname . '</h2>';
            $txt = '<p>' . $imgtitle . '</p>';
            echo $url;
            echo $picname;
            echo $txt;
            echo '</div>';
        echo '</div>';
        }
        ?>
    </div>
</body>
<script>
    var setting = {
        gap: 7,
        gridWidth: [0, 0, 600, 600, 1200, 1600, 2000]//每一位代表一列，数字代表激活需要的屏幕宽度
    };
    $(function() {
        $('#picrow').waterfall(setting);
    })
</script>
<script type="text/javascript">
  var aImages = document.getElementById("picrow").getElementsByTagName('img'); 
  loadImg(aImages);
  window.onscroll = function() { //滚动条滚动触发
  loadImg(aImages);
  };
  //getBoundingClientRect 是图片懒加载的核心
  function loadImg(arr) {
  for(var i = 0, len = arr.length; i < len; i++) {
   if(arr[i].getBoundingClientRect().top < document.documentElement.clientHeight && !arr[i].isLoad) {
   arr[i].isLoad = true; //图片显示标志位
   arr[i].style.cssText = "opacity: 0;";
   (function(i) {
    setTimeout(function() {
    if(arr[i].dataset) { //兼容不支持data的浏览器
     aftLoadImg(arr[i], arr[i].dataset.imgurl);
    } else {
     aftLoadImg(arr[i], arr[i].getAttribute("data-imgurl"));
    }
    arr[i].style.cssText = "transition: opacity 0.5s ease-in; opacity: 1;" //相当于fadein
    }, 500)
   })(i);
   }
  }
  }
 
  function aftLoadImg(obj, url) {
  var oImg = new Image();
  oImg.onload = function() {
   obj.src = oImg.src; //下载完成后将该图片赋给目标obj目标对象
  }
  oImg.src = url; //oImg对象先下载该图像
  }
 </script>
<script type="text/javascript">
    $().fancybox({
        keyboard: true,
        arrows: true,
        toolbar: "auto",
        buttons: [
            "zoom",
            "slideShow",
            "fullScreen",
            "download",
            "close"
        ],
    });
</script>
<script type="text/javascript">
        setTimeout(function(){
            var imgUrl = 'img/origin/web-248.jpg'; //edit here Header Thumb
            var imgObject = new Image();
            imgObject.src = imgUrl;
            imgObject.onload = function(){
               $('.bannerimg').css({
                    backgroundImage: 'linear-gradient(0deg, rgba(26,26,26,1), rgba(26,26,26,.5), rgba(26,26,26,0), rgba(26,26,26,0)),  url('+imgUrl+')',
                    filter: 'blur(0)'
                });
            }
        }, 1000)
         
    </script>
<?php
$this->need('includes/footer.php');
?>