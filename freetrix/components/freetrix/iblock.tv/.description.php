<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("FREETRIXTVBIG_COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("FREETRIXTVBIG_COMPONENT_DESCRIPTION"),
	"ICON" => "/images/freetrix_tv.gif",
	"COMPLEX" => "N",
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "media",
			"NAME" => GetMessage("FREETRIXTVBIG_COMPONENTS"),
		),
	),
);
?>