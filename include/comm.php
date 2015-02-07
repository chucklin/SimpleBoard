<?php
//require_once '../../config.php';
$says = array();

$result = $kerdb->getvars('says');
while($res = $kerdb->fetch_array($result))
{
	$says[] = $res['string'];
}

if (is_array($says));
	$random = array_rand($says);

$kertpl->addjs(null,'
	function scroll(seed)
	{
		var m1 = "'.$says[$random].'"
		var msg=m1;
		var out = " ";
		var c = 1;
		
		if (seed > 100) {
			seed--;
			var cmd="scroll(" + seed + ")";
			timerTwo=window.setTimeout(cmd,100);
		}
		else if (seed <= 100 && seed > 0) {
			for (c=0 ; c < seed ; c++) {
				out+=" ";
			}
			out+=msg;
			seed--;
			var cmd="scroll(" + seed + ")";
			window.status=out;
			timerTwo=window.setTimeout(cmd,100);
		} else if (seed <= 0) {
			if (-seed < msg.length) {
				out+=msg.substring(-seed,msg.length);
				seed--;
				var cmd="scroll(" + seed + ")";
				window.status=out;
				timerTwo=window.setTimeout(cmd,100);
			}
			else {
				window.status=" ";
				timerTwo=window.setTimeout("scroll(100)",7);
			}
		}
	}

	timerONE=window.setTimeout("scroll(100)",50);
');

$kertpl->addjs(null,'
	var keybuffer = "";
	document.onkeypress = function(e) {
		var target;
		if (window.event)
			target = window.event.srcElement;
		else
			target = e.target;
		if (target.tagName.toUpperCase() == "INPUT") return;

		var keyToMatch = "admin";

		if (window.event) // IE
			keybuffer += String.fromCharCode(window.event.keyCode);
		else
			keybuffer += String.fromCharCode(e.charCode);

		if (keyToMatch.indexOf(keybuffer) != 0)
			keybuffer = "";

		if (keyToMatch == keybuffer)
		{       
			location.href = "'.SITE.'/app/admin/'.'";
			keybuffer = "";
		}       

		return true;
	}
');
?>
