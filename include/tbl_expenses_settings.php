<?php
$tdatatbl_expenses = array();
$tdatatbl_expenses[".searchableFields"] = array();
$tdatatbl_expenses[".ShortName"] = "tbl_expenses";
$tdatatbl_expenses[".OwnerID"] = "";
$tdatatbl_expenses[".OriginalTable"] = "tbl_expenses";


$tdatatbl_expenses[".pagesByType"] = my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" );
$tdatatbl_expenses[".originalPagesByType"] = $tdatatbl_expenses[".pagesByType"];
$tdatatbl_expenses[".pages"] = types2pages( my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" ) );
$tdatatbl_expenses[".originalPages"] = $tdatatbl_expenses[".pages"];
$tdatatbl_expenses[".defaultPages"] = my_json_decode( "{\"add\":\"add\",\"edit\":\"edit\",\"export\":\"export\",\"import\":\"import\",\"list\":\"list\",\"print\":\"print\",\"search\":\"search\",\"view\":\"view\"}" );
$tdatatbl_expenses[".originalDefaultPages"] = $tdatatbl_expenses[".defaultPages"];

//	field labels
$fieldLabelstbl_expenses = array();
$fieldToolTipstbl_expenses = array();
$pageTitlestbl_expenses = array();
$placeHolderstbl_expenses = array();

if(mlang_getcurrentlang()=="English")
{
	$fieldLabelstbl_expenses["English"] = array();
	$fieldToolTipstbl_expenses["English"] = array();
	$placeHolderstbl_expenses["English"] = array();
	$pageTitlestbl_expenses["English"] = array();
	$fieldLabelstbl_expenses["English"]["id"] = "Id";
	$fieldToolTipstbl_expenses["English"]["id"] = "";
	$placeHolderstbl_expenses["English"]["id"] = "";
	$fieldLabelstbl_expenses["English"]["user_id"] = "User Id";
	$fieldToolTipstbl_expenses["English"]["user_id"] = "";
	$placeHolderstbl_expenses["English"]["user_id"] = "";
	$fieldLabelstbl_expenses["English"]["category_id"] = "Category Id";
	$fieldToolTipstbl_expenses["English"]["category_id"] = "";
	$placeHolderstbl_expenses["English"]["category_id"] = "";
	$fieldLabelstbl_expenses["English"]["expense_date"] = "Expense Date";
	$fieldToolTipstbl_expenses["English"]["expense_date"] = "";
	$placeHolderstbl_expenses["English"]["expense_date"] = "";
	$fieldLabelstbl_expenses["English"]["amount"] = "Amount";
	$fieldToolTipstbl_expenses["English"]["amount"] = "";
	$placeHolderstbl_expenses["English"]["amount"] = "";
	$fieldLabelstbl_expenses["English"]["description"] = "Description";
	$fieldToolTipstbl_expenses["English"]["description"] = "";
	$placeHolderstbl_expenses["English"]["description"] = "";
	$fieldLabelstbl_expenses["English"]["created_at"] = "Created At";
	$fieldToolTipstbl_expenses["English"]["created_at"] = "";
	$placeHolderstbl_expenses["English"]["created_at"] = "";
	$fieldLabelstbl_expenses["English"]["receipt_path"] = "Receipt Path";
	$fieldToolTipstbl_expenses["English"]["receipt_path"] = "";
	$placeHolderstbl_expenses["English"]["receipt_path"] = "";
	$fieldLabelstbl_expenses["English"]["original_currency"] = "Original Currency";
	$fieldToolTipstbl_expenses["English"]["original_currency"] = "";
	$placeHolderstbl_expenses["English"]["original_currency"] = "";
	$fieldLabelstbl_expenses["English"]["original_amount"] = "Original Amount";
	$fieldToolTipstbl_expenses["English"]["original_amount"] = "";
	$placeHolderstbl_expenses["English"]["original_amount"] = "";
	$fieldLabelstbl_expenses["English"]["exchange_rate"] = "Exchange Rate";
	$fieldToolTipstbl_expenses["English"]["exchange_rate"] = "";
	$placeHolderstbl_expenses["English"]["exchange_rate"] = "";
	$fieldLabelstbl_expenses["English"]["is_lhdn"] = "Is Lhdn";
	$fieldToolTipstbl_expenses["English"]["is_lhdn"] = "";
	$placeHolderstbl_expenses["English"]["is_lhdn"] = "";
	if (count($fieldToolTipstbl_expenses["English"]))
		$tdatatbl_expenses[".isUseToolTips"] = true;
}


	$tdatatbl_expenses[".NCSearch"] = true;



$tdatatbl_expenses[".shortTableName"] = "tbl_expenses";
$tdatatbl_expenses[".nSecOptions"] = 0;

$tdatatbl_expenses[".mainTableOwnerID"] = "";
$tdatatbl_expenses[".entityType"] = 0;
$tdatatbl_expenses[".connId"] = "fhaddcom_finance_at_localhost";


$tdatatbl_expenses[".strOriginalTableName"] = "tbl_expenses";

		 



$tdatatbl_expenses[".showAddInPopup"] = false;

$tdatatbl_expenses[".showEditInPopup"] = false;

$tdatatbl_expenses[".showViewInPopup"] = false;

$tdatatbl_expenses[".listAjax"] = false;
//	temporary
//$tdatatbl_expenses[".listAjax"] = false;

	$tdatatbl_expenses[".audit"] = true;

	$tdatatbl_expenses[".locking"] = true;


$pages = $tdatatbl_expenses[".defaultPages"];

if( $pages[PAGE_EDIT] ) {
	$tdatatbl_expenses[".edit"] = true;
	$tdatatbl_expenses[".afterEditAction"] = 1;
	$tdatatbl_expenses[".closePopupAfterEdit"] = 1;
	$tdatatbl_expenses[".afterEditActionDetTable"] = "";
}

if( $pages[PAGE_ADD] ) {
$tdatatbl_expenses[".add"] = true;
$tdatatbl_expenses[".afterAddAction"] = 1;
$tdatatbl_expenses[".closePopupAfterAdd"] = 1;
$tdatatbl_expenses[".afterAddActionDetTable"] = "";
}

if( $pages[PAGE_LIST] ) {
	$tdatatbl_expenses[".list"] = true;
}



$tdatatbl_expenses[".strSortControlSettingsJSON"] = "";




if( $pages[PAGE_VIEW] ) {
$tdatatbl_expenses[".view"] = true;
}

if( $pages[PAGE_IMPORT] ) {
$tdatatbl_expenses[".import"] = true;
}

if( $pages[PAGE_EXPORT] ) {
$tdatatbl_expenses[".exportTo"] = true;
}

if( $pages[PAGE_PRINT] ) {
$tdatatbl_expenses[".printFriendly"] = true;
}



$tdatatbl_expenses[".showSimpleSearchOptions"] = true; // temp fix #13449

// Allow Show/Hide Fields in GRID
$tdatatbl_expenses[".allowShowHideFields"] = true; // temp fix #13449
//

// Allow Fields Reordering in GRID
$tdatatbl_expenses[".allowFieldsReordering"] = true; // temp fix #13449
//

$tdatatbl_expenses[".isUseAjaxSuggest"] = true;





$tdatatbl_expenses[".ajaxCodeSnippetAdded"] = false;

$tdatatbl_expenses[".buttonsAdded"] = false;

$tdatatbl_expenses[".addPageEvents"] = false;

// use timepicker for search panel
$tdatatbl_expenses[".isUseTimeForSearch"] = false;


$tdatatbl_expenses[".badgeColor"] = "D2691E";


$tdatatbl_expenses[".allSearchFields"] = array();
$tdatatbl_expenses[".filterFields"] = array();
$tdatatbl_expenses[".requiredSearchFields"] = array();

$tdatatbl_expenses[".googleLikeFields"] = array();
$tdatatbl_expenses[".googleLikeFields"][] = "id";
$tdatatbl_expenses[".googleLikeFields"][] = "user_id";
$tdatatbl_expenses[".googleLikeFields"][] = "category_id";
$tdatatbl_expenses[".googleLikeFields"][] = "expense_date";
$tdatatbl_expenses[".googleLikeFields"][] = "amount";
$tdatatbl_expenses[".googleLikeFields"][] = "description";
$tdatatbl_expenses[".googleLikeFields"][] = "receipt_path";
$tdatatbl_expenses[".googleLikeFields"][] = "original_currency";
$tdatatbl_expenses[".googleLikeFields"][] = "original_amount";
$tdatatbl_expenses[".googleLikeFields"][] = "exchange_rate";
$tdatatbl_expenses[".googleLikeFields"][] = "created_at";
$tdatatbl_expenses[".googleLikeFields"][] = "is_lhdn";



$tdatatbl_expenses[".tableType"] = "list";

$tdatatbl_expenses[".printerPageOrientation"] = 0;
$tdatatbl_expenses[".nPrinterPageScale"] = 100;

$tdatatbl_expenses[".nPrinterSplitRecords"] = 40;

$tdatatbl_expenses[".geocodingEnabled"] = false;










$tdatatbl_expenses[".pageSize"] = 20;

$tdatatbl_expenses[".warnLeavingPages"] = true;



$tstrOrderBy = "";
$tdatatbl_expenses[".strOrderBy"] = $tstrOrderBy;

$tdatatbl_expenses[".orderindexes"] = array();


$tdatatbl_expenses[".sqlHead"] = "SELECT id,  	user_id,  	category_id,  	expense_date,  	amount,  	description,  	receipt_path,  	original_currency,  	original_amount,  	exchange_rate,  	created_at,  	is_lhdn";
$tdatatbl_expenses[".sqlFrom"] = "FROM tbl_expenses";
$tdatatbl_expenses[".sqlWhereExpr"] = "";
$tdatatbl_expenses[".sqlTail"] = "";










//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdatatbl_expenses[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdatatbl_expenses[".arrGroupsPerPage"] = $arrGPP;

$tdatatbl_expenses[".highlightSearchResults"] = true;

$tableKeystbl_expenses = array();
$tableKeystbl_expenses[] = "id";
$tdatatbl_expenses[".Keys"] = $tableKeystbl_expenses;


$tdatatbl_expenses[".hideMobileList"] = array();




//	id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "id";
	$fdata["GoodName"] = "id";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","id");
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


	$tdatatbl_expenses["id"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "id";
//	user_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "user_id";
	$fdata["GoodName"] = "user_id";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","user_id");
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


	$tdatatbl_expenses["user_id"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "user_id";
//	category_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "category_id";
	$fdata["GoodName"] = "category_id";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","category_id");
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


	$tdatatbl_expenses["category_id"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "category_id";
//	expense_date
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 4;
	$fdata["strName"] = "expense_date";
	$fdata["GoodName"] = "expense_date";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","expense_date");
	$fdata["FieldType"] = 7;


	
	
										

		$fdata["strField"] = "expense_date";

		$fdata["sourceSingle"] = "expense_date";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "expense_date";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "Short Date");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Date");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



	
	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
		$edata["DateEditType"] = 13;
	$edata["InitialYearFactor"] = 100;
	$edata["LastYearFactor"] = 10;

	
	
	
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
		$fdata["defaultSearchOption"] = "Equals";

			// the default search options list
				$fdata["searchOptionsList"] = array("Equals", "More than", "Less than", "Between", EMPTY_SEARCH, NOT_EMPTY );
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


	$tdatatbl_expenses["expense_date"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "expense_date";
//	amount
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 5;
	$fdata["strName"] = "amount";
	$fdata["GoodName"] = "amount";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","amount");
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


	$tdatatbl_expenses["amount"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "amount";
//	description
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 6;
	$fdata["strName"] = "description";
	$fdata["GoodName"] = "description";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","description");
	$fdata["FieldType"] = 200;


	
	
										

		$fdata["strField"] = "description";

		$fdata["sourceSingle"] = "description";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "description";

	
	
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


	$tdatatbl_expenses["description"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "description";
//	receipt_path
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 7;
	$fdata["strName"] = "receipt_path";
	$fdata["GoodName"] = "receipt_path";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","receipt_path");
	$fdata["FieldType"] = 200;


	
	
										

		$fdata["strField"] = "receipt_path";

		$fdata["sourceSingle"] = "receipt_path";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "receipt_path";

	
	
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
			$edata["EditParams"].= " maxlength=255";

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


	$tdatatbl_expenses["receipt_path"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "receipt_path";
//	original_currency
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 8;
	$fdata["strName"] = "original_currency";
	$fdata["GoodName"] = "original_currency";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","original_currency");
	$fdata["FieldType"] = 200;


	
	
										

		$fdata["strField"] = "original_currency";

		$fdata["sourceSingle"] = "original_currency";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "original_currency";

	
	
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
			$edata["EditParams"].= " maxlength=10";

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


	$tdatatbl_expenses["original_currency"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "original_currency";
//	original_amount
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 9;
	$fdata["strName"] = "original_amount";
	$fdata["GoodName"] = "original_amount";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","original_amount");
	$fdata["FieldType"] = 14;


	
	
										

		$fdata["strField"] = "original_amount";

		$fdata["sourceSingle"] = "original_amount";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "original_amount";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "Number");

	
	
	
	
	
	
	
		$vdata["DecimalDigits"] = 2;

	
	
	
	
	
	
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


	$tdatatbl_expenses["original_amount"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "original_amount";
//	exchange_rate
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 10;
	$fdata["strName"] = "exchange_rate";
	$fdata["GoodName"] = "exchange_rate";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","exchange_rate");
	$fdata["FieldType"] = 14;


	
	
										

		$fdata["strField"] = "exchange_rate";

		$fdata["sourceSingle"] = "exchange_rate";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "exchange_rate";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "Number");

	
	
	
	
	
	
	
		$vdata["DecimalDigits"] = 6;

	
	
	
	
	
	
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


	$tdatatbl_expenses["exchange_rate"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "exchange_rate";
//	created_at
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 11;
	$fdata["strName"] = "created_at";
	$fdata["GoodName"] = "created_at";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","created_at");
	$fdata["FieldType"] = 135;


	
	
										

		$fdata["strField"] = "created_at";

		$fdata["sourceSingle"] = "created_at";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "created_at";

	
	
				$fdata["UploadFolder"] = "files";

//  Begin View Formats
	$fdata["ViewFormats"] = array();

	$vdata = array("ViewFormat" => "Short Date");

	
	
	
	
	
	
	
	
	
	
	
	
	
	
		$vdata["NeedEncode"] = true;

	
		$vdata["truncateText"] = true;
	$vdata["NumberOfChars"] = 80;

	$fdata["ViewFormats"]["view"] = $vdata;
//  End View Formats

//	Begin Edit Formats
	$fdata["EditFormats"] = array();

	$edata = array("EditFormat" => "Date");

	
		$edata["weekdayMessage"] = array("message" => "", "messageType" => "Text");
	$edata["weekdays"] = "[]";


	
	



	
	
	
	
			$edata["acceptFileTypesHtml"] = "";

		$edata["maxNumberOfFiles"] = 1;

	
	
		$edata["DateEditType"] = 13;
	$edata["InitialYearFactor"] = 100;
	$edata["LastYearFactor"] = 10;

	
	
	
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
		$fdata["defaultSearchOption"] = "Equals";

			// the default search options list
				$fdata["searchOptionsList"] = array("Equals", "More than", "Less than", "Between", EMPTY_SEARCH, NOT_EMPTY );
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


	$tdatatbl_expenses["created_at"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "created_at";
//	is_lhdn
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 12;
	$fdata["strName"] = "is_lhdn";
	$fdata["GoodName"] = "is_lhdn";
	$fdata["ownerTable"] = "tbl_expenses";
	$fdata["Label"] = GetFieldLabel("tbl_expenses","is_lhdn");
	$fdata["FieldType"] = 3;


	
	
										

		$fdata["strField"] = "is_lhdn";

		$fdata["sourceSingle"] = "is_lhdn";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "is_lhdn";

	
	
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


	$tdatatbl_expenses["is_lhdn"] = $fdata;
		$tdatatbl_expenses[".searchableFields"][] = "is_lhdn";


$tables_data["tbl_expenses"]=&$tdatatbl_expenses;
$field_labels["tbl_expenses"] = &$fieldLabelstbl_expenses;
$fieldToolTips["tbl_expenses"] = &$fieldToolTipstbl_expenses;
$placeHolders["tbl_expenses"] = &$placeHolderstbl_expenses;
$page_titles["tbl_expenses"] = &$pageTitlestbl_expenses;


changeTextControlsToDate( "tbl_expenses" );

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)

//if !@TABLE.bReportCrossTab

$detailsTablesData["tbl_expenses"] = array();
//endif

// tables which are master tables for current table (detail)
$masterTablesData["tbl_expenses"] = array();



// -----------------end  prepare master-details data arrays ------------------------------//



require_once(getabspath("classes/sql.php"));











function createSqlQuery_tbl_expenses()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "id,  	user_id,  	category_id,  	expense_date,  	amount,  	description,  	receipt_path,  	original_currency,  	original_amount,  	exchange_rate,  	created_at,  	is_lhdn";
$proto0["m_strFrom"] = "FROM tbl_expenses";
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
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto6["m_sql"] = "id";
$proto6["m_srcTableName"] = "tbl_expenses";
$proto6["m_expr"]=$obj;
$proto6["m_alias"] = "";
$obj = new SQLFieldListItem($proto6);

$proto0["m_fieldlist"][]=$obj;
						$proto8=array();
			$obj = new SQLField(array(
	"m_strName" => "user_id",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto8["m_sql"] = "user_id";
$proto8["m_srcTableName"] = "tbl_expenses";
$proto8["m_expr"]=$obj;
$proto8["m_alias"] = "";
$obj = new SQLFieldListItem($proto8);

$proto0["m_fieldlist"][]=$obj;
						$proto10=array();
			$obj = new SQLField(array(
	"m_strName" => "category_id",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto10["m_sql"] = "category_id";
$proto10["m_srcTableName"] = "tbl_expenses";
$proto10["m_expr"]=$obj;
$proto10["m_alias"] = "";
$obj = new SQLFieldListItem($proto10);

$proto0["m_fieldlist"][]=$obj;
						$proto12=array();
			$obj = new SQLField(array(
	"m_strName" => "expense_date",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto12["m_sql"] = "expense_date";
$proto12["m_srcTableName"] = "tbl_expenses";
$proto12["m_expr"]=$obj;
$proto12["m_alias"] = "";
$obj = new SQLFieldListItem($proto12);

$proto0["m_fieldlist"][]=$obj;
						$proto14=array();
			$obj = new SQLField(array(
	"m_strName" => "amount",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto14["m_sql"] = "amount";
$proto14["m_srcTableName"] = "tbl_expenses";
$proto14["m_expr"]=$obj;
$proto14["m_alias"] = "";
$obj = new SQLFieldListItem($proto14);

$proto0["m_fieldlist"][]=$obj;
						$proto16=array();
			$obj = new SQLField(array(
	"m_strName" => "description",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto16["m_sql"] = "description";
$proto16["m_srcTableName"] = "tbl_expenses";
$proto16["m_expr"]=$obj;
$proto16["m_alias"] = "";
$obj = new SQLFieldListItem($proto16);

$proto0["m_fieldlist"][]=$obj;
						$proto18=array();
			$obj = new SQLField(array(
	"m_strName" => "receipt_path",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto18["m_sql"] = "receipt_path";
$proto18["m_srcTableName"] = "tbl_expenses";
$proto18["m_expr"]=$obj;
$proto18["m_alias"] = "";
$obj = new SQLFieldListItem($proto18);

$proto0["m_fieldlist"][]=$obj;
						$proto20=array();
			$obj = new SQLField(array(
	"m_strName" => "original_currency",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto20["m_sql"] = "original_currency";
$proto20["m_srcTableName"] = "tbl_expenses";
$proto20["m_expr"]=$obj;
$proto20["m_alias"] = "";
$obj = new SQLFieldListItem($proto20);

$proto0["m_fieldlist"][]=$obj;
						$proto22=array();
			$obj = new SQLField(array(
	"m_strName" => "original_amount",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto22["m_sql"] = "original_amount";
$proto22["m_srcTableName"] = "tbl_expenses";
$proto22["m_expr"]=$obj;
$proto22["m_alias"] = "";
$obj = new SQLFieldListItem($proto22);

$proto0["m_fieldlist"][]=$obj;
						$proto24=array();
			$obj = new SQLField(array(
	"m_strName" => "exchange_rate",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto24["m_sql"] = "exchange_rate";
$proto24["m_srcTableName"] = "tbl_expenses";
$proto24["m_expr"]=$obj;
$proto24["m_alias"] = "";
$obj = new SQLFieldListItem($proto24);

$proto0["m_fieldlist"][]=$obj;
						$proto26=array();
			$obj = new SQLField(array(
	"m_strName" => "created_at",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto26["m_sql"] = "created_at";
$proto26["m_srcTableName"] = "tbl_expenses";
$proto26["m_expr"]=$obj;
$proto26["m_alias"] = "";
$obj = new SQLFieldListItem($proto26);

$proto0["m_fieldlist"][]=$obj;
						$proto28=array();
			$obj = new SQLField(array(
	"m_strName" => "is_lhdn",
	"m_strTable" => "tbl_expenses",
	"m_srcTableName" => "tbl_expenses"
));

$proto28["m_sql"] = "is_lhdn";
$proto28["m_srcTableName"] = "tbl_expenses";
$proto28["m_expr"]=$obj;
$proto28["m_alias"] = "";
$obj = new SQLFieldListItem($proto28);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto30=array();
$proto30["m_link"] = "SQLL_MAIN";
			$proto31=array();
$proto31["m_strName"] = "tbl_expenses";
$proto31["m_srcTableName"] = "tbl_expenses";
$proto31["m_columns"] = array();
$proto31["m_columns"][] = "id";
$proto31["m_columns"][] = "user_id";
$proto31["m_columns"][] = "category_id";
$proto31["m_columns"][] = "expense_date";
$proto31["m_columns"][] = "amount";
$proto31["m_columns"][] = "description";
$proto31["m_columns"][] = "receipt_path";
$proto31["m_columns"][] = "original_currency";
$proto31["m_columns"][] = "original_amount";
$proto31["m_columns"][] = "exchange_rate";
$proto31["m_columns"][] = "created_at";
$proto31["m_columns"][] = "is_lhdn";
$obj = new SQLTable($proto31);

$proto30["m_table"] = $obj;
$proto30["m_sql"] = "tbl_expenses";
$proto30["m_alias"] = "";
$proto30["m_srcTableName"] = "tbl_expenses";
$proto32=array();
$proto32["m_sql"] = "";
$proto32["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto32["m_column"]=$obj;
$proto32["m_contained"] = array();
$proto32["m_strCase"] = "";
$proto32["m_havingmode"] = false;
$proto32["m_inBrackets"] = false;
$proto32["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto32);

$proto30["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto30);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="tbl_expenses";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_tbl_expenses = createSqlQuery_tbl_expenses();


	
					
;

												

$tdatatbl_expenses[".sqlquery"] = $queryData_tbl_expenses;



$tdatatbl_expenses[".hasEvents"] = false;

?>