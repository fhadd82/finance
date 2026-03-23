<?php
$dalTabletbl_expenses = array();
$dalTabletbl_expenses["id"] = array("type"=>3,"varname"=>"id", "name" => "id", "autoInc" => "1");
$dalTabletbl_expenses["user_id"] = array("type"=>3,"varname"=>"user_id", "name" => "user_id", "autoInc" => "0");
$dalTabletbl_expenses["category_id"] = array("type"=>3,"varname"=>"category_id", "name" => "category_id", "autoInc" => "0");
$dalTabletbl_expenses["expense_date"] = array("type"=>7,"varname"=>"expense_date", "name" => "expense_date", "autoInc" => "0");
$dalTabletbl_expenses["amount"] = array("type"=>14,"varname"=>"amount", "name" => "amount", "autoInc" => "0");
$dalTabletbl_expenses["description"] = array("type"=>200,"varname"=>"description", "name" => "description", "autoInc" => "0");
$dalTabletbl_expenses["receipt_path"] = array("type"=>200,"varname"=>"receipt_path", "name" => "receipt_path", "autoInc" => "0");
$dalTabletbl_expenses["original_currency"] = array("type"=>200,"varname"=>"original_currency", "name" => "original_currency", "autoInc" => "0");
$dalTabletbl_expenses["original_amount"] = array("type"=>14,"varname"=>"original_amount", "name" => "original_amount", "autoInc" => "0");
$dalTabletbl_expenses["exchange_rate"] = array("type"=>14,"varname"=>"exchange_rate", "name" => "exchange_rate", "autoInc" => "0");
$dalTabletbl_expenses["created_at"] = array("type"=>135,"varname"=>"created_at", "name" => "created_at", "autoInc" => "0");
$dalTabletbl_expenses["is_lhdn"] = array("type"=>3,"varname"=>"is_lhdn", "name" => "is_lhdn", "autoInc" => "0");
$dalTabletbl_expenses["id"]["key"]=true;

$dal_info["fhaddcom_finance_at_localhost__tbl_expenses"] = &$dalTabletbl_expenses;
?>