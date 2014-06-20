<?

define("FX_ROOT", "/freetrix");

if(isset($_SERVER["FX_PERSONAL_ROOT"]) && $_SERVER["FX_PERSONAL_ROOT"] <> "")
	define("FX_PERSONAL_ROOT", $_SERVER["FX_PERSONAL_ROOT"]);
else
	define("FX_PERSONAL_ROOT", FX_ROOT);
?>