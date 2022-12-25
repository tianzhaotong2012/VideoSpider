<?php
include('simple_html_dom.php');
include('mysql.php');

//爬取页面中的所有优酷播放页连接start
function get_youku_play_list($page_url){
	$all_url = array();
	$html = file_get_html($page_url);
	foreach($html->find('a') as $element){
		if(substr($element->href,0,26) == 'http://v.youku.com/v_show/'){
			array_push($all_url,$element->href);
		}
	}
	return array_unique($all_url);
	   
}

//获取一个优酷视频的流地址start
function get_one_youku_address($iurl){
	
	$url = "http://www.shokdown.com/parse.php";
	$post_data = array("url" => $iurl);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// post数据
	curl_setopt($ch, CURLOPT_POST, 1);
	// post的变�?
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	//print_r($output);

	$html = new simple_html_dom();

	// 从字符串中加�?
	$html->load($output);


	$tables = $html->find('table',1);
	foreach($tables->find('a') as $element) 
       return $element->href . "\n";
}

//获取一个优酷视频的所有flv片段
function get_all_youku_flv($iurl){
	$url = "http://www.shokdown.com/parse.php";
	$post_data = array("url" => $iurl);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// post数据
	curl_setopt($ch, CURLOPT_POST, 1);
	// post的变�?
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$output = curl_exec($ch);
	curl_close($ch);
	//print_r($output);

	$html = new simple_html_dom();

	// 从字符串中加�?
	$html->load($output);


	$tables = $html->find('table',1);
	$allFlv = array();
	foreach($tables->find('a') as $element) {
		if(strpos($element->href, 'mp4')){
			return $allFlv;
		}
		array_push($allFlv,$element->href);
	}
	return $allFlv;
}

function download($url,$name){
	$dir = dirname(__FILE__) . '/video/';
	if (!file_exists($dir)){ mkdir ($dir);}

	$cmd = 'wget -U "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.6) Gecko/20070802 SeaMonkey/1.1.4"  -O ' . $dir . $name . ' "' . $url . '"';
	print_r($cmd);
	$retval = array();
	exec($cmd, $retval, $status);
}

function downloads($urls,$name){
	$dir = dirname(__FILE__) . '/video/';
	if (!file_exists($dir)){ mkdir ($dir);}
	
	for($i=0;$i<count($urls);$i++){
			$cmd = 'wget -U "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.6) Gecko/20070802 SeaMonkey/1.1.4"  -O ' . $dir . $name . '_' . $i . '.flv' . ' "' . $urls[$i] . '"';
			print_r($cmd);
			$retval = array();
			exec($cmd, $retval, $status);
	}
	
}

//获取一个优酷视频的标题图片 start
function get_youku_title_img($url){
	// 这段正则是来获取优酷的id，出处在 /wp-content/languages/zh_CN.php，同�?6网、土豆都可以找到   
	preg_match("#https?://v.youku.com/v_show/id_(?<video_id>[a-z0-9_=-]+)#i", $url, $matches);   
	$cnt = count($matches);   
	if ($cnt>0){   
		$link = "http://play.youku.com/play/get.json?vid={$matches['video_id']}==&ct=10";   
	}else{   
		return false;   
	}   
  
	// 这一段是用来解析json数据，如果想跨域用js来取，这个表示压力好�?  
	$ch=@curl_init($link);   
	@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
	$cexecute=@curl_exec($ch);   
	@curl_close($ch);   
  
  
	if ($cexecute) {   
		$result = json_decode($cexecute,true);   
		$json = $result['data']['video'];   
       
		$data['img'] = $json['logo']; // 视频缩略�?  
		$data['title'] = $json['title']; //标题�?  
		$data['url'] = $url;    
  
		return $data;   
	} else {   
		return false;   
	}  
}

function insert_video($title,$image_url,$video_url,$video_cat){
	$created_at = time();
	//$sql="INSERT INTO videos (title, image_url, video_url ,create_ts,video_cat) VALUES ($title,$image_url,$video_url,$created_at,$video_cat)";
    $sql = sprintf("INSERT INTO videos (title, image_url, video_url ,create_ts,video_cat) VALUES ('%s','%s','%s','%s','%s')",$title,$image_url,$video_url,$created_at,$video_cat);
    my_insert($sql);
}

