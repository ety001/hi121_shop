<?php
/*******************************************************************
 * 121�����̳ǡ���³��ѧ����
 *
 * @Filename credit_shop_usercp.inc.php $
 *
 * @Author ETY001 http://www.domyself.me $
 *
 * @Date 2012-02-19 14:24:44 $
 *******************************************************************/

if(!defined('IN_JISHIGOU'))
{
    exit('invalid request');
}
$id = (int)$this->Get['id'];
$sid = (int)$this->Get['sid'];
$shop_op = $this->Get['shop_op'];

$sql = "select * from ".TABLE_PREFIX."pluginvar where `pluginid`='".$id."' and variable = 'credit_standard'";
$query = $this->DatabaseHandler->Query($sql);
$pluginvar = $query->GetRow();
$standard = $pluginvar['value'];
$column = 'extcredits'.$standard;

if($shop_op=='apply')
{
	$data['auth']=2;
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop_log');
	$result = $this->DatabaseHandler->Update($data,"`id`='$sid'");
	if($result)
	{
		$this->Messager("��˳ɹ�", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_usercp');
	}
	else
	{
		$this->Messager("���ʧ��", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_usercp');
	}
}
else if($shop_op=='refuse')
{
	$num = (int)$this->Get['num'];
	$credit = (int)$this->Get['credit'];
	$total = (int)$this->Get['total'];
	$credit_total = (int)$this->Get['credit_total'];
	$uid = (int)$this->Get['uid'];
	$product_id = (int)$this->Get['product_id'];
	
	$data['auth']=0;
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop_log');
	$result = $this->DatabaseHandler->Update($data,"`id`='$sid'");
	//��¼״̬�������
	
	$data1=array();
	$data1['total'] = $total + $num;
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop');
	$result1 = $this->DatabaseHandler->Update($data1,"`id`='$product_id'");
	//�ָ��ҽ�Ʒ������
	
	$data2=array();
	$data2[$column] = $credit_total + $num*$credit;
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'members');
	$result2 = $this->DatabaseHandler->Update($data2,"`uid`='$uid'");
	//�ָ��û�����
	
	if($result&&$result1&&$result2)
	{
		$this->Messager("�ܾ��ɹ�", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_usercp');
	}
	else
	{
		$this->Messager("�ܾ�ʧ��", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_usercp');
	}
}
else if($shop_op=='del')
{
	if($ids = jimplode($this->Post['delete']))
	{
		$sql = "DELETE FROM `" . TABLE_PREFIX . "plugin_shop_log` WHERE `id` IN ($ids)";
		$result2 = $this->DatabaseHandler->Query($sql);
		if($result2)
		{
			$this->Messager("ɾ���ɹ�", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_usercp');
		}
		else
		{
			$this->Messager("ɾ��ʧ��", 'admin.php?mod=plugin&code=manage&id='.$id.'&identifier=club121_shop&pmod=credit_shop_usercp');
		}
	}
}
else
{
	$sql = "select psl.id as id, psl.uid as uid, m.nickname as nickname, psl.auth as auth, psl.product_id as product_id, psl.num as num, ps.title as title, ps.name as name, ps.credit as credit, ps.time as time, ps.total as total, m.{$column} as credit_total from ".TABLE_PREFIX."plugin_shop_log psl left join ".TABLE_PREFIX."plugin_shop ps on psl.product_id = ps.id left join ".TABLE_PREFIX."members m on m.uid=psl.uid";
	$query = $this->DatabaseHandler->Query($sql);
	$i = 0;
	while($row = $query->GetRow())
	{
		$products[$i] = $row;
		$i++;
	}
}
?>