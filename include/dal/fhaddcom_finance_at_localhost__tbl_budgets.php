<?php
$dalTabletbl_budgets = array();
$dalTabletbl_budgets["id"] = array("type"=>3,"varname"=>"id", "name" => "id", "autoInc" => "1");
$dalTabletbl_budgets["user_id"] = array("type"=>3,"varname"=>"user_id", "name" => "user_id", "autoInc" => "0");
$dalTabletbl_budgets["category_id"] = array("type"=>3,"varname"=>"category_id", "name" => "category_id", "autoInc" => "0");
$dalTabletbl_budgets["budget_month"] = array("type"=>200,"varname"=>"budget_month", "name" => "budget_month", "autoInc" => "0");
$dalTabletbl_budgets["amount"] = array("type"=>14,"varname"=>"amount", "name" => "amount", "autoInc" => "0");
$dalTabletbl_budgets["id"]["key"]=true;

$dal_info["fhaddcom_finance_at_localhost__tbl_budgets"] = &$dalTabletbl_budgets;
?>