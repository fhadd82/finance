<?php
$tdatatbl_categories = array();
$tdatatbl_categories[".searchableFields"] = array();
$tdatatbl_categories[".ShortName"] = "tbl_categories";
$tdatatbl_categories[".OwnerID"] = "";
$tdatatbl_categories[".OriginalTable"] = "tbl_categories";


$tdatatbl_categories[".pagesByType"] = my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" );
$tdatatbl_categories[".originalPagesByType"] = $tdatatbl_categories[".pagesByType"];
$tdatatbl_categories[".pages"] = types2pages( my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" ) );
$tdatatbl_categories[".originalPages"] = $tdatatbl_categories[".pages"];
$tdatatbl_categories[".defaultPages"] = my_json_decode( "{\"add\":\"add\",\"edit\":\"edit\",\"export\":\"export\",\"import\":\"import\",\"list\":\"list\",\"print\":\"print\",\"search\":\"search\",\"view\":\"view\"}" );
$tdatatbl_categories[".originalDefaultPages"] = $tdatatbl_categories[".defaultPages"];

//	field labels
$fieldLabelstbl_categories = array();
$fieldToolTipstbl_categories = array();
$pageTitlestbl_categories = array();
$placeHolderstbl_categories = array();

if(mlang_getcurrentlang()=="English")
{
	$fieldLabelstbl_categories["English"] = array();
	$fieldToolTipstbl_categories["English"] = array();
	$placeHolderstbl_categories["English"] = array();
	$pageTitlestbl_categories["English"] = array();
	$fieldLabelstbl_categories["English"]["id"] = "Id";
	$fieldToolTipstbl_categories["English"]["id"] = "";
	$placeHolderstbl_categories["English"]["id"] = "";
	$fieldLabelstbl_categories["English"]["name"] = "Name";
	$fieldToolTipstbl_categories["English"]["name"] = "";
	$placeHolderstbl_categories["English"]["name"] = "";
	$fieldLabelstbl_categories["English"]["color_code"] = "Color Code";
	$fieldToolTipstbl_categories["English"]["color_code"] = "";
	$placeHolderstbl_categories["English"]["color_code"] = "";
	$fieldLabelstbl_categories["English"]["type"] = "Type";
	$fieldToolTipstbl_categories["English"]["type"] = "";
	$placeHolderstbl_categories["English"]["type"] = "";
	$fieldLabelstbl_categories["English"]["type_id"] = "Type Id";
	$fieldToolTipstbl_categories["English"]["type_id"] = "";
	$placeHolderstbl_categories["English"]["type_id"] = "";
	$fieldLabelstbl_categories["English"]["user_id"] = "User Id";
	$fieldToolTipstbl_categories["English"]["user_id"] = "";
	$placeHolderstbl_categories["English"]["user_id"] = "";
	if (count($fieldToolTipstbl_categories["English"]))
		$tdatatbl_categories[".isUseToolTips"] = true;
}


	$tdatatbl_categories[".NCSearch"] = true;



$tdatatbl_categories[".shortTableName"] = "tbl_categories";
$tdatatbl_categories[".nSecOptions"] = 0;

$tdatatbl_categories[".mainTableOwnerID"] = "";
$tdatatbl_categories[".entityType"] = 0;
$tdatatbl_categories[".connId"] = "fhaddcom_finance_at_localhost";


$tdatatbl_categories[".strOriginalTableName"] = "tbl_categories";

		 



$tdatatbl_categories[".showAddInPopup"] = false;

$tdatatbl_categories[".showEditInPopup"] = false;

$tdatatbl_categories[".showViewInPopup"] = false;

$tdatatbl_categories[".listAjax"] = false;
//	temporary
//$tdatatbl_categories[".listAjax"] = false;

	$tdatatbl_categories[".audit"] = true;

	$tdatatbl_categories[".locking"] = true;


$pages = $tdatatbl_categories[".defaultPages"];

if( $pages[PAGE_EDIT] ) {
	$tdatatbl_categories[".edit"] = true;
	$tdatatbl_categories[".afterEditAction"] = 1;
	$tdatatbl_categories[".closePopupAfterEdit"] = 1;
	$tdatatbl_categories[".afterEditActionDetTable"] = "";
}

if( $pages[PAGE_ADD] ) {
$tdatatbl_categories[".add"] = true;
$tdatatbl_categories[".afterAddAction"] = 1;
$tdatatbl_categories[".closePopupAfterAdd"] = 1;
$tdatatbl_categories[".afterAddActionDetTable"] = "";
}

if( $pages[PAGE_LIST] ) {
	$tdatatbl_categories[".list"] = true;
}



$tdatatbl_categories[".strSortControlSettingsJSON"] = "";




if( $pages[PAGE_VIEW] ) {
$tdatatbl_categories[".view"] = true;
}

if( $pages[PAGE_IMPORT] ) {
$tdatatbl_categories[".import"] = true;
}

if( $pages[PAGE_EXPORT] ) {
$tdatatbl_categories[".exportTo"] = true;
}

if( $pages[PAGE_PRINT] ) {
$tdatatbl_categories[".printFriendly"] = true;
}



$tdatatbl_categories[".showSimpleSearchOptions"] = true; // temp fix #13449

// Allow Show/Hide Fields in GRID
$tdatatbl_categories[".allowShowHideFields"] = true; // temp fix #13449
//

// Allow Fields Reordering in GRID
$tdatatbl_categories[".allowFieldsReordering"] = true; // temp fix #13449
//

$tdatatbl_categories[".isUseAjaxSuggest"] = true;





$tdatatbl_categories[".ajaxCodeSnippetAdded"] = false;

$tdatatbl_categories[".buttonsAdded"] = false;

$tdatatbl_categories[".addPageEvents"] = false;

// use timepicker for search panel
$tdatatbl_categories[".isUseTimeForSearch"] = false;


$tdatatbl_categories[".badgeColor"] = "DAA520";


$tdatatbl_categories[".allSearchFields"] = array();
$tdatatbl_categories[".filterFields"] = array();
$tdatatbl_categories[".requiredSearchFields"] = array();

$tdatatbl_categories[".googleLikeFields"] = array();
$tdatatbl_categories[".googleLikeFields"][] = "id";
$tdatatbl_categories[".googleLikeFields"][] = "name";
$tdatatbl_categories[".googleLikeFields"][] = "user_id";
$tdatatbl_categories[".googleLikeFields"][] = "type_id";
$tdatatbl_categories[".googleLikeFields"][] = "type";
$tdatatbl_categories[".googleLikeFields"][] = "color_code";



$tdatatbl_categories[".tableType"] = "list";

$tdatatbl_categories[".printerPageOrientation"] = 0;
$tdatatbl_categories[".nPrinterPageScale"] = 100;

$tdatatbl_categories[".nPrinterSplitRecords"] = 40;

$tdatatbl_categories[".geocodingEnabled"] = false;










$tdatatbl_categories[".pageSize"] = 20;

$tdatatbl_categories[".warnLeavingPages"] = true;



$tstrOrderBy = "";
$tdatatbl_categories[".strOrderBy"] = $tstrOrderBy;

$tdatatbl_categories[".orderindexes"] = array();


$tdatatbl_categories[".sqlHead"] = "SELECT id,  	name,  	user_id,  	type_id,  	`type`,  	color_code";
$tdatatbl_categories[".sqlFrom"] = "FROM tbl_categories";
$tdatatbl_categories[".sqlWhereExpr"] = "";
$tdatatbl_categories[".sqlTail"] = "";










//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdatatbl_categories[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdatatbl_categories[".arrGroupsPerPage"] = $arrGPP;

$tdatatbl_categories[".highlightSearchResults"] = true;

$tableKeystbl_categories = array();
$tableKeystbl_categories[] = "id";
$tdatatbl_categories[".Keys"] = $tableKeystbl_categories;


$tdatatbl_categories[".hideMobileList"] = array();




//	id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "id";
	$fdata["GoodName"] = "id";
	$fdata["ownerTable"] = "tbl_categories";
	$fdata["Label"] = GetFieldLabel("tbl_categories","id");
	$fdata["FieldType"] = 3;


		$fdata["AutoInc"] = true;

	
										

		$fdata["strField"] = "id";

		$fdata["sourceSingle"] = "id";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "id";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Text field");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



		$edata["IsRequired"] = true;

	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
	
	
			$edata["HTML5InuptType"] = "text";

		$edata["EditParams"] = "";
		
		$edata["controlWidth"] = 200;

//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
				$edata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");
						$edata["validateAs"]["basicValidate"][] = "IsRequired";
		
	
//	End validation

	
			
	
	
	
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats


	$fdata["isSeparate"] = false;




// the field's search options settings
		$fdata["defaultSearchOption"] = "Contains";

			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Starts with", "More than", "Less than", "Between", "Empty", NOT_EMPTY);
// the end of search options settings


//Filters settings
	$fdata["filterTotals"] = 0;
		$fdata["filterMultiSelect"] = 0;
			$fdata["filterFormat"] = "Values list";
		$fdata["showCollapsed"] = false;

		$fdata["sortValueType"] = 0;
		$fdata["numberOfVisibleItems"] = 10;

		$fdata["filterBy"] = 0;

	

	
	
//end of Filters settings


	$tdatatbl_categories["id"] = $fdata;
		$tdatatbl_categories[".searchableFields"][] = "id";
//	name
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "name";
	$fdata["GoodName"] = "name";
	$fdata["ownerTable"] = "tbl_categories";
	$fdata["Label"] = GetFieldLabel("tbl_categories","name");
	$fdata["FieldType"] = 200;


	
	
										

		$fdata["strField"] = "name";

		$fdata["sourceSingle"] = "name";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "name";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Text field");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



	
	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
	
	
			$edata["HTML5InuptType"] = "text";

		$edata["EditParams"] = "";
			$edata["EditParams"].= " maxlength=50";

		$edata["controlWidth"] = 200;

//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
	
	
//	End validation

	
			
	
	
	
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats


	$fdata["isSeparate"] = false;




// the field's search options settings
		$fdata["defaultSearchOption"] = "Contains";

			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Starts with", "More than", "Less than", "Between", "Empty", NOT_EMPTY);
// the end of search options settings


//Filters settings
	$fdata["filterTotals"] = 0;
		$fdata["filterMultiSelect"] = 0;
			$fdata["filterFormat"] = "Values list";
		$fdata["showCollapsed"] = false;

		$fdata["sortValueType"] = 0;
		$fdata["numberOfVisibleItems"] = 10;

		$fdata["filterBy"] = 0;

	

	
	
//end of Filters settings


	$tdatatbl_categories["name"] = $fdata;
		$tdatatbl_categories[".searchableFields"][] = "name";
//	user_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "user_id";
	$fdata["GoodName"] = "user_id";
	$fdata["ownerTable"] = "tbl_categories";
	$fdata["Label"] = GetFieldLabel("tbl_categories","user_id");
	$fdata["FieldType"] = 3;


	
	
										

		$fdata["strField"] = "user_id";

		$fdata["sourceSingle"] = "user_id";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "user_id";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Text field");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



	
	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
	
	
			$edata["HTML5InuptType"] = "text";

		$edata["EditParams"] = "";
		
		$edata["controlWidth"] = 200;

//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
				$edata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");
							
	
//	End validation

	
			
	
	
	
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats


	$fdata["isSeparate"] = false;




// the field's search options settings
		$fdata["defaultSearchOption"] = "Contains";

			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Starts with", "More than", "Less than", "Between", "Empty", NOT_EMPTY);
// the end of search options settings


//Filters settings
	$fdata["filterTotals"] = 0;
		$fdata["filterMultiSelect"] = 0;
			$fdata["filterFormat"] = "Values list";
		$fdata["showCollapsed"] = false;

		$fdata["sortValueType"] = 0;
		$fdata["numberOfVisibleItems"] = 10;

		$fdata["filterBy"] = 0;

	

	
	
//end of Filters settings


	$tdatatbl_categories["user_id"] = $fdata;
		$tdatatbl_categories[".searchableFields"][] = "user_id";
//	type_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 4;
	$fdata["strName"] = "type_id";
	$fdata["GoodName"] = "type_id";
	$fdata["ownerTable"] = "tbl_categories";
	$fdata["Label"] = GetFieldLabel("tbl_categories","type_id");
	$fdata["FieldType"] = 3;


	
	
										

		$fdata["strField"] = "type_id";

		$fdata["sourceSingle"] = "type_id";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "type_id";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Text field");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



	
	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
	
	
			$edata["HTML5InuptType"] = "text";

		$edata["EditParams"] = "";
		
		$edata["controlWidth"] = 200;

//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
				$edata["validateAs"]["basicValidate"][] = getJsValidatorName("Number");
							
	
//	End validation

	
			
	
	
	
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats


	$fdata["isSeparate"] = false;




// the field's search options settings
		$fdata["defaultSearchOption"] = "Contains";

			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Starts with", "More than", "Less than", "Between", "Empty", NOT_EMPTY);
// the end of search options settings


//Filters settings
	$fdata["filterTotals"] = 0;
		$fdata["filterMultiSelect"] = 0;
			$fdata["filterFormat"] = "Values list";
		$fdata["showCollapsed"] = false;

		$fdata["sortValueType"] = 0;
		$fdata["numberOfVisibleItems"] = 10;

		$fdata["filterBy"] = 0;

	

	
	
//end of Filters settings


	$tdatatbl_categories["type_id"] = $fdata;
		$tdatatbl_categories[".searchableFields"][] = "type_id";
//	type
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 5;
	$fdata["strName"] = "type";
	$fdata["GoodName"] = "type";
	$fdata["ownerTable"] = "tbl_categories";
	$fdata["Label"] = GetFieldLabel("tbl_categories","type");
	$fdata["FieldType"] = 200;


	
	
										

		$fdata["strField"] = "type";

		$fdata["sourceSingle"] = "type";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "`type`";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Text field");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



	
	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
	
	
			$edata["HTML5InuptType"] = "text";

		$edata["EditParams"] = "";
			$edata["EditParams"].= " maxlength=20";

		$edata["controlWidth"] = 200;

//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
	
	
//	End validation

	
			
	
	
	
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats


	$fdata["isSeparate"] = false;




// the field's search options settings
		$fdata["defaultSearchOption"] = "Contains";

			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Starts with", "More than", "Less than", "Between", "Empty", NOT_EMPTY);
// the end of search options settings


//Filters settings
	$fdata["filterTotals"] = 0;
		$fdata["filterMultiSelect"] = 0;
			$fdata["filterFormat"] = "Values list";
		$fdata["showCollapsed"] = false;

		$fdata["sortValueType"] = 0;
		$fdata["numberOfVisibleItems"] = 10;

		$fdata["filterBy"] = 0;

	

	
	
//end of Filters settings


	$tdatatbl_categories["type"] = $fdata;
		$tdatatbl_categories[".searchableFields"][] = "type";
//	color_code
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 6;
	$fdata["strName"] = "color_code";
	$fdata["GoodName"] = "color_code";
	$fdata["ownerTable"] = "tbl_categories";
	$fdata["Label"] = GetFieldLabel("tbl_categories","color_code");
	$fdata["FieldType"] = 200;


	
	
										

		$fdata["strField"] = "color_code";

		$fdata["sourceSingle"] = "color_code";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "color_code";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Text field");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



	
	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
	
	
			$edata["HTML5InuptType"] = "text";

		$edata["EditParams"] = "";
			$edata["EditParams"].= " maxlength=50";

		$edata["controlWidth"] = 200;

//	Begin validation
	$edata["validateAs"] = array();
	$edata["validateAs"]["basicValidate"] = array();
	$edata["validateAs"]["customMessages"] = array();
	
	
//	End validation

	
			
	
	
	
	$fdata["EditFormats"]["edit"] = $edata;
//	End Edit Formats


	$fdata["isSeparate"] = false;




// the field's search options settings
		$fdata["defaultSearchOption"] = "Contains";

			// the default search options list
				$fdata["searchOptionsList"] = array("Contains", "Equals", "Starts with", "More than", "Less than", "Between", "Empty", NOT_EMPTY);
// the end of search options settings


//Filters settings
	$fdata["filterTotals"] = 0;
		$fdata["filterMultiSelect"] = 0;
			$fdata["filterFormat"] = "Values list";
		$fdata["showCollapsed"] = false;

		$fdata["sortValueType"] = 0;
		$fdata["numberOfVisibleItems"] = 10;

		$fdata["filterBy"] = 0;

	

	
	
//end of Filters settings


	$tdatatbl_categories["color_code"] = $fdata;
		$tdatatbl_categories[".searchableFields"][] = "color_code";


$tables_data["tbl_categories"]=&$tdatatbl_categories;
$field_labels["tbl_categories"] = &$fieldLabelstbl_categories;
$fieldToolTips["tbl_categories"] = &$fieldToolTipstbl_categories;
$placeHolders["tbl_categories"] = &$placeHolderstbl_categories;
$page_titles["tbl_categories"] = &$pageTitlestbl_categories;


changeTextControlsToDate( "tbl_categories" );

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)

