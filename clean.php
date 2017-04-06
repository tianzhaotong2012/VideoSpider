<?php
define("LEFTNUM",10);

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

//$all_cats = get_all_cats();
//var_dump($all_cats);

function get_all_video_by_cat($cat){
	$ret_arr = array();
	$sql = sprintf("SELECT * FROM `videos` where `video_cat` = '%s'",$cat);
	$ret = my_sql($sql);
	foreach ($ret as $item) {
		array_push($ret_arr, $item);
	}
	return $ret_arr;
}

//获取每个分类需要删除的items
function get_need_delete_items($cat){
	$all_items = get_all_video_by_cat($cat);
	$retArr = array();
	for($i =0 ;$i<count($all_items);$i++){
		if($i<LEFTNUM){
			array_push($retArr,$all_items[$i]);
		}
	}
	return $retArr;
} 

function delete_sql($items){
	//$ids = array_column($items,'id');
	$ids = array();
	foreach($items as $item){
		array_push($ids,$item['id']);
	}
	$sql = sprintf("delete from 'videos' where id in (%s)",implode(",",$ids));
	var_dump($sql);
}

function delete_files($items){
	//$video_urls = array_column($items,'video_url');
	$video_urls = array();
	foreach($items as $item){
		array_push($video_urls,$item['video_url']);
		var_dump($item['title']);
	}
	foreach($video_urls as $video_url){
		$cmd = 'rm -rf ' . __DIR__ . '/video/' . $video_url . '.mp4';
		var_dump($cmd);
	}
	
}

function main(){
	$all_cats = get_all_cats();
	foreach($all_cats as $cat){
		$deleteItems = get_need_delete_items($cat);
		delete_sql($deleteItems);
		delete_files($deleteItems);
	}
}

main();