function transcodeAndMerge($streams,$videoname){
	
	//如果只有一段flv视频 只转�?
	if(count($streams) == 1){
		$dir = dirname(__FILE__) . '/video/';
		$videoOrg = $dir . $videoname . '_0' . '.flv';
		$videoTra = $dir . $videoname . '.mp4';
		//$cmd = 'ffmpeg -i ' . $videoOrg . ' -s 320x240 -r 30000/1001 -b 200k -bt 240k -vcodec libx264 -acodec aac -ac 2 -ar 48000 -ab 192k ' . $videoTra;
		$cmd = 'ffmpeg -i ' . $videoOrg . ' -qscale 200 -r 30000/1001 -b 200k -bt 240k -vcodec libx264 -acodec aac -ac 2 -ar 48000 -ab 192k ' . $videoTra;
		$retval = array();
		exec($cmd, $retval, $status);
		
		//删除原来的flv
		$cmd = 'rm -f ' . $videoOrg;
		$retval = array();
		exec($cmd, $retval, $status);
		
		return true;
	}
	
	$count = count($streams);
	for($i=0;$i<$count;$i++){
		$dir = dirname(__FILE__) . '/video/';
		$videoOrg = $dir . $videoname . '_' . $i . '.flv';
		$videoTra = $dir . $videoname . '_' . $i . '.ts';
		$cmd = 'ffmpeg -i ' . $videoOrg . ' -c copy -bsf:v h264_mp4toannexb -f mpegts ' . $videoTra;
		$retval = array();
		exec($cmd, $retval, $status);
	}
	
	$allVideoTra = '';
	for($i=0;$i<$count;$i++){
		$videoTra = $dir . $videoname . '_' . $i . '.ts';
		$allVideoTra = $allVideoTra . '|' . $videoTra;
	}
	$allVideoTra = substr($allVideoTra,1);
	
	//$cmd = 'ffmpeg -i "concat:'. $allVideoTra . '" -vcodec copy -acodec aac ' . $dir . $videoname . '.mp4';
	$cmd = 'ffmpeg -i "concat:'. $allVideoTra . '" -qscale 200 -r 30000/1001 -b 200k -bt 240k -vcodec libx264 -acodec aac -ac 2 -ar 48000 -ab 192k ' . $dir . $videoname . '.mp4';
	printf($cmd);
	$retval = array();
	exec($cmd, $retval, $status);
	
	//删除原来的flv和ts
	for($i=0;$i<$count;$i++){
		$dir = dirname(__FILE__) . '/video/';
		$videoOrg = $dir . $videoname . '_' . $i . '.flv';
		$videoTra = $dir . $videoname . '_' . $i . '.ts';
		$cmd = 'rm -f ' . $videoOrg;
		$retval = array();
		exec($cmd, $retval, $status);
		$cmd = 'rm -f ' . $videoTra;
		$retval = array();
		exec($cmd, $retval, $status);
	}
	//删除原来的flv和ts
}

function checkTitleExists($title){
	$sql = sprintf("select * from videos where title = '%s'",$title);
	$ret = my_sql($sql);
	//var_dump($sql);
	//var_dump($ret);
	if(count($ret) >0){
		return true;
	}else{
		return false;
	}
}

function main($argc,$argv){
	if($argc > 2){
		$input_cat = $argv['1'];
		$input_crawurl = $argv['2'];
		define("VIDEOCAT",$input_cat);
		define("CRAWURL",$input_crawurl);
    }else{
		define("VIDEOCAT","��Ц");
		define("CRAWURL","http://fun.youku.com/?spm=a2hww.20023042.topNav.5~1~3!21~A");
	}
	var_dump(iconv('gbk','utf-8',VIDEOCAT));

	var_dump(CRAWURL);
	
	$all_url = get_youku_play_list(CRAWURL);
	foreach($all_url as $iurl){
		var_dump($iurl);
		$ret = get_youku_title_img($iurl);
		if(checkTitleExists($ret['title'])){
			continue;
		}
		$streams = get_all_youku_flv($iurl);
		var_dump($streams);
		
		$video_name = time();
		//download($stream,$video_name);
		downloads($streams,$video_name);
		transcodeAndMerge($streams,$video_name);
		$cat = iconv('gbk','utf-8',VIDEOCAT);
		$dir = dirname(__FILE__) . '/video/';
		if(file_exists($dir.$video_name.'.mp4')){
			insert_video($ret['title'],$ret['img'],$video_name,$cat);
		}
		sleep(2);
	}
}

main($argc,$argv);
