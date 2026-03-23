<?php
$tdatatbl_budgets = array();
$tdatatbl_budgets[".searchableFields"] = array();
$tdatatbl_budgets[".ShortName"] = "tbl_budgets";
$tdatatbl_budgets[".OwnerID"] = "";
$tdatatbl_budgets[".OriginalTable"] = "tbl_budgets";


$tdatatbl_budgets[".pagesByType"] = my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" );
$tdatatbl_budgets[".originalPagesByType"] = $tdatatbl_budgets[".pagesByType"];
$tdatatbl_budgets[".pages"] = types2pages( my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" ) );
$tdatatbl_budgets[".originalPages"] = $tdatatbl_budgets[".pages"];
$tdatatbl_budgets[".defaultPages"] = my_json_decode( "{\"add\":\"add\",\"edit\":\"edit\",\"export\":\"export\",\"import\":\"import\",\"list\":\"list\",\"print\":\"print\",\"search\":\"search\",\"view\":\"view\"}" );
$tdatatbl_budgets[".originalDefaultPages"] = $tdatatbl_budgets[".defaultPages"];

//	field labels
$fieldLabelstbl_budgets = array();
$fieldToolTipstbl_budgets = array();
$pageTitlestbl_budgets = array();
$placeHolderstbl_budgets = array();

if(mlang_getcurrentlang()=="English")
{
	$fieldLabelstbl_budgets["English"] = array();
	$fieldToolTipstbl_budgets["English"] = array();
	$placeHolderstbl_budgets["English"] = array();
	$pageTitlestbl_budgets["English"] = array();
	$fieldLabelstbl_budgets["English"]["id"] = "Id";
	$fieldToolTipstbl_budgets["English"]["id"] = "";
	$placeHolderstbl_budgets["English"]["id"] = "";
	$fieldLabelstbl_budgets["English"]["user_id"] = "User Id";
	$fieldToolTipstbl_budgets["English"]["user_id"] = "";
	$placeHolderstbl_budgets["English"]["user_id"] = "";
	$fieldLabelstbl_budgets["English"]["category_id"] = "Category Id";
	$fieldToolTipstbl_budgets["English"]["category_id"] = "";
	$placeHolderstbl_budgets["English"]["category_id"] = "";
	$fieldLabelstbl_budgets["English"]["budget_month"] = "Budget Month";
	$fieldToolTipstbl_budgets["English"]["budget_month"] = "";
	$placeHolderstbl_budgets["English"]["budget_month"] = "";
	$fieldLabelstbl_budgets["English"]["amount"] = "Amount";
	$fieldToolTipstbl_budgets["English"]["amount"] = "";
	$placeHolderstbl_budgets["English"]["amount"] = "";
	if (count($fieldToolTipstbl_budgets["English"]))
		$tdatatbl_budgets[".isUseToolTips"] = true;
}


	$tdatatbl_budgets[".NCSearch"] = true;



$tdatatbl_budgets[".shortTableName"] = "tbl_budgets";
$tdatatbl_budgets[".nSecOptions"] = 0;

$tdatatbl_budgets[".mainTableOwnerID"] = "";
$tdatatbl_budgets[".entityType"] = 0;
$tdatatbl_budgets[".connId"] = "fhaddcom_finance_at_localhost";


$tdatatbl_budgets[".strOriginalTableName"] = "tbl_budgets";

		 



$tdatatbl_budgets[".showAddInPopup"] = false;

$tdatatbl_budgets[".showEditInPopup"] = false;

$tdatatbl_budgets[".showViewInPopup"] = false;

$tdatatbl_budgets[".listAjax"] = false;
//	temporary
//$tdatatbl_budgets[".listAjax"] = false;

	$tdatatbl_budgets[".audit"] = true;

	$tdatatbl_budgets[".locking"] = true;


$pages = $tdatatbl_budgets[".defaultPages"];

if( $pages[PAGE_EDIT] ) {
	$tdatatbl_budgets[".edit"] = true;
	$tdatatbl_budgets[".afterEditAction"] = 1;
	$tdatatbl_budgets[".closePopupAfterEdit"] = 1;
	$tdatatbl_budgets[".afterEditActionDetTable"] = "";
}

if( $pages[PAGE_ADD] ) {
$tdatatbl_budgets[".add"] = true;
$tdatatbl_budgets[".afterAddAction"] = 1;
$tdatatbl_budgets[".closePopupAfterAdd"] = 1;
$tdatatbl_budgets[".afterAddActionDetTable"] = "";
}

if( $pages[PAGE_LIST] ) {
	$tdatatbl_budgets[".list"] = true;
}



$tdatatbl_budgets[".strSortControlSettingsJSON"] = "";




if( $pages[PAGE_VIEW] ) {
$tdatatbl_budgets[".view"] = true;
}

if( $pages[PAGE_IMPORT] ) {
$tdatatbl_budgets[".import"] = true;
}

if( $pages[PAGE_EXPORT] ) {
$tdatatbl_budgets[".exportTo"] = true;
}

if( $pages[PAGE_PRINT] ) {
$tdatatbl_budgets[".printFriendly"] = true;
}



$tdatatbl_budgets[".showSimpleSearchOptions"] = true; // temp fix #13449

// Allow Show/Hide Fields in GRID
$tdatatbl_budgets[".allowShowHideFields"] = true; // temp fix #13449
//

// Allow Fields Reordering in GRID
$tdatatbl_budgets[".allowFieldsReordering"] = true; // temp fix #13449
//

$tdatatbl_budgets[".isUseAjaxSuggest"] = true;





$tdatatbl_budgets[".ajaxCodeSnippetAdded"] = false;

$tdatatbl_budgets[".buttonsAdded"] = false;

$tdatatbl_budgets[".addPageEvents"] = false;

// use timepicker for search panel
$tdatatbl_budgets[".isUseTimeForSearch"] = false;


$tdatatbl_budgets[".badgeColor"] = "778899";


$tdatatbl_budgets[".allSearchFields"] = array();
$tdatatbl_budgets[".filterFields"] = array();
$tdatatbl_budgets[".requiredSearchFields"] = array();

$tdatatbl_budgets[".googleLikeFields"] = array();
$tdatatbl_budgets[".googleLikeFields"][] = "id";
$tdatatbl_budgets[".googleLikeFields"][] = "user_id";
$tdatatbl_budgets[".googleLikeFields"][] = "category_id";
$tdatatbl_budgets[".googleLikeFields"][] = "budget_month";
$tdatatbl_budgets[".googleLikeFields"][] = "amount";



$tdatatbl_budgets[".tableType"] = "list";

$tdatatbl_budgets[".printerPageOrientation"] = 0;
$tdatatbl_budgets[".nPrinterPageScale"] = 100;

$tdatatbl_budgets[".nPrinterSplitRecords"] = 40;

$tdatatbl_budgets[".geocodingEnabled"] = false;










$tdatatbl_budgets[".pageSize"] = 20;

$tdatatbl_budgets[".warnLeavingPages"] = true;



$tstrOrderBy = "";
$tdatatbl_budgets[".strOrderBy"] = $tstrOrderBy;

$tdatatbl_budgets[".orderindexes"] = array();


$tdatatbl_budgets[".sqlHead"] = "SELECT id,  	user_id,  	category_id,  	budget_month,  	amount";
$tdatatbl_budgets[".sqlFrom"] = "FROM tbl_budgets";
$tdatatbl_budgets[".sqlWhereExpr"] = "";
$tdatatbl_budgets[".sqlTail"] = "";










//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdatatbl_budgets[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdatatbl_budgets[".arrGroupsPerPage"] = $arrGPP;

$tdatatbl_budgets[".highlightSearchResults"] = true;

$tableKeystbl_budgets = array();
$tableKeystbl_budgets[] = "id";
$tdatatbl_budgets[".Keys"] = $tableKeystbl_budgets;


$tdatatbl_budgets[".hideMobileList"] = array();




//	id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "id";
	$fdata["GoodName"] = "id";
	$fdata["ownerTable"] = "tbl_budgets";
	$fdata["Label"] = GetFieldLabel("tbl_budgets","id");
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


	$tdatatbl_budgets["id"] = $fdata;
		$tdatatbl_budgets[".searchableFields"][] = "id";
//	user_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "user_id";
	$fdata["GoodName"] = "user_id";
	$fdata["ownerTable"] = "tbl_budgets";
	$fdata["Label"] = GetFieldLabel("tbl_budgets","user_id");
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


	$tdatatbl_budgets["user_id"] = $fdata;
		$tdatatbl_budgets[".searchableFields"][] = "user_id";
//	category_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "category_id";
	$fdata["GoodName"] = "category_id";
	$fdata["ownerTable"] = "tbl_budgets";
	$fdata["Label"] = GetFieldLabel("tbl_budgets","category_id");
	$fdata["FieldType"] = 3;


	
	
										

		$fdata["strField"] = "category_id";

		$fdata["sourceSingle"] = "category_id";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "category_id";

	
	
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


	$tdatatbl_budgets["category_id"] = $fdata;
		$tdatatbl_budgets[".searchableFields"][] = "category_id";
//	budget_month
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 4;
	$fdata["strName"] = "budget_month";
	$fdata["GoodName"] = "budget_month";
	$fdata["ownerTable"] = "tbl_budgets";
	$fdata["Label"] = GetFieldLabel("tbl_budgets","budget_month");
	$fdata["FieldType"] = 200;


	
	
										

		$fdata["strField"] = "budget_month";

		$fdata["sourceSingle"] = "budget_month";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "budget_month";

	
	
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


	$tdatatbl_budgets["budget_month"] = $fdata;
		$tdatatbl_budgets[".searchableFields"][] = "budget_month";
//	amount
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 5;
	$fdata["strName"] = "amount";
	$fdata["GoodName"] = "amount";
	$fdata["ownerTable"] = "tbl_budgets";
	$fdata["Label"] = GetFieldLabel("tbl_budgets","amount");
	$fdata["FieldType"] = 14;


	
	
										

		$fdata["strField"] = "amount";

		$fdata["sourceSingle"] = "amount";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "amount";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "Number");

	
	
	
	
	
	
	
		$vdata["DecimalDigits"] = 0;

	
	
	
	
	
	
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


	$tdatatbl_budgets["amount"] = $fdata;
		$tdatatbl_budgets[".searchableFields"][] = "amount";


