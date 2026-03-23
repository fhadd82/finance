<?php
$dalTabletbl_categories = array();
$dalTabletbl_categories["id"] = array("type"=>3,"varname"=>"id", "name" => "id", "autoInc" => "1");
$dalTabletbl_categories["name"] = array("type"=>200,"varname"=>"name", "name" => "name", "autoInc" => "0");
$dalTabletbl_categories["user_id"] = array("type"=>3,"varname"=>"user_id", "name" => "user_id", "autoInc" => "0");
$dalTabletbl_categories["type_id"] = array("type"=>3,"varname"=>"type_id", "name" => "type_id", "autoInc" => "0");
$dalTabletbl_categories["type"] = array("type"=>200,"varname"=>"type", "name" => "type", "autoInc" => "0");
$dalTabletbl_categories["color_code"] = array("type"=>200,"varname"=>"color_code", "name" => "color_code", "autoInc" => "0");
$dalTabletbl_categories["id"]["key"]=true;

$dal_info["fhaddcom_finance_at_localhost__tbl_categories"] = &$dalTabletbl_categories;
?>