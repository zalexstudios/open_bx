<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if ($arResult["PLAYER_TYPE"] == "flv"): // Attach Flash Player?>

<div id="<?=$arResult["ID"]?>_div" style="width: <?= $arParams['WIDTH']?>px; height: <?= $arParams['HEIGHT']?>px;"><?= GetMessage('PLAYER_LOADING')?></div>
<script>
window.bxPlayerOnload<?=$arResult["ID"]?> = function(config)
{
	if (typeof config != 'object')
		config = <?= $arResult['jwConfig']?>;

	jwplayer("<?=$arResult["ID"]?>_div").setup(config);

	<?if (isset($arParams['WMODE']) && $arParams['WMODE'] != 'opaque'):?>
	jwplayer("<?=$arResult["ID"]?>_div").onReady(function()
	{
		try{
			var pWmode = BX.findChild(BX("<?=$arResult["ID"]?>_div"), {tagName: "PARAM", attribute: {name: "wmode"}});
			if (pWmode)
				pWmode.value = "<?= $arParams['WMODE']?>";

			var pEmbed = BX.findChild(BX("<?=$arResult["ID"]?>_div"), {tagName: "EMBED"});
			if (pEmbed && pEmbed.setAttribute)
				pEmbed.setAttribute("wmode", "<?= $arParams['WMODE']?>");
		}catch(e){}
	});
	<?endif;?>
};

if (window.jwplayer) // jw script already loaded
{
	setTimeout(bxPlayerOnload<?=$arResult["ID"]?>, 100);
}
else
{
	BX.addCustomEvent(window, "onPlayerJWScriptLoad", function(){setTimeout(bxPlayerOnload<?=$arResult["ID"]?>, 100);});
	if (!window.bPlayerJWScriptLoaded)
	{
		window.bPlayerJWScriptLoaded = true;
		// load jw scripts once
		BX.loadScript('/freetrix/components/freetrix/player/mediaplayer/jwplayer.js', function(){setTimeout(function()
		{
			BX.onCustomEvent(window, "onPlayerJWScriptLoad");
		}, 100);});
	}
}
</script><noscript><?=GetMessage('ENABLE_JAVASCRIPT')?></noscript>

<?elseif ($arResult["PLAYER_TYPE"] == "wmv"): // Attach WMV Player?>
<div id="<?=$arResult["ID"]?>"></div>
<script>
var arFiles = [
	'/freetrix/components/freetrix/player/wmvplayer/silverlight.js',
	'/freetrix/components/freetrix/player/wmvplayer/wmvplayer.js'
];
<?if ($arResult["USE_JS_PLAYLIST"]):?>
	var JSMESS = {
		ClickToPLay : "<?= GetMessage('JS_CLICKTOPLAY')?>",
		Link : "<?= GetMessage('JS_LINK')?>",
		PlayListError: "<?= GetMessage('JS_PLAYLISTERROR')?>"
	};
	BX.loadCSS('/freetrix/components/freetrix/player/templates/.default/wmvplaylist.css');
	arFiles.push('/freetrix/components/freetrix/player/templates/.default/wmvscript_playlist.js');
<?elseif ($arResult["INIT_PLAYER"] == "Y"):?>
	arFiles.push('/freetrix/components/freetrix/player/wmvplayer/wmvscript.js');
<?endif;?>

BX.loadScript(arFiles, function(){setTimeout(function(){
	if (window.showWMVPlayer)
		window.showWMVPlayer("<?=$arResult["ID"]?>", <?=$arResult['WMV_CONFIG']?>, <?=($arResult['PLAYLIST_CONFIG'] ? $arResult['PLAYLIST_CONFIG'] : '{}')?>);
}, 100);});

</script><noscript><?=GetMessage('ENABLE_JAVASCRIPT')?></noscript>
<?endif;?>