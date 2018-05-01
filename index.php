<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
	 <!--[if lt IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Magyar András">

    <title>Youtube channel list</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    

/* Source: http://bootsnipp.com/snippets/featured/video-list-thumbnails */

.video-list-thumbs{}
.video-list-thumbs > li{
    margin-bottom:12px
}
.video-list-thumbs > li:last-child{}
.video-list-thumbs > li > a{
	display:block;
	position:relative;
	background-color: #212121;
	color: #fff;
	padding: 8px;
	border-radius:3px
}
.video-list-thumbs > li > a:hover{
	background-color:#000;
	transition:all 500ms ease;
	box-shadow:0 2px 4px rgba(0,0,0,.3);
	text-decoration:none
}
.video-list-thumbs h2{
	bottom: 0;
	font-size: 14px;
	height: 33px;
	margin: 8px 0 0;
}
.video-list-thumbs .glyphicon-play-circle{
    font-size: 60px;
    opacity: 0.6;
    position: absolute;
    right: 39%;
    top: 31%;
    text-shadow: 0 1px 3px rgba(0,0,0,.5);
}
.video-list-thumbs > li > a:hover .glyphicon-play-circle{
	color:#fff;
	opacity:1;
	text-shadow:0 1px 3px rgba(0,0,0,.8);
	transition:all 500ms ease;
}
.video-list-thumbs .duration{
	background-color: rgba(0, 0, 0, 0.4);
	border-radius: 2px;
	color: #fff;
	font-size: 11px;
	font-weight: bold;
	left: 12px;
	line-height: 13px;
	padding: 2px 3px 1px;
	position: absolute;
	top: 12px;
}
.video-list-thumbs > li > a:hover .duration{
	background-color:#000;
	transition:all 500ms ease;
}
@media (min-width:320px) and (max-width: 480px) { 
	.video-list-thumbs .glyphicon-play-circle{
    font-size: 35px;
    right: 36%;
    top: 27%;
	}
	.video-list-thumbs h2{
		bottom: 0;
		font-size: 12px;
		height: 22px;
		margin: 8px 0 0;
	}
}
</style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><i class="fa fa-youtube"></i> Youtube channel list</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
				    <?php 
						include('mysql.php');
						function get_all_cats(){
							$ret_arr = array();
							$sql = 'select distinct video_cat from videos';
							$ret = my_sql($sql);
							foreach ($ret as $item) {
								array_push($ret_arr, $item[0]);
							}
							return $ret_arr;
						}
						$all_cats = get_all_cats();
						//var_dump($all_cats);
						foreach($all_cats as $cat){
							echo (sprintf('<li>
                        <a href="index.php?cat=%s">%s</a>
                    </li>',$cat,$cat));
						}
					?>
                    <!--<li>
                        <a href="index.php?cat=搞笑">搞笑</a>
                    </li>
                    <li>
                        <a href="index.php?cat=科技">科技</a>
                    </li>
                    <li>
                        <a href="index.php?cat=拍客">拍客</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
 <script src="js/jquery.js"></script>

 <style>
 /* Source: http://bootsnipp.com/snippets/featured/responsive-youtube-player */
 .vid {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 30px; height: 0; overflow: hidden;
}
 
.vid iframe,
.vid object,
.vid embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
 </style>
 
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
        <div class="row">
            <div class="col-lg-12 text-center">
              
			  
                <div id="youtube-gallery"></div>
				
				<ul class="list-unstyled video-list-thumbs row">
				
				<?php 
					//include('mysql.php');

					function get_all_video(){
						$ret_arr = array();
						$sql = 'select * from videos';
						$ret = my_sql($sql);
						foreach ($ret as $item) {
							array_push($ret_arr, $item);
						}
						return $ret_arr;
					}
					
					function get_all_video_by_cat($cat){
						$ret_arr = array();
						$sql = sprintf("SELECT * FROM `videos` where `video_cat` = '%s'",$cat);
						$ret = my_sql($sql);
						foreach ($ret as $item) {
							array_push($ret_arr, $item);
						}
						return $ret_arr;
					}

					if(isset($_GET['cat'])){
						$cat = mysql_escape_string($_GET['cat']);
						$all_video = get_all_video_by_cat($cat);
					}else{
						$all_video = get_all_video();
					}
					
					//echo json_encode(get_all_video());

					

					foreach($all_video as $item){
						//echo sprintf("<div><a href=%s><img src=%s/><p>%s</p></a></div>",'play.php?video_url=%27/VideoSpider/video/'.$item['video_url'].'%27',$item['image_url'],$item['title']);
						//echo sprintf("<div><a href=%s><img src=%s/><p>%s</p></a></div>",'play1.php?video_url='.$item['video_url'].'&image_url='.$item['image_url'].'&title='.$item['title'],$item['image_url'],$item['title']);
					    if($item['title'] == '' || $item['image_url'] == ''){
							continue;
						}
						$titleEncode = urlencode($item['title']);
						/*echo '<li  class="col-lg-3 col-sm-6 col-xs-6 youtube-video">
									<a href="'. 'http://m.shixunkuaibao.com/VideoSpider/play1.php?video_url='.urlencode($item['video_url']).'&image_url='.urlencode($item['image_url']).'&title='.$titleEncode .'" title="'. $item['title'] .'">
										<img src="'. $item['image_url'] .'" alt="'. $item['title'] .'" class="img-responsive" height="130px" />
										<h2>'. $item['title'] .'</h2>
										<span class="glyphicon glyphicon-play-circle"></span>
									</a>
							</li>
							';*/
						echo '<li  class="col-lg-3 col-sm-6 col-xs-6 youtube-video">
									<a href="'. 'http://m.shixunkuaibao.com/VideoSpider/play1.php?video_id='.$item['id'].'" title="'. $item['title'] .'">
										<img src="'. $item['image_url'] .'" alt="'. $item['title'] .'" class="img-responsive" height="130px" />
										<h2>'. $item['title'] .'</h2>
										<span class="glyphicon glyphicon-play-circle"></span>
									</a>
							</li>
							';
					}

				?>
				
				</ul>
				
				
            </div>
			
			
			
        </div>
        <!-- /.row -->

		<!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
				<hr>
                    <p>Copyright &copy; <?php echo Date('Y'); ?></p>
                </div>
            </div>
            <!-- /.row -->
        </footer>
		
    </div>
    <!-- /.container -->


   

</body>

</html>