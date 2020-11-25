<?php

function update_config($file, $ini, $value, $type = 'string') {
	if (!file_exists($file)) return FALSE;
		
	$str = file_get_contents($file);
	$str2 = "";
	if ($type != 'string') {
		$str2 = preg_replace("/'" . $ini . "'(.*)=>(.*),/", "'" . $ini . "'=>" . $value . ",", $str);
	} else {
		$str2 = preg_replace("/'" . $ini . "'(.*)=>(.*)',/", "'" . $ini . "'=>'" . $value . "',", $str);
	}

	file_put_contents($file, $str2);
}


function get_root($domain = false) {
	$str = dirname( request() -> baseFile());
	$str = ($str == DS) ? '' : $str;
	if ($domain) {
		return request() -> domain() . $str;
	} else {
		return $str;
	}
}
//下载文件
function getfiles($path, $allowFiles, &$files = array()) {
	if (!is_dir($path))
		return null;
	if (substr($path, strlen($path) - 1) != '/')
		$path .= '/';
	$handle = opendir($path);
	while (false !== ($file = readdir($handle))) {
		if ($file != '.' && $file != '..') {
			$path2 = $path . $file;
			if (is_dir($path2)) {
				getfiles($path2, $allowFiles, $files);
			} else {
				if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
					$files[] = array('url' => substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])), 'mtime' => filemtime($path2));
				}
			}
		}
	}
	return $files;
}

function removeDir($dirName){  
    $result = false;  
    if(! is_dir($dirName)){  
        trigger_error("目录名称错误", E_USER_ERROR);  
    }  
    $handle = opendir($dirName);  
    while(($file = readdir($handle)) !== false){  
       if($file != '.' && $file != '..'){  
           $dir = $dirName . DIRECTORY_SEPARATOR . $file;  
           is_dir($dir) ? removeDir($dir) : unlink($dir);  
        }  
    }  
    closedir($handle);  
    $result = rmdir($dirName) ? true : false;  
    return $result;  
}
//下载文件 $url=下载地址，$save_dir=保存目录,$filename保存名称，$type 0 1都可
function getFile($url, $save_dir = '', $filename = '', $type = 0) {  
    if (trim($url) == '') {  
        return false;  
    }  
    if (trim($save_dir) == '') {  
        $save_dir = './';  
    }  
    if (0 !== strrpos($save_dir, '/')) {  
        $save_dir.= '/';  
    }  
    //创建保存目录  
    if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {  
        return false;  
    }  
    //获取远程文件所采用的方法  
    if ($type) {  
        $ch = curl_init();  
        $timeout = 60;  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
        $content = curl_exec($ch);  
        curl_close($ch);  
    } else {  
        ob_start();  
        readfile($url);  
        $content = ob_get_contents();  
        ob_end_clean();  
    }  
    //echo $content;  
    $size = strlen($content);  
    //文件大小  
    $fp2 = @fopen($save_dir . $filename, 'a');  
    fwrite($fp2, $content);  
    fclose($fp2);  
    unset($content, $url);  
    return array(  
        'file_name' => $filename,  
        'save_path' => $save_dir . $filename,  
        'file_size' => $size  
    );  
}

/** 
 * 解压文件 
 * 需开启配置 php_zip.dll 
 * filename 要解压的文件全路径 
 * path 解压文件后保存路径 
 * id   要解压的文件ID 
 * phpinfo(); 
 */  
function get_zip_originalsize($filename, $path, $id=0) {  
    //先判断待解压的文件是否存在  
    if (!file_exists($filename)) {  
        return FALSE;  
    }  
    $starttime = explode(' ', microtime()); //解压开始的时间  
    //将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到  
    $filename = iconv("utf-8", "gb2312", $filename);  
    $path = iconv("utf-8", "gb2312", $path);  
    //打开压缩包  
    $resource = zip_open($filename);  
    $i = 1;  
    //遍历读取压缩包里面的一个个文件  
    while ($dir_resource = zip_read($resource)) {  
        //如果能打开则继续  
        if (zip_entry_open($resource, $dir_resource)) {  
            //获取当前项目的名称,即压缩包里面当前对应的文件名  
            $file_name = $path.zip_entry_name($dir_resource);
			  
            //以最后一个“/”分割,再用字符串截取出路径部分  
            $file_path = substr($file_name, 0, strrpos($file_name, "/"));  
            //如果路径不存在，则创建一个目录，true表示可以创建多级目录  
            if (!is_dir($file_path)) {
            	 
                mkdir($file_path, 0777, true);  
            }  
            //如果不是目录，则写入文件  
            if (!is_dir($file_name)) {  
                //读取这个文件  
                $file_size = zip_entry_filesize($dir_resource);  
                //最大读取6M，如果文件过大，跳过解压，继续下一个  
                if ($file_size < (1024 * 1024 * 6)) {  
                    $file_content = zip_entry_read($dir_resource, $file_size);  
                    file_put_contents($file_name, $file_content);  
                } else {
                	//文件过大  
                    return FALSE;  
                }  
            }  
            //关闭当前  
            zip_entry_close($dir_resource);  
        }  
    }  
    //关闭压缩包  
    zip_close($resource);  
    $endtime = explode(' ', microtime()); //解压结束的时间  
    $thistime = $endtime[0] + $endtime[1] - ($starttime[0] + $starttime[1]);  
    $thistime = round($thistime, 3); //保留3为小数  
    return $thistime;
    
}  

