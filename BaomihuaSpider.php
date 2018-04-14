<?php
include('simple_html_dom.php');

define(BASE_DIR, __DIR__ . DIRECTORY_SEPARATOR . "video/baomihua/");

function get_baomihua_play_list($page_url){
        $all_url = array();
        $html = file_get_html($page_url);
        foreach($html->find('a') as $element){
		if(substr($element->href,0,28) == 'http://video.baomihua.com/v/'){
                        array_push($all_url,$element->href);
                }
        }
        return array_unique($all_url);

}

$page_url = "http://www.baomihua.com/funny";

$all_video_url = get_baomihua_play_list($page_url);

//print_r($all_video_url);

foreach($all_video_url as $video_url){
	echo $video_url . "\n";
	$id = substr($video_url,28);
	echo $id . "\n";

	$dir = iconv("UTF-8", "GBK", BASE_DIR .  $id);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
            echo "make dir success $id  \n";
        } else {
            continue;
	    echo "make dir failed $id \n";
        }
	
	$cmd = "you-get -i $video_url";
	$retval = array();
	exec($cmd,$retval,$status);
	print_r($retval);
	$titleStr = substr($retval[3],12);
	$titleArr = explode("-",$titleStr);
	$title = $titleArr[0];
	print_r($title);
	
	file_put_contents(BASE_DIR . $id . DIRECTORY_SEPARATOR . $id,$title);

	$video_name = "baomihua_" . $id;
	$cmd = "you-get $video_url -o $dir -O $video_name";
	exec($cmd,$res,$status);

	for($i = 0;$i < 3;$i++){
		$time = "00:00:" . 10 * ($i+1);
		$img_name = "baomihua_" . $id . "_" . $i . ".jpg";
		$cmd = "ffmpeg -i $dir/$video_name.mp4 -ss $time -f image2 $dir/$img_name";
		echo $cmd . "\n";
		exec($cmd,$res,$status);
	}
		
	//exit(0);
}
