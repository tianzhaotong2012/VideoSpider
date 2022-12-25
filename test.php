<?php
function look(){	
	var_dump(iconv('gbk','utf-8',VIDEOCAT));

	var_dump(CRAWURL);
}

function main($argc,$argv){
	if($argc > 1){
		$input_cat = $argv['1'];
		$input_crawurl = $argv['2'];
		define("VIDEOCAT",$input_cat);
		define("CRAWURL",$input_crawurl);
    }else{
		define("VIDEOCAT","∏„–¶");
		define("CRAWURL","http://fun.youku.com/?spm=a2hww.20023042.topNav.5~1~3!21~A");
	}
	look();
}

main($argc,$argv);