//if !@TABLE.bReportCrossTab

$detailsTablesData["tbl_categories"] = array();
//endif

// tables which are master tables for current table (detail)
$masterTablesData["tbl_categories"] = array();



// -----------------end  prepare master-details data arrays ------------------------------//



require_once(getabspath("classes/sql.php"));











function createSqlQuery_tbl_categories()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "id,  	name,  	user_id,  	type_id,  	`type`,  	color_code";
$proto0["m_strFrom"] = "FROM tbl_categories";
$proto0["m_strWhere"] = "";
$proto0["m_strOrderBy"] = "";
	
					
;
						$proto0["cipherer"] = null;
$proto2=array();
$proto2["m_sql"] = "";
$proto2["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto2["m_column"]=$obj;
$proto2["m_contained"] = array();
$proto2["m_strCase"] = "";
$proto2["m_havingmode"] = false;
$proto2["m_inBrackets"] = false;
$proto2["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto2);

$proto0["m_where"] = $obj;
$proto4=array();
$proto4["m_sql"] = "";
$proto4["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto4["m_column"]=$obj;
$proto4["m_contained"] = array();
$proto4["m_strCase"] = "";
$proto4["m_havingmode"] = false;
$proto4["m_inBrackets"] = false;
$proto4["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto4);

$proto0["m_having"] = $obj;
$proto0["m_fieldlist"] = array();
						$proto6=array();
			$obj = new SQLField(array(
	"m_strName" => "id",
	"m_strTable" => "tbl_categories",
	"m_srcTableName" => "tbl_categories"
));

$proto6["m_sql"] = "id";
$proto6["m_srcTableName"] = "tbl_categories";
$proto6["m_expr"]=$obj;
$proto6["m_alias"] = "";
$obj = new SQLFieldListItem($proto6);

$proto0["m_fieldlist"][]=$obj;
						$proto8=array();
			$obj = new SQLField(array(
	"m_strName" => "name",
	"m_strTable" => "tbl_categories",
	"m_srcTableName" => "tbl_categories"
));

$proto8["m_sql"] = "name";
$proto8["m_srcTableName"] = "tbl_categories";
$proto8["m_expr"]=$obj;
$proto8["m_alias"] = "";
$obj = new SQLFieldListItem($proto8);

$proto0["m_fieldlist"][]=$obj;
						$proto10=array();
			$obj = new SQLField(array(
	"m_strName" => "user_id",
	"m_strTable" => "tbl_categories",
	"m_srcTableName" => "tbl_categories"
));

$proto10["m_sql"] = "user_id";
$proto10["m_srcTableName"] = "tbl_categories";
$proto10["m_expr"]=$obj;
$proto10["m_alias"] = "";
$obj = new SQLFieldListItem($proto10);

$proto0["m_fieldlist"][]=$obj;
						$proto12=array();
			$obj = new SQLField(array(
	"m_strName" => "type_id",
	"m_strTable" => "tbl_categories",
	"m_srcTableName" => "tbl_categories"
));

$proto12["m_sql"] = "type_id";
$proto12["m_srcTableName"] = "tbl_categories";
$proto12["m_expr"]=$obj;
$proto12["m_alias"] = "";
$obj = new SQLFieldListItem($proto12);

$proto0["m_fieldlist"][]=$obj;
						$proto14=array();
			$obj = new SQLField(array(
	"m_strName" => "type",
	"m_strTable" => "tbl_categories",
	"m_srcTableName" => "tbl_categories"
));

$proto14["m_sql"] = "`type`";
$proto14["m_srcTableName"] = "tbl_categories";
$proto14["m_expr"]=$obj;
$proto14["m_alias"] = "";
$obj = new SQLFieldListItem($proto14);

$proto0["m_fieldlist"][]=$obj;
						$proto16=array();
			$obj = new SQLField(array(
	"m_strName" => "color_code",
	"m_strTable" => "tbl_categories",
	"m_srcTableName" => "tbl_categories"
));

$proto16["m_sql"] = "color_code";
$proto16["m_srcTableName"] = "tbl_categories";
$proto16["m_expr"]=$obj;
$proto16["m_alias"] = "";
$obj = new SQLFieldListItem($proto16);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto18=array();
$proto18["m_link"] = "SQLL_MAIN";
			$proto19=array();
$proto19["m_strName"] = "tbl_categories";
$proto19["m_srcTableName"] = "tbl_categories";
$proto19["m_columns"] = array();
$proto19["m_columns"][] = "id";
$proto19["m_columns"][] = "name";
$proto19["m_columns"][] = "user_id";
$proto19["m_columns"][] = "type_id";
$proto19["m_columns"][] = "type";
$proto19["m_columns"][] = "color_code";
$obj = new SQLTable($proto19);

$proto18["m_table"] = $obj;
$proto18["m_sql"] = "tbl_categories";
$proto18["m_alias"] = "";
$proto18["m_srcTableName"] = "tbl_categories";
$proto20=array();
$proto20["m_sql"] = "";
$proto20["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto20["m_column"]=$obj;
$proto20["m_contained"] = array();
$proto20["m_strCase"] = "";
$proto20["m_havingmode"] = false;
$proto20["m_inBrackets"] = false;
$proto20["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto20);

$proto18["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto18);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="tbl_categories";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_tbl_categories = createSqlQuery_tbl_categories();


	
					
;

						

$tdatatbl_categories[".sqlquery"] = $queryData_tbl_categories;



$tdatatbl_categories[".hasEvents"] = false;

?>