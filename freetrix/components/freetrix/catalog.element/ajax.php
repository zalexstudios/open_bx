<?
use \Freetrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;

require($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/include/prolog_before.php");
if(isset($_POST['AJAX']) && $_POST['AJAX'] == 'Y')
{
	if (\Freetrix\Main\Loader::includeModule("catalog") && \Freetrix\Main\Loader::includeModule("sale"))
	{
		if(isset($_POST['PRODUCT_ID']))
		{
			CatalogViewedProductTable::refresh(
				(int)($_POST['PRODUCT_ID']),
				CSaleBasket::GetBasketUserID(),
				$_POST['SITE_ID']
			);
			echo CUtil::PhpToJSObject(array("STATUS" => "SUCCESS"));
		}
		else echo CUtil::PhpToJSObject(array("STATUS" => "ERROR", "TEXT" => "UNDEFINED PRODUCT"));
	}
	die();
}