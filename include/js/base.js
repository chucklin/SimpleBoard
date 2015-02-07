$(function(){
	
	$('button, a.button').hover(
		function() { $(this).addClass('ui-state-hover'); }, 
		function() { $(this).removeClass('ui-state-hover'); }
	);
	
	$('.table_row').click(function()
	{
		location.href = "topic.html";
	});
	
	$('.logo').click(function()
	{
		location.href = "index.html";		
	});
	
	$('#dlgLogin').dialog({autoOpen: false, resizable: false, width: 250});
	$('#btnLogin').click(function()
	{
		$('#dlgLogin').dialog('open');
	});

	$('#dlgRegister').dialog({autoOpen: false, resizable: false, width: 250});
	$('#btnRegister').click(function()
	{
		$('#dlgRegister').dialog('open');
	});

	$('#btnSearch').click(function()
	{
		$('#search').toggle('blind');
	});
});