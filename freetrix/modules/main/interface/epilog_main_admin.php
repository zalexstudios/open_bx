<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
IncludeModuleLangFile(__FILE__);

include($_SERVER["DOCUMENT_ROOT"]."/freetrix/modules/main/interface/lang_files.php");
?>
<?
//End of Content
?>
				</div><?//adm-workarea?>
			</td><?//adm-workarea-wrap?>
		</tr>
		<tr class="adm-footer-wrap">
			<td class="adm-left-side-wrap"></td>
			<td class="adm-workarea-wrap">
<?
//Footer


?>
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td>Freetrix 0.1 - свободный аналог CMS <a href="http://www.1c-bitrix.ru">1C-Bitrix</a></td>
					<td align="right"></td>
				</tr>
			</table>
<?
//End of Footer
?>
			</td>
		</tr>
	</table>
	<div id="fav_cont_item" class="adm-favorites-main" style="display:none;">
		<div class="adm-favorites-alignment">
			<div class="adm-favorites-center" id="fav_dest_item">
				<div id="fav_text_item" style="display: inline-block;">
					<div class="adm-favorites-text"><?=GetMessage('ADMIN_FAV_ADD')?></div>
					<div class="adm-favorites-description"><?=GetMessage('ADMIN_FAV_HINT')?></div>
				</div>
				<div id="fav_text_finish_item" style="display: none;">
					<div class="adm-favorites-text"><?=GetMessage('ADMIN_FAV_ADD_SUCCESS')?></div>
					<div class="adm-favorites-description"><a class="adm-favorites-description_link" href="javascript:void(0);" onclick="BX.adminMenu.showFavorites(this);"><?=GetMessage('ADMIN_FAV_GOTO')?></a></div>
				</div>
				<div id="fav_text_error_item" style="display: none;">
					<div class="adm-favorites-text"><?=GetMessage('ADMIN_FAV_ADD_ERROR')?></div>
				</div>
				<div class="adm-favorites-center-border-2"></div>
				<div class="adm-favorites-center-border-1"></div>
				<div class="adm-favorites-check-icon" id="fav_icon_finish_item"></div>
			</div>
		</div>
	</div>
	<div id="fav_cont_fav" class="adm-favorites-main remove-favorites-main" style="display:none;">
		<div class="adm-favorites-alignment">
			<div class="adm-favorites-center" id="fav_dest_fav">
				<div id="fav_text_fav" style="display: inline-block;">
					<div class="adm-favorites-text"><?=GetMessage('ADMIN_FAV_DEL')?></div>
					<div class="adm-favorites-description"><?=GetMessage('ADMIN_FAV_HINT')?></div>
				</div>
				<div id="fav_text_finish_fav" style="display: none;">
					<div class="adm-favorites-text"><?=GetMessage('ADMIN_FAV_DEL_SUCCESS')?></div>
				</div>
				<div id="fav_text_error_fav" style="display: none;">
					<div class="adm-favorites-text"><?=GetMessage('ADMIN_FAV_DEL_ERROR')?></div>
				</div>
				<div class="adm-favorites-center-border-2"></div>
				<div class="adm-favorites-center-border-1"></div>
				<div class="adm-favorites-check-icon" id="fav_icon_finish_fav"></div>
			</div>
		</div>
	</div>
<?
if (!defined('ADMIN_SECTION_LOAD_AUTH') || !ADMIN_SECTION_LOAD_AUTH):
?>
</body>
</html>
<?
endif;
?>
