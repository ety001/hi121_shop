<?php
/*******************************************************************
 * 121�����̳ǡ���³��ѧ����
 *
 * @Filename credit_shop_usercp.inc.php $
 *
 * @Author http://www.domyself.me $
 *
 * @Date 2012-02-19 11:24:55 $
 *******************************************************************/


if(!defined('IN_JISHIGOU'))
{
    exit('invalid request');
}
$shop_op = $this->Get['shop_op'];
$sid = (int)trim($this->Get['sid']);

if($shop_op=='apply')
{
	$data = array();
	$data['product_id'] = (int)$this->Post['product_id'];
	$data['uid'] = (int)$this->Post['uid'];
	$data['num'] = (int)$this->Post['num'];//���������
	$data['auth'] = (int)$this->Post['auth'];
	$credit = (int)$this->Post['credit'];//���ּ�ֵ
	$product_num = (int)$this->Post['product_num'];//��ǰʣ����
	
	$sql = "select * from ".TABLE_PREFIX."pluginvar where `pluginid`='".$plugin_row['pluginid']."' and variable = 'credit_standard'";
	$query = $this->DatabaseHandler->Query($sql);
	$pluginvar = $query->GetRow();
	$standard = $pluginvar['value'];
	$column = 'extcredits'.$standard;
	$member_info = $this->_member();
	$data0 = array();
	$data0[$column] = $member_info[$column]-$credit*$data['num'];
	if($data0[$column]<0)
	{
		$this->Messager("������ػ��ֲ��㣡", 'index.php?mod=plugin&plugin=club121_shop:credit_shop&sid='.$sid);
	}
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'members');
	$result0 = $this->DatabaseHandler->Update($data0,"`uid`='".MEMBER_ID."'");
	//result0 �����û����ֽ���
	
	$data1 = array();
	$data1['total'] = $product_num - $data['num'];
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop');
	$result1 = $this->DatabaseHandler->Update($data1,"`id`='$data[product_id]'");
	if(!$result1)
	{
		$data0[$column] = $member_info[$column];
		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'members');
		$result0 = $this->DatabaseHandler->Update($data0,"`uid`='".MEMBER_ID."'");
		//ʧ�ܺ󣬻ָ��۵��Ļ���
		$this->Messager("�ύ����ʧ�ܣ�", 'index.php?mod=plugin&plugin=club121_shop:credit_shop&sid='.$sid);
	}
	//result1 ���¶һ���Ʒ����������
	
	
	$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop_log');
	$result = $this->DatabaseHandler->Insert($data);
	if(!$result)
	{
		$data0[$column] = $member_info[$column];
		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'members');
		$result0 = $this->DatabaseHandler->Update($data0,"`uid`='".MEMBER_ID."'");
		//ʧ�ܺ󣬻ָ��۵��Ļ���
		$data1['total'] = $product_num;
		$this->DatabaseHandler->SetTable(TABLE_PREFIX.'plugin_shop');
		$result1 = $this->DatabaseHandler->Update($data1,"`id`='$data[product_id]'");
		//ʧ�ܺ󣬻ָ��۵�������
		$this->Messager("�ύ����ʧ�ܣ�", 'index.php?mod=plugin&plugin=club121_shop:credit_shop&sid='.$sid);
	}
	//���������¼����
	
	if($result&&$result0&&$result1)
	{
		$this->Messager("�ύ����ɹ�����ȴ���ˣ�", 'index.php?mod=plugin&plugin=club121_shop:credit_shop_cp&require=topic');
	}
	else
	{
		$this->Messager("�ύ����ʧ�ܣ�", 'index.php?mod=plugin&plugin=club121_shop:credit_shop&sid='.$sid);
	}
}
else
{
	$sql = "select psl.id as id,psl.uid as uid,psl.auth as auth,psl.product_id as product_id,psl.num as num ,ps.title as title,ps.name as name from ".TABLE_PREFIX."plugin_shop_log psl left join ".TABLE_PREFIX."plugin_shop ps on psl.product_id = ps.id where `uid`='".MEMBER_ID."'";
	$query = $this->DatabaseHandler->Query($sql);
	$i = 0;
	while($row = $query->GetRow())
	{
		$products[$i] = $row;
		$i++;
	}
}

?>