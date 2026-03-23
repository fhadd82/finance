<?php
$tdatatbl_income = array();
$tdatatbl_income[".searchableFields"] = array();
$tdatatbl_income[".ShortName"] = "tbl_income";
$tdatatbl_income[".OwnerID"] = "";
$tdatatbl_income[".OriginalTable"] = "tbl_income";


$tdatatbl_income[".pagesByType"] = my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" );
$tdatatbl_income[".originalPagesByType"] = $tdatatbl_income[".pagesByType"];
$tdatatbl_income[".pages"] = types2pages( my_json_decode( "{\"add\":[\"add\"],\"edit\":[\"edit\"],\"export\":[\"export\"],\"import\":[\"import\"],\"list\":[\"list\"],\"print\":[\"print\"],\"search\":[\"search\"],\"view\":[\"view\"]}" ) );
$tdatatbl_income[".originalPages"] = $tdatatbl_income[".pages"];
$tdatatbl_income[".defaultPages"] = my_json_decode( "{\"add\":\"add\",\"edit\":\"edit\",\"export\":\"export\",\"import\":\"import\",\"list\":\"list\",\"print\":\"print\",\"search\":\"search\",\"view\":\"view\"}" );
$tdatatbl_income[".originalDefaultPages"] = $tdatatbl_income[".defaultPages"];

//	field labels
$fieldLabelstbl_income = array();
$fieldToolTipstbl_income = array();
$pageTitlestbl_income = array();
$placeHolderstbl_income = array();

if(mlang_getcurrentlang()=="English")
{
	$fieldLabelstbl_income["English"] = array();
	$fieldToolTipstbl_income["English"] = array();
	$placeHolderstbl_income["English"] = array();
	$pageTitlestbl_income["English"] = array();
	$fieldLabelstbl_income["English"]["id"] = "Id";
	$fieldToolTipstbl_income["English"]["id"] = "";
	$placeHolderstbl_income["English"]["id"] = "";
	$fieldLabelstbl_income["English"]["user_id"] = "User Id";
	$fieldToolTipstbl_income["English"]["user_id"] = "";
	$placeHolderstbl_income["English"]["user_id"] = "";
	$fieldLabelstbl_income["English"]["income_date"] = "Income Date";
	$fieldToolTipstbl_income["English"]["income_date"] = "";
	$placeHolderstbl_income["English"]["income_date"] = "";
	$fieldLabelstbl_income["English"]["amount"] = "Amount";
	$fieldToolTipstbl_income["English"]["amount"] = "";
	$placeHolderstbl_income["English"]["amount"] = "";
	$fieldLabelstbl_income["English"]["category_id"] = "Category Id";
	$fieldToolTipstbl_income["English"]["category_id"] = "";
	$placeHolderstbl_income["English"]["category_id"] = "";
	$fieldLabelstbl_income["English"]["description"] = "Description";
	$fieldToolTipstbl_income["English"]["description"] = "";
	$placeHolderstbl_income["English"]["description"] = "";
	$fieldLabelstbl_income["English"]["receipt_path"] = "Receipt Path";
	$fieldToolTipstbl_income["English"]["receipt_path"] = "";
	$placeHolderstbl_income["English"]["receipt_path"] = "";
	$fieldLabelstbl_income["English"]["created_at"] = "Created At";
	$fieldToolTipstbl_income["English"]["created_at"] = "";
	$placeHolderstbl_income["English"]["created_at"] = "";
	$fieldLabelstbl_income["English"]["original_currency"] = "Original Currency";
	$fieldToolTipstbl_income["English"]["original_currency"] = "";
	$placeHolderstbl_income["English"]["original_currency"] = "";
	$fieldLabelstbl_income["English"]["original_amount"] = "Original Amount";
	$fieldToolTipstbl_income["English"]["original_amount"] = "";
	$placeHolderstbl_income["English"]["original_amount"] = "";
	$fieldLabelstbl_income["English"]["exchange_rate"] = "Exchange Rate";
	$fieldToolTipstbl_income["English"]["exchange_rate"] = "";
	$placeHolderstbl_income["English"]["exchange_rate"] = "";
	if (count($fieldToolTipstbl_income["English"]))
		$tdatatbl_income[".isUseToolTips"] = true;
}


	$tdatatbl_income[".NCSearch"] = true;



$tdatatbl_income[".shortTableName"] = "tbl_income";
$tdatatbl_income[".nSecOptions"] = 0;

$tdatatbl_income[".mainTableOwnerID"] = "";
$tdatatbl_income[".entityType"] = 0;
$tdatatbl_income[".connId"] = "fhaddcom_finance_at_localhost";


$tdatatbl_income[".strOriginalTableName"] = "tbl_income";

		 



$tdatatbl_income[".showAddInPopup"] = false;

$tdatatbl_income[".showEditInPopup"] = false;

$tdatatbl_income[".showViewInPopup"] = false;

$tdatatbl_income[".listAjax"] = false;
//	temporary
//$tdatatbl_income[".listAjax"] = false;

	$tdatatbl_income[".audit"] = true;

	$tdatatbl_income[".locking"] = true;


$pages = $tdatatbl_income[".defaultPages"];

if( $pages[PAGE_EDIT] ) {
	$tdatatbl_income[".edit"] = true;
	$tdatatbl_income[".afterEditAction"] = 1;
	$tdatatbl_income[".closePopupAfterEdit"] = 1;
	$tdatatbl_income[".afterEditActionDetTable"] = "";
}

if( $pages[PAGE_ADD] ) {
$tdatatbl_income[".add"] = true;
$tdatatbl_income[".afterAddAction"] = 1;
$tdatatbl_income[".closePopupAfterAdd"] = 1;
$tdatatbl_income[".afterAddActionDetTable"] = "";
}

if( $pages[PAGE_LIST] ) {
	$tdatatbl_income[".list"] = true;
}



$tdatatbl_income[".strSortControlSettingsJSON"] = "";




if( $pages[PAGE_VIEW] ) {
$tdatatbl_income[".view"] = true;
}

if( $pages[PAGE_IMPORT] ) {
$tdatatbl_income[".import"] = true;
}

if( $pages[PAGE_EXPORT] ) {
$tdatatbl_income[".exportTo"] = true;
}

if( $pages[PAGE_PRINT] ) {
$tdatatbl_income[".printFriendly"] = true;
}



$tdatatbl_income[".showSimpleSearchOptions"] = true; // temp fix #13449

// Allow Show/Hide Fields in GRID
$tdatatbl_income[".allowShowHideFields"] = true; // temp fix #13449
//

// Allow Fields Reordering in GRID
$tdatatbl_income[".allowFieldsReordering"] = true; // temp fix #13449
//

$tdatatbl_income[".isUseAjaxSuggest"] = true;





$tdatatbl_income[".ajaxCodeSnippetAdded"] = false;

$tdatatbl_income[".buttonsAdded"] = false;

$tdatatbl_income[".addPageEvents"] = false;

// use timepicker for search panel
$tdatatbl_income[".isUseTimeForSearch"] = false;


$tdatatbl_income[".badgeColor"] = "5F9EA0";


$tdatatbl_income[".allSearchFields"] = array();
$tdatatbl_income[".filterFields"] = array();
$tdatatbl_income[".requiredSearchFields"] = array();

$tdatatbl_income[".googleLikeFields"] = array();
$tdatatbl_income[".googleLikeFields"][] = "id";
$tdatatbl_income[".googleLikeFields"][] = "user_id";
$tdatatbl_income[".googleLikeFields"][] = "income_date";
$tdatatbl_income[".googleLikeFields"][] = "amount";
$tdatatbl_income[".googleLikeFields"][] = "category_id";
$tdatatbl_income[".googleLikeFields"][] = "description";
$tdatatbl_income[".googleLikeFields"][] = "receipt_path";
$tdatatbl_income[".googleLikeFields"][] = "original_currency";
$tdatatbl_income[".googleLikeFields"][] = "original_amount";
$tdatatbl_income[".googleLikeFields"][] = "exchange_rate";
$tdatatbl_income[".googleLikeFields"][] = "created_at";



$tdatatbl_income[".tableType"] = "list";

$tdatatbl_income[".printerPageOrientation"] = 0;
$tdatatbl_income[".nPrinterPageScale"] = 100;

$tdatatbl_income[".nPrinterSplitRecords"] = 40;

$tdatatbl_income[".geocodingEnabled"] = false;










$tdatatbl_income[".pageSize"] = 20;

$tdatatbl_income[".warnLeavingPages"] = true;



$tstrOrderBy = "";
$tdatatbl_income[".strOrderBy"] = $tstrOrderBy;

$tdatatbl_income[".orderindexes"] = array();


$tdatatbl_income[".sqlHead"] = "SELECT id,  	user_id,  	income_date,  	amount,  	category_id,  	description,  	receipt_path,  	original_currency,  	original_amount,  	exchange_rate,  	created_at";
$tdatatbl_income[".sqlFrom"] = "FROM tbl_income";
$tdatatbl_income[".sqlWhereExpr"] = "";
$tdatatbl_income[".sqlTail"] = "";










//fill array of records per page for list and report without group fields
$arrRPP = array();
$arrRPP[] = 10;
$arrRPP[] = 20;
$arrRPP[] = 30;
$arrRPP[] = 50;
$arrRPP[] = 100;
$arrRPP[] = 500;
$arrRPP[] = -1;
$tdatatbl_income[".arrRecsPerPage"] = $arrRPP;

//fill array of groups per page for report with group fields
$arrGPP = array();
$arrGPP[] = 1;
$arrGPP[] = 3;
$arrGPP[] = 5;
$arrGPP[] = 10;
$arrGPP[] = 50;
$arrGPP[] = 100;
$arrGPP[] = -1;
$tdatatbl_income[".arrGroupsPerPage"] = $arrGPP;

$tdatatbl_income[".highlightSearchResults"] = true;

$tableKeystbl_income = array();
$tableKeystbl_income[] = "id";
$tdatatbl_income[".Keys"] = $tableKeystbl_income;


$tdatatbl_income[".hideMobileList"] = array();




//	id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 1;
	$fdata["strName"] = "id";
	$fdata["GoodName"] = "id";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","id");
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


	$tdatatbl_income["id"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "id";
//	user_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 2;
	$fdata["strName"] = "user_id";
	$fdata["GoodName"] = "user_id";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","user_id");
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


	$tdatatbl_income["user_id"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "user_id";
//	income_date
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 3;
	$fdata["strName"] = "income_date";
	$fdata["GoodName"] = "income_date";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","income_date");
	$fdata["FieldType"] = 7;


	
	
										

		$fdata["strField"] = "income_date";

		$fdata["sourceSingle"] = "income_date";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "income_date";

	
	
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


	$tdatatbl_income["income_date"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "income_date";
//	amount
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 4;
	$fdata["strName"] = "amount";
	$fdata["GoodName"] = "amount";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","amount");
	$fdata["FieldType"] = 14;


	
	
										

		$fdata["strField"] = "amount";

		$fdata["sourceSingle"] = "amount";

	
		$fdata["isSQLExpression"] = true;
	$fdata["FullName"] = "amount";

	
	
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


	$tdatatbl_income["amount"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "amount";
//	category_id
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 5;
	$fdata["strName"] = "category_id";
	$fdata["GoodName"] = "category_id";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","category_id");
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


	$tdatatbl_income["category_id"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "category_id";
//	description
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 6;
	$fdata["strName"] = "description";
	$fdata["GoodName"] = "description";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","description");
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


	$tdatatbl_income["description"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "description";
//	receipt_path
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 7;
	$fdata["strName"] = "receipt_path";
	$fdata["GoodName"] = "receipt_path";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","receipt_path");
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


	$tdatatbl_income["receipt_path"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "receipt_path";
//	original_currency
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 8;
	$fdata["strName"] = "original_currency";
	$fdata["GoodName"] = "original_currency";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","original_currency");
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


	$tdatatbl_income["original_currency"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "original_currency";
//	original_amount
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 9;
	$fdata["strName"] = "original_amount";
	$fdata["GoodName"] = "original_amount";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","original_amount");
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


	$tdatatbl_income["original_amount"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "original_amount";
//	exchange_rate
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 10;
	$fdata["strName"] = "exchange_rate";
	$fdata["GoodName"] = "exchange_rate";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","exchange_rate");
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


	$tdatatbl_income["exchange_rate"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "exchange_rate";
//	created_at
//	Custom field settings
	$fdata = array();
	$fdata["Index"] = 11;
	$fdata["strName"] = "created_at";
	$fdata["GoodName"] = "created_at";
	$fdata["ownerTable"] = "tbl_income";
	$fdata["Label"] = GetFieldLabel("tbl_income","created_at");
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


	$tdatatbl_income["created_at"] = $fdata;
		$tdatatbl_income[".searchableFields"][] = "created_at";


$tables_data["tbl_income"]=&$tdatatbl_income;
$field_labels["tbl_income"] = &$fieldLabelstbl_income;
$fieldToolTips["tbl_income"] = &$fieldToolTipstbl_income;
$placeHolders["tbl_income"] = &$placeHolderstbl_income;
$page_titles["tbl_income"] = &$pageTitlestbl_income;


changeTextControlsToDate( "tbl_income" );

// -----------------start  prepare master-details data arrays ------------------------------//
// tables which are detail tables for current table (master)

//if !@TABLE.bReportCrossTab

$detailsTablesData["tbl_income"] = array();
//endif

// tables which are master tables for current table (detail)
$masterTablesData["tbl_income"] = array();



// -----------------end  prepare master-details data arrays ------------------------------//



require_once(getabspath("classes/sql.php"));











function createSqlQuery_tbl_income()
{
$proto0=array();
$proto0["m_strHead"] = "SELECT";
$proto0["m_strFieldList"] = "id,  	user_id,  	income_date,  	amount,  	category_id,  	description,  	receipt_path,  	original_currency,  	original_amount,  	exchange_rate,  	created_at";
$proto0["m_strFrom"] = "FROM tbl_income";
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
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto6["m_sql"] = "id";
$proto6["m_srcTableName"] = "tbl_income";
$proto6["m_expr"]=$obj;
$proto6["m_alias"] = "";
$obj = new SQLFieldListItem($proto6);

$proto0["m_fieldlist"][]=$obj;
						$proto8=array();
			$obj = new SQLField(array(
	"m_strName" => "user_id",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto8["m_sql"] = "user_id";
$proto8["m_srcTableName"] = "tbl_income";
$proto8["m_expr"]=$obj;
$proto8["m_alias"] = "";
$obj = new SQLFieldListItem($proto8);

$proto0["m_fieldlist"][]=$obj;
						$proto10=array();
			$obj = new SQLField(array(
	"m_strName" => "income_date",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto10["m_sql"] = "income_date";
$proto10["m_srcTableName"] = "tbl_income";
$proto10["m_expr"]=$obj;
$proto10["m_alias"] = "";
$obj = new SQLFieldListItem($proto10);

$proto0["m_fieldlist"][]=$obj;
						$proto12=array();
			$obj = new SQLField(array(
	"m_strName" => "amount",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto12["m_sql"] = "amount";
$proto12["m_srcTableName"] = "tbl_income";
$proto12["m_expr"]=$obj;
$proto12["m_alias"] = "";
$obj = new SQLFieldListItem($proto12);

$proto0["m_fieldlist"][]=$obj;
						$proto14=array();
			$obj = new SQLField(array(
	"m_strName" => "category_id",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto14["m_sql"] = "category_id";
$proto14["m_srcTableName"] = "tbl_income";
$proto14["m_expr"]=$obj;
$proto14["m_alias"] = "";
$obj = new SQLFieldListItem($proto14);

$proto0["m_fieldlist"][]=$obj;
						$proto16=array();
			$obj = new SQLField(array(
	"m_strName" => "description",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto16["m_sql"] = "description";
$proto16["m_srcTableName"] = "tbl_income";
$proto16["m_expr"]=$obj;
$proto16["m_alias"] = "";
$obj = new SQLFieldListItem($proto16);

$proto0["m_fieldlist"][]=$obj;
						$proto18=array();
			$obj = new SQLField(array(
	"m_strName" => "receipt_path",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto18["m_sql"] = "receipt_path";
$proto18["m_srcTableName"] = "tbl_income";
$proto18["m_expr"]=$obj;
$proto18["m_alias"] = "";
$obj = new SQLFieldListItem($proto18);

$proto0["m_fieldlist"][]=$obj;
						$proto20=array();
			$obj = new SQLField(array(
	"m_strName" => "original_currency",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto20["m_sql"] = "original_currency";
$proto20["m_srcTableName"] = "tbl_income";
$proto20["m_expr"]=$obj;
$proto20["m_alias"] = "";
$obj = new SQLFieldListItem($proto20);

$proto0["m_fieldlist"][]=$obj;
						$proto22=array();
			$obj = new SQLField(array(
	"m_strName" => "original_amount",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto22["m_sql"] = "original_amount";
$proto22["m_srcTableName"] = "tbl_income";
$proto22["m_expr"]=$obj;
$proto22["m_alias"] = "";
$obj = new SQLFieldListItem($proto22);

$proto0["m_fieldlist"][]=$obj;
						$proto24=array();
			$obj = new SQLField(array(
	"m_strName" => "exchange_rate",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto24["m_sql"] = "exchange_rate";
$proto24["m_srcTableName"] = "tbl_income";
$proto24["m_expr"]=$obj;
$proto24["m_alias"] = "";
$obj = new SQLFieldListItem($proto24);

$proto0["m_fieldlist"][]=$obj;
						$proto26=array();
			$obj = new SQLField(array(
	"m_strName" => "created_at",
	"m_strTable" => "tbl_income",
	"m_srcTableName" => "tbl_income"
));

$proto26["m_sql"] = "created_at";
$proto26["m_srcTableName"] = "tbl_income";
$proto26["m_expr"]=$obj;
$proto26["m_alias"] = "";
$obj = new SQLFieldListItem($proto26);

$proto0["m_fieldlist"][]=$obj;
$proto0["m_fromlist"] = array();
												$proto28=array();
$proto28["m_link"] = "SQLL_MAIN";
			$proto29=array();
$proto29["m_strName"] = "tbl_income";
$proto29["m_srcTableName"] = "tbl_income";
$proto29["m_columns"] = array();
$proto29["m_columns"][] = "id";
$proto29["m_columns"][] = "user_id";
$proto29["m_columns"][] = "income_date";
$proto29["m_columns"][] = "amount";
$proto29["m_columns"][] = "category_id";
$proto29["m_columns"][] = "description";
$proto29["m_columns"][] = "receipt_path";
$proto29["m_columns"][] = "original_currency";
$proto29["m_columns"][] = "original_amount";
$proto29["m_columns"][] = "exchange_rate";
$proto29["m_columns"][] = "created_at";
$obj = new SQLTable($proto29);

$proto28["m_table"] = $obj;
$proto28["m_sql"] = "tbl_income";
$proto28["m_alias"] = "";
$proto28["m_srcTableName"] = "tbl_income";
$proto30=array();
$proto30["m_sql"] = "";
$proto30["m_uniontype"] = "SQLL_UNKNOWN";
	$obj = new SQLNonParsed(array(
	"m_sql" => ""
));

$proto30["m_column"]=$obj;
$proto30["m_contained"] = array();
$proto30["m_strCase"] = "";
$proto30["m_havingmode"] = false;
$proto30["m_inBrackets"] = false;
$proto30["m_useAlias"] = false;
$obj = new SQLLogicalExpr($proto30);

$proto28["m_joinon"] = $obj;
$obj = new SQLFromListItem($proto28);

$proto0["m_fromlist"][]=$obj;
$proto0["m_groupby"] = array();
$proto0["m_orderby"] = array();
$proto0["m_srcTableName"]="tbl_income";		
$obj = new SQLQuery($proto0);

	return $obj;
}
$queryData_tbl_income = createSqlQuery_tbl_income();


	
					
;

											

$tdatatbl_income[".sqlquery"] = $queryData_tbl_income;



$tdatatbl_income[".hasEvents"] = false;

?>