<?php
if (!defined('CONFIG_INCLUDED'))
	exit();
	
require ROOT.'/include/Smarty/Smarty.class.php';

define('TEMPLATE', 'templates');

/**
* templates
*/
class template extends Smarty
{
	
	function template()
	{
		$this->Smarty();
		
		$this->settpldir();
		
		$this->left_delimiter = "<{";
		$this->right_delimiter = "}>";
		
		$this->assign_by_ref('kercfg',$GLOBALS['kercfg']);
		$this->assign_by_ref('keruser',$GLOBALS['keruser']);
		$this->assign_by_ref('kerApp',$GLOBALS['kerApp']);
	}
	
	function settpldir($name = null)
	{
		if (!empty($name) && $name != 'system') {
			$this->template_dir = ROOT.'/app/'.$name.'/'.TEMPLATE;
			$this->compile_dir = ROOT.'/app/'.$name.'/'.TEMPLATE.'_c';
		} else {
			$this->template_dir = ROOT.'/'.TEMPLATE.'/';
			$this->compile_dir = ROOT.'/'.TEMPLATE.'_c/';
		}
	}
}

