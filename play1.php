<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
</head>
<body style="margin:0;padding:0;">
<video id="videoElement" style="width:100%;padding:0;margin:0;" controls="controls" controls webkit-playsinline poster=<?php echo $_GET["image_url"]; ?>>
<source src=<?php echo $_GET["video_url"]; ?> type="video/mp4">
</video>

<img style="display:none;" src=<?php echo $_GET["image_url"]; ?>>

<h3 style="padding: 0 .4rem;margin-top: 0.5rem;"><?php echo $_GET["title"]; ?></h3>

<p style='color: #999;font-size: 14px;margin-top: -1rem;padding: 0.4rem;'>21231次观看</p>

<div class="col-xs-12 kg-padding-lr">
        <div class="col-xs-12 kg-follow kg-border-tb">
            <span data-from="kg" data-event="pgcPic" data-url="kuaigeng://kg.web/v?vid=6244456571624989696" style="    font-size: 14px;
    color: #20659a;
    margin-left: 1rem;
    display: inline-flex;">
                <img src="http://img.kuaigeng.com/img/cb08a9919c01faf1150eae175d8572cc300d6b1b.jpg" style='width: 1.8rem;
    height: 1.8rem;
    margin-right: 0.5rem;
    border-radius: 100%;
    margin-top: -0.3rem;'>
				发明迷            </span>

            <button style="visibility: visible;
    font-size: 12px;
    width: 4.3rem;
    height: 1.666667rem;
    padding: 0;
    text-indent: 5px;
    letter-spacing: 5px;
    color: #ff635a;
    border-width: 1px;
    border-style: solid;
    border-color: #ff635a;
    border-radius: .133334rem;
    background-color: #fff;
    float: right;
    margin-right: 1rem;" class="kg-border-width" data-from="kg" data-event="followButton" data-url="kuaigeng://kg.web/v?vid=6244456571624989696">
                关注
            </button>

        </div>
</div>

</body>
</html>
