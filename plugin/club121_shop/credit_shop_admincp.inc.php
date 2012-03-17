<?php
/*******************************************************************
 * 121积分商城——鲁大学生网
 *
 * @Filename credit_shop_admincp.inc.php $
 *
 * @Author ETY001 http://www.domyself.me $
 *
 * @Date 2012-02-19 02:08 $
 * !!!注意：插件没有做严格的防注入！！！
 *******************************************************************/


if(!defined('IN_JISHIGOU'))
{
    exit('invalid request');
}
$id = $this->Get['id'];
if($this->Get['shop_op'] == 'add')
{
	$data = array();
	$data['title'] = trim($this->Post['title']);
	$data['name'] = trim($this->Post['name']);
	$data['credit'] = trim($this->Post['credit']);
	$data['total'] = trim($this->Post['total']);
	$data['time'] = trim($this->Post['time']);
	if($data['title']||$data['name']||$data['credit'])
	{
		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop');
		$result = $this->DatabaseHandler->Insert($data);
	}
	if($ids = jimplode($this->Post['delete']))
	{
		$sql = "DELETE FROM `" . TABLE_PREFIX . "plugin_shop` WHERE `id` IN ($ids)";
		$result2 = $this->DatabaseHandler->Query($sql);
	}
	if($result||$result2)
	{
		$this->Messager("操作成功", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_admincp');
	}else{
		$this->Messager("操作失败", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_admincp');
	}
}
elseif($this->Get['shop_op'] == 'view' || $this->Get['shop_op'] == 'mod')
{
	if($this->Get['shop_op'] == 'view')
	{
		$view = true;
	}else{
		$mod = true;
	}
	$sid = (int)$this->Get['sid'];
	$sqlc = "SELECT * FROM `" . TABLE_PREFIX . "plugin_shop` WHERE id = '$sid'";
	$queryc = $this->DatabaseHandler->Query($sqlc);
	$product_info = $queryc->GetRow();
	if($this->Get['shop_op'] == 'view')
	{
		$product_info['description'] = str_replace("\n","<br>",$product_info['description']);
	}
}
elseif($this->Get['shop_op'] == 'modsave')
{	
	$data = array();
	$id = $this->Get['id'];
	$sid = trim($this->Post['sid']);
	$data['title'] = trim($this->Post['title']);
	$data['name'] = trim($this->Post['name']);
	$data['credit'] = trim($this->Post['credit']);
	$data['total'] = trim($this->Post['total']);
	$data['pic'] = trim($this->Post['pic']);
	$data['auth'] = trim($this->Post['auth']);
	$data['time'] = trim($this->Post['time']);
	$data['description'] = trim($this->Post['description']);
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop');
	$result = $this->DatabaseHandler->Update($data,"`id`='$sid'");
	$this->Messager("兑换品修改成功", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_admincp');
}
else
{
	$sql = "SELECT * FROM `" . TABLE_PREFIX . "plugin_shop` ORDER BY id DESC";
	$query = $this->DatabaseHandler->Query($sql);
	$i = 0;
	while($row = $query->GetRow())
	{
		$product_info[$i] = $row;
		$i++;
	}
}
?>