<?php
if (!defined('CONFIG_INCLUDED'))
	exit();
	
require_once ROOT.'/kernel/template.php';

class tpl extends template
{
	var $js = array();
	var $waitpage;
	var $alldisplayed;
	
	function tpl()
	{
		$this->template();

		$this->waitpage = false;
		$this->setalldisplay();
		
		ob_start();
		
		$this->addcss('/'.TEMPLATE.'/style.css');
		$this->addjs('/include/jquery.js');
	}

	function addjs($src, $content = null)
	{
		$srcTmp = _gnpath(ROOT.$src);

		$js = '<script type="text/javascript"';
		if ($srcTmp) {
			$js .= ' src="'.SITE.str_replace(DIRECTORY_SEPARATOR, '/', $src).'">';
		}elseif ($content){
			$js .= '>';
			$js .= $content;
		}else
			return ;

		$js .= "</script>\n";

		if (!in_array($js, $this->js)){
			$this->js[] = $js;
		}

	}
	
	function addcss($src, $content = null, $media = "screen")
	{
		$srcTmp = _gnpath(ROOT.$src);

		$css = '';

		if ($srcTmp) {
			$css .= '<link rel="stylesheet" type="text/css" href="'.SITE.str_replace(DIRECTORY_SEPARATOR, '/', $src).'" media="'.$media.'" />'."\n";
		}elseif ($content) {
			$css .= '	<style>'."\n";
			$css .= '		'.$content."\n";
			$css .= '	</style>'."\n";
		}else {
			return ;
		}

		if (!in_array($css, $this->js)) {
			$this->js[] = $css;
		}
	}
	
	function alldisplay()
	{
		_recodepage();
		global $keruser,$kerApp,$currsite,$kercfg;

		$kersite = array();
		for ($i = 0;$i<count($currsite);$i++)
		{
			$kersite[] = "<a href='".$currsite[$i]['url']."' title='".$currsite[$i]['title']."'>".$currsite[$i]['title']."</a>";
		}

		$kercfg->CURRSITE = "現在位置：".implode('&gt;',$kersite);

		if (file_exists(ROOT."/app/templates/".$kerApp->name."/style.css"))
			$this->addcss("/app/templates/".$kerApp->name."/style.css");

		foreach ($this->js as $value) {
			$js .= $value;
		}

		$this->settpldir();		

		if( !$kerApp->isActive()||($this->waitpage && !$kerApp->isadmin()))
		{
			ob_end_clean();
			ob_start();

			$this->display('wait.html');
		}

		$content = ob_get_contents();
		
		ob_end_clean();
		
		$this->assign('js', $js);
		$this->assign('content', $content);
		
		$this->display('index.html');
		
	}
	
	function setalldisplay($status = false)
	{
		$this->alldisplayed = $status;
	}
	
	function __destruct()
	{
		global $kertpl;
		$kertpl = $this;
		
		if (!$this->alldisplayed)
			$this->alldisplay();
		
		unset($kertpl);
	}
}
