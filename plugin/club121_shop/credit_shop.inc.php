<?php
/*******************************************************************
 * 121积分商城——鲁大学生网
 *
 * @Filename credit_shop.inc.php $
 *
 * @Author ETY001 http://www.domyself.me $
 *
 * @Date 2012-02-19 06:40:44 $
 *******************************************************************/


if(!defined('IN_JISHIGOU'))
{
    exit('invalid request');
}
$id = $this->Get['sid'];
$nav = ConfigHandler::get('navigation');
$club_shop = $nav['pluginmenu']['club121_shop'];
if($id)
{
	$sql = "select * from `".TABLE_PREFIX."plugin_shop` where `id`='".$id."'";
	$query = $this->DatabaseHandler->Query($sql);
	$product_info = $query->GetRow();
	$product_info['description'] = str_replace("\n","<br>",$product_info['description']);
}
else
{
	$sql = "select * from ".TABLE_PREFIX."plugin_shop where total>0 and auth=1";
	$query = $this->DatabaseHandler->Query($sql);
	$i = 0;
	while($row = $query->GetRow())
	{
		$products[$i] = $row;
		$products[$i]['pic'] = empty($row['pic']) ? 'templates/default/images/no.gif' : $row['pic'];
		$i++;
	}
}
?>