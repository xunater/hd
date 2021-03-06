<?php
class Controller extends SmartyView{
	private $vars = array();
	/**
	 * [__construct 扩展构造函数]
	 */
	public function __construct(){
		if(C('SMARTY_ON')){
	    parent::__construct();
		}
		if(method_exists($this, '__auto')){
			$this->__auto();
		}
		if(method_exists($this, '__init')){
			$this->__init();
		}
	}
	/**
	 * [success 操作成功跳转]
	 * @param  string  $msg  [提示信息]
	 * @param  string  $url  [提示URL]
	 * @param  integer $time [倒计时时间]
	 * @return null
	 */
	public function success($msg='操作成功',$url='',$time=1){
		$url = $url ? "window.location.href='".$url."'" : "window.history.go(-1)";
		include TPL_PATH . '/success.html';
	}
	/**
	 * [error 操作失败跳转]
	 * @param  string  $msg  [提示信息]
	 * @param  string  $url  [提示URL]
	 * @param  integer $time [倒计时时间]
	 * @return null
	 */
	public function error($msg='操作失败',$url='',$time=3){
		$url = $url ? "window.location.href='".$url."'" : "window.history.go(-1)";
		include TPL_PATH . '/error.html';
	}
	/**
	 * [get_tpl 获取模板文件真实路径]
	 * @param  [string] $tpl [模板文件名]
	 * @return null
	 */
  public function get_tpl($tpl){
      if(is_null($tpl)){
          $path = APP_TPL_PATH . '/' . CONTROLLER . '/' . ACTION . C('TPL_SUFFIX');
          return $path;
      }
      if(strpos($tpl, '.')){
          $path = APP_TPL_PATH . '/' . CONTROLLER . '/' . $tpl;
      }else{
          $path = APP_TPL_PATH . '/' . CONTROLLER . '/' . $tpl . C('TPL_SUFFIX');
      }
      return $path;
  }
	/**
	 * [display 显示模板]
	 * @param  [string] $tpl [模板文件]
	 * @return null
	 */
	protected function display($tpl=NULL){
    $path = $this->get_tpl($tpl);
		is_file($path) OR halt($path . '模板不存在');
		if(C('SMARTY_ON')){
			return parent::display($path);
		}else{
			extract($this->vars);
			include $path;return;			
		}
	}
	/**
	 * [assign 向模板分配变量]
	 * 如果以数组做参数，必须使用关联数组
	 * @param  [type] $var   [description]
	 * @param  [type] $value [description]
	 * @return null
	 */
	protected function assign($var,$value=null){
		if(C('SMARTY_ON')){
			return parent::assign($var,$value);
		}
		if(is_array($var)){
			foreach ($var as $k => $v) {
				if(!is_string($k)){
					halt('如果使用数组向模板分配变量,必须使用关联数组');
				}else{
					$this->vars[$k] = $v;
				}
			}
		}
		if(is_string($var)){
			$this->vars[$var] = $value;
		}
	}
}
?>