$tables_data["tbl_budgets"]=&$tdatatbl_budgets;
$field_labels["tbl_budgets"] = &$fieldLabelstbl_budgets;
$fieldToolTips["tbl_budgets"] = &$fieldToolTipstbl_budgets;
$placeHolders["tbl_budgets"] = &$placeHolderstbl_budgets;
$page_titles["tbl_budgets"] = &$pageTitlestbl_budgets;


changeTextControlsToDate( "tbl_budgets" );

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)

//if !@TABLE.bReportCrossTab

$detailsTablesData["tbl_budgets"] = array();
//endif

// tables which are master tables for current table (detail)
$masterTablesData["tbl_budgets"] = array();



// -----------------end  prepare master-details data arrays ------------------------------//



require_once(getabspath("classes/sql.php"));











function createSqlQuery_tbl_budgets()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "id,  	user_id,  	category_id,  	budget_month,  	amount";
$proto0["m_strFrom"] = "FROM tbl_budgets";
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
	"m_strTable" => "tbl_budgets",
	"m_srcTableName" => "tbl_budgets"
));

$proto6["m_sql"] = "id";
$proto6["m_srcTableName"] = "tbl_budgets";
$proto6["m_expr"]=$obj;
$proto6["m_alias"] = "";
$obj = new SQLFieldListItem($proto6);

