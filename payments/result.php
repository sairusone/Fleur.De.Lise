<?php
/**
 * ������ ��������� ����������� �� ������
 * � ����� �������� ����� ��������� ������� ����� "OK_����� ������"
 *
 * www.WAYtoPAY.org � 2011
 *
**/

// ��������������� ����������
//id �������
$mrh_id         = 4886;
//��������� ����
$mrh_secret_key = "6720af-e1b580-bafc25-5d0353-ee95";

// HTTP ���������:
$out_summ = (float)$_REQUEST["wOutSum"];
$inv_id   = (int)$_REQUEST["wInvId"];
$is_sets  = (int)$_REQUEST["wIsTest"];
$crc      = (string)$_REQUEST["wSignature"];


// ��������� � ������� �������
$crc = strtoupper($crc);

//������� �������
$my_crc = strtoupper(md5("$mrh_id:$out_summ:$inv_id:$mrh_secret_key"));


//������� �������
if ($my_crc != $crc)
{
  //���� ������� �� �����
  echo "ERROR_bad sign\n";
  exit();
}

// ���������������� ��������
// � ������� ������ ����� �� ���� ������
// ���� ��� ������ �� ������� ����� �������

echo "OK_$inv_id";

?>