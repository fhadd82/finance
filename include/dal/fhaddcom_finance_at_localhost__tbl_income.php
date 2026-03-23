<?php
$dalTabletbl_income = array();
$dalTabletbl_income["id"] = array("type"=>3,"varname"=>"id", "name" => "id", "autoInc" => "1");
$dalTabletbl_income["user_id"] = array("type"=>3,"varname"=>"user_id", "name" => "user_id", "autoInc" => "0");
$dalTabletbl_income["income_date"] = array("type"=>7,"varname"=>"income_date", "name" => "income_date", "autoInc" => "0");
$dalTabletbl_income["amount"] = array("type"=>14,"varname"=>"amount", "name" => "amount", "autoInc" => "0");
$dalTabletbl_income["category_id"] = array("type"=>3,"varname"=>"category_id", "name" => "category_id", "autoInc" => "0");
$dalTabletbl_income["description"] = array("type"=>200,"varname"=>"description", "name" => "description", "autoInc" => "0");
$dalTabletbl_income["receipt_path"] = array("type"=>200,"varname"=>"receipt_path", "name" => "receipt_path", "autoInc" => "0");
$dalTabletbl_income["original_currency"] = array("type"=>200,"varname"=>"original_currency", "name" => "original_currency", "autoInc" => "0");
$dalTabletbl_income["original_amount"] = array("type"=>14,"varname"=>"original_amount", "name" => "original_amount", "autoInc" => "0");
$dalTabletbl_income["exchange_rate"] = array("type"=>14,"varname"=>"exchange_rate", "name" => "exchange_rate", "autoInc" => "0");
$dalTabletbl_income["created_at"] = array("type"=>135,"varname"=>"created_at", "name" => "created_at", "autoInc" => "0");
$dalTabletbl_income["id"]["key"]=true;

$dal_info["fhaddcom_finance_at_localhost__tbl_income"] = &$dalTabletbl_income;
?>