$proto0["m_fieldlist"][]=$obj;
						$proto8=array();
			$obj = new SQLField(array(
	"m_strName" => "user_id",
	"m_strTable" => "tbl_budgets",
	"m_srcTableName" => "tbl_budgets"
));

$proto8["m_sql"] = "user_id";
$proto8["m_srcTableName"] = "tbl_budgets";
$proto8["m_expr"]=$obj;
$proto8["m_alias"] = "";
$obj = new SQLFieldListItem($proto8);

$proto0["m_fieldlist"][]=$obj;
						$proto10=array();
			$obj = new SQLField(array(
	"m_strName" => "category_id",
	"m_strTable" => "tbl_budgets",
	"m_srcTableName" => "tbl_budgets"
));

$proto10["m_sql"] = "category_id";
$proto10["m_srcTableName"] = "tbl_budgets";
$proto10["m_expr"]=$obj;
$proto10["m_alias"] = "";
$obj = new SQLFieldListItem($proto10);

$proto0["m_fieldlist"][]=$obj;
						$proto12=array();
			$obj = new SQLField(array(
	"m_strName" => "budget_month",
	"m_strTable" => "tbl_budgets",
	"m_srcTableName" => "tbl_budgets"
));

$proto12["m_sql"] = "budget_month";
$proto12["m_srcTableName"] = "tbl_budgets";
$proto12["m_expr"]=$obj;
$proto12["m_alias"] = "";
$obj = new SQLFieldListItem($proto12);

$proto0["m_fieldlist"][]=$obj;
						$proto14=array();
			$obj = new SQLField(array(
	"m_strName" => "amount",
	"m_strTable" => "tbl_budgets",
	"m_srcTableName" => "tbl_budgets"
));

$proto14["m_sql"] = "amount";
$proto14["m_srcTableName"] = "tbl_budgets";
$proto14["m_expr"]=$obj;
$proto14["m_alias"] = "";
$obj = new SQLFieldListItem($proto14);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto16=array();
$proto16["m_link"] = "SQLL_MAIN";
			$proto17=array();
$proto17["m_strName"] = "tbl_budgets";
$proto17["m_srcTableName"] = "tbl_budgets";
$proto17["m_columns"] = array();
$proto17["m_columns"][] = "id";
$proto17["m_columns"][] = "user_id";
$proto17["m_columns"][] = "category_id";
$proto17["m_columns"][] = "budget_month";
$proto17["m_columns"][] = "amount";
$obj = new SQLTable($proto17);

$proto16["m_table"] = $obj;
$proto16["m_sql"] = "tbl_budgets";
$proto16["m_alias"] = "";
$proto16["m_srcTableName"] = "tbl_budgets";
$proto18=array();
$proto18["m_sql"] = "";
$proto18["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto18["m_column"]=$obj;
$proto18["m_contained"] = array();
$proto18["m_strCase"] = "";
$proto18["m_havingmode"] = false;
$proto18["m_inBrackets"] = false;
$proto18["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto18);

$proto16["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto16);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="tbl_budgets";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_tbl_budgets = createSqlQuery_tbl_budgets();


	
					
;

					

$tdatatbl_budgets[".sqlquery"] = $queryData_tbl_budgets;



$tdatatbl_budgets[".hasEvents"] = false;

?>