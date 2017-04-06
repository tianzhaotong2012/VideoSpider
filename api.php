<?php 
include('mysql.php');

function get_all_video(){
	$ret_arr = array();
	$sql = 'select * from videos';
    $ret = my_sql($sql);
	foreach ($ret as $item) {
       array_push($ret_arr, $item);
	}
    return $ret_arr;
}

//echo json_encode(get_all_video());

$all_video = get_all_video();

foreach($all_video as $item){
	//echo sprintf("<div><a href=%s><img src=%s/><p>%s</p></a></div>",'play.php?video_url=%27/VideoSpider/video/'.$item['video_url'].'%27',$item['image_url'],$item['title']);
	echo sprintf("<div><a href=%s><img src=%s/><p>%s</p></a></div>",'play1.php?video_url='.$item['video_url'].'&image_url='.$item['image_url'].'&title='.$item['title'],$item['image_url'],$item['title']);
}