<?php
$dalTabletbl_users = array();
$dalTabletbl_users["ID"] = array("type"=>3,"varname"=>"ID", "name" => "ID", "autoInc" => "1");
$dalTabletbl_users["username"] = array("type"=>200,"varname"=>"username", "name" => "username", "autoInc" => "0");
$dalTabletbl_users["password"] = array("type"=>200,"varname"=>"password", "name" => "password", "autoInc" => "0");
$dalTabletbl_users["fullname"] = array("type"=>200,"varname"=>"fullname", "name" => "fullname", "autoInc" => "0");
$dalTabletbl_users["fullname1"] = array("type"=>201,"varname"=>"fullname1", "name" => "fullname1", "autoInc" => "0");
$dalTabletbl_users["groupid"] = array("type"=>200,"varname"=>"groupid", "name" => "groupid", "autoInc" => "0");
$dalTabletbl_users["active"] = array("type"=>3,"varname"=>"active", "name" => "active", "autoInc" => "0");
$dalTabletbl_users["ext_security_id"] = array("type"=>200,"varname"=>"ext_security_id", "name" => "ext_security_id", "autoInc" => "0");
$dalTabletbl_users["userpic"] = array("type"=>128,"varname"=>"userpic", "name" => "userpic", "autoInc" => "0");
$dalTabletbl_users["email"] = array("type"=>200,"varname"=>"email", "name" => "email", "autoInc" => "0");
$dalTabletbl_users["ID"]["key"]=true;

$dal_info["fhaddcom_finance_at_localhost__tbl_users"] = &$dalTabletbl_users;
?>