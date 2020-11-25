<?php
namespace app\common\controller;



/**
 * tpAdmin [a web admin based ThinkPHP5]
 *
 * @author yuan1994 <tianpian0805@gmail.com>
 * @link http://tpadmin.yuan1994.com/
 * @copyright 2016 yuan1994 all rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
//------------------------
// 读取类文件
//-------------------------
class GetAction
{
   
    /**
     * @cc index主页面
     */
    public function index($m){
        $modules = array($m);  //模块名称
        $i = 0;
        foreach ($modules as $module) {
            $all_controller = $this->getController($module);
            foreach ($all_controller as $controller) {
                $controller_name = $controller;
                $all_action = $this->getAction($module, $controller_name);
                foreach ($all_action as $action) {
                    $data[$i] = array(
                        'name' =>$module.'/'. $controller . '/' . $action,
                        'status' => 1,
                        'title'=>$this->get_cc_desc($module,$controller,$action)
                    );
                    $i++;
                }
            }
        }
        return $data;
    }
    /**
     * @cc 获取所有控制器名称
     *
     * @param $module
     *
     * @return array|null
     */
    protected function getController($module){
        if(empty($module)) return null;
        $module_path = APP_PATH . '/' . $module . '/Controller/';  //控制器路径
        if(!is_dir($module_path)) return null;
        $module_path .= '/*.php';
        $ary_files = glob($module_path);
        foreach ($ary_files as $file) {
            if (is_dir($file)) {
                continue;
            }else {            	
            	$files[] = basename($file, '.php');
            	               
            }
        }
        return $files;
    }
    /**
     * @cc 获取所有方法名称
     *
     * @param $module
     * @param $controller
     *
     * @return array|null
     */
    protected function getAction($module, $controller){
        if(empty($controller)) return null;
        $content = file_get_contents(APP_PATH . '/'.$module.'/Controller/'.$controller.'.php');
        preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
        $functions = $matches[1];
        //排除部分方法
        $inherents_functions = array('_before_index','_after_index','_initialize','__construct','getActionName','isAjax','display','show','fetch','buildHtml','assign','__set','get','__get','__isset','__call','error','success','ajaxReturn','redirect','__destruct','_empty');
        $customer_functions=array();
        foreach ($functions as $func){
            $func = trim($func);
            if(!in_array($func, $inherents_functions)){
              if (strlen($func)>0)   $customer_functions[] = $func;
            }
        }
        return $customer_functions;
    }
    /**
     * @cc 获取函数的注释
     *
     * @param $module Home
     * @param $controller Auth
     * @param $action index
     *
     * @return string 注释
     *
     */
    protected function get_cc_desc($module,$controller,$action){
        $desc='\app\\'.$module.'\Controller\\'.$controller;
        $func  = new \ReflectionMethod(new $desc(),$action);        
        $tmp   = $func->getDocComment();				
        $flag  = preg_match_all('/@cc(.*?)\n/',$tmp,$tmp);				
		if(!empty($tmp[1][0])){
		    $tmp   = trim($tmp[1][0]);
		}else{
		    $tmp   ='URL';
		}
        return $tmp;
    }


}