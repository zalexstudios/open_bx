<?
require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_admin_before.php");

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_REQUEST['undo']) && check_freetrix_sessid())
{
	if (!CUndo::Escape($_REQUEST['undo']))
		echo 'ERROR';
}
?>