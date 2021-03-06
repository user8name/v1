<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "wp_productsinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$wp_products_list = NULL; // Initialize page object first

class cwp_products_list extends cwp_products {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{2ACFE866-F5EE-4BCB-8DD0-02E059CEE335}";

	// Table name
	var $TableName = 'wp_products';

	// Page object name
	var $PageObjName = 'wp_products_list';

	// Grid form hidden field names
	var $FormName = 'fwp_productslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;
    var $AuditTrailOnAdd = FALSE;
    var $AuditTrailOnEdit = FALSE;
    var $AuditTrailOnDelete = FALSE;
    var $AuditTrailOnView = FALSE;
    var $AuditTrailOnViewData = FALSE;
    var $AuditTrailOnSearch = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (wp_products)
		if (!isset($GLOBALS["wp_products"]) || get_class($GLOBALS["wp_products"]) == "cwp_products") {
			$GLOBALS["wp_products"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["wp_products"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "wp_productsadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "wp_productsdelete.php";
		$this->MultiUpdateUrl = "wp_productsupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'wp_products', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fwp_productslistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		global $gbOldSkipHeaderFooter, $gbSkipHeaderFooter;
		$gbOldSkipHeaderFooter = $gbSkipHeaderFooter;
		$gbSkipHeaderFooter = TRUE;
		$this->id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;
		global $gbOldSkipHeaderFooter, $gbSkipHeaderFooter;
		$gbSkipHeaderFooter = $gbOldSkipHeaderFooter;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $wp_products;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($wp_products);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetUpDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore filter list
			$this->RestoreFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetUpDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->id->AdvancedSearch->ToJSON(), ","); // Field id
		$sFilterList = ew_Concat($sFilterList, $this->cid->AdvancedSearch->ToJSON(), ","); // Field cid
		$sFilterList = ew_Concat($sFilterList, $this->cat->AdvancedSearch->ToJSON(), ","); // Field cat
		$sFilterList = ew_Concat($sFilterList, $this->productname->AdvancedSearch->ToJSON(), ","); // Field productname
		$sFilterList = ew_Concat($sFilterList, $this->particlesize->AdvancedSearch->ToJSON(), ","); // Field particlesize
		$sFilterList = ew_Concat($sFilterList, $this->mw->AdvancedSearch->ToJSON(), ","); // Field mw
		$sFilterList = ew_Concat($sFilterList, $this->description->AdvancedSearch->ToJSON(), ","); // Field description
		$sFilterList = ew_Concat($sFilterList, $this->detail->AdvancedSearch->ToJSON(), ","); // Field detail
		$sFilterList = ew_Concat($sFilterList, $this->tag->AdvancedSearch->ToJSON(), ","); // Field tag
		$sFilterList = ew_Concat($sFilterList, $this->sortnum->AdvancedSearch->ToJSON(), ","); // Field sortnum
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJSON(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->isdel->AdvancedSearch->ToJSON(), ","); // Field isdel
		$sFilterList = ew_Concat($sFilterList, $this->seo_title->AdvancedSearch->ToJSON(), ","); // Field seo_title
		$sFilterList = ew_Concat($sFilterList, $this->seo_keywords->AdvancedSearch->ToJSON(), ","); // Field seo_keywords
		$sFilterList = ew_Concat($sFilterList, $this->seo_description->AdvancedSearch->ToJSON(), ","); // Field seo_description
		$sFilterList = ew_Concat($sFilterList, $this->seo_url->AdvancedSearch->ToJSON(), ","); // Field seo_url
		$sFilterList = ew_Concat($sFilterList, $this->itime->AdvancedSearch->ToJSON(), ","); // Field itime
		$sFilterList = ew_Concat($sFilterList, $this->utime->AdvancedSearch->ToJSON(), ","); // Field utime
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field id
		$this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
		$this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
		$this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
		$this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
		$this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
		$this->id->AdvancedSearch->Save();

		// Field cid
		$this->cid->AdvancedSearch->SearchValue = @$filter["x_cid"];
		$this->cid->AdvancedSearch->SearchOperator = @$filter["z_cid"];
		$this->cid->AdvancedSearch->SearchCondition = @$filter["v_cid"];
		$this->cid->AdvancedSearch->SearchValue2 = @$filter["y_cid"];
		$this->cid->AdvancedSearch->SearchOperator2 = @$filter["w_cid"];
		$this->cid->AdvancedSearch->Save();

		// Field cat
		$this->cat->AdvancedSearch->SearchValue = @$filter["x_cat"];
		$this->cat->AdvancedSearch->SearchOperator = @$filter["z_cat"];
		$this->cat->AdvancedSearch->SearchCondition = @$filter["v_cat"];
		$this->cat->AdvancedSearch->SearchValue2 = @$filter["y_cat"];
		$this->cat->AdvancedSearch->SearchOperator2 = @$filter["w_cat"];
		$this->cat->AdvancedSearch->Save();

		// Field productname
		$this->productname->AdvancedSearch->SearchValue = @$filter["x_productname"];
		$this->productname->AdvancedSearch->SearchOperator = @$filter["z_productname"];
		$this->productname->AdvancedSearch->SearchCondition = @$filter["v_productname"];
		$this->productname->AdvancedSearch->SearchValue2 = @$filter["y_productname"];
		$this->productname->AdvancedSearch->SearchOperator2 = @$filter["w_productname"];
		$this->productname->AdvancedSearch->Save();

		// Field particlesize
		$this->particlesize->AdvancedSearch->SearchValue = @$filter["x_particlesize"];
		$this->particlesize->AdvancedSearch->SearchOperator = @$filter["z_particlesize"];
		$this->particlesize->AdvancedSearch->SearchCondition = @$filter["v_particlesize"];
		$this->particlesize->AdvancedSearch->SearchValue2 = @$filter["y_particlesize"];
		$this->particlesize->AdvancedSearch->SearchOperator2 = @$filter["w_particlesize"];
		$this->particlesize->AdvancedSearch->Save();

		// Field mw
		$this->mw->AdvancedSearch->SearchValue = @$filter["x_mw"];
		$this->mw->AdvancedSearch->SearchOperator = @$filter["z_mw"];
		$this->mw->AdvancedSearch->SearchCondition = @$filter["v_mw"];
		$this->mw->AdvancedSearch->SearchValue2 = @$filter["y_mw"];
		$this->mw->AdvancedSearch->SearchOperator2 = @$filter["w_mw"];
		$this->mw->AdvancedSearch->Save();

		// Field description
		$this->description->AdvancedSearch->SearchValue = @$filter["x_description"];
		$this->description->AdvancedSearch->SearchOperator = @$filter["z_description"];
		$this->description->AdvancedSearch->SearchCondition = @$filter["v_description"];
		$this->description->AdvancedSearch->SearchValue2 = @$filter["y_description"];
		$this->description->AdvancedSearch->SearchOperator2 = @$filter["w_description"];
		$this->description->AdvancedSearch->Save();

		// Field detail
		$this->detail->AdvancedSearch->SearchValue = @$filter["x_detail"];
		$this->detail->AdvancedSearch->SearchOperator = @$filter["z_detail"];
		$this->detail->AdvancedSearch->SearchCondition = @$filter["v_detail"];
		$this->detail->AdvancedSearch->SearchValue2 = @$filter["y_detail"];
		$this->detail->AdvancedSearch->SearchOperator2 = @$filter["w_detail"];
		$this->detail->AdvancedSearch->Save();

		// Field tag
		$this->tag->AdvancedSearch->SearchValue = @$filter["x_tag"];
		$this->tag->AdvancedSearch->SearchOperator = @$filter["z_tag"];
		$this->tag->AdvancedSearch->SearchCondition = @$filter["v_tag"];
		$this->tag->AdvancedSearch->SearchValue2 = @$filter["y_tag"];
		$this->tag->AdvancedSearch->SearchOperator2 = @$filter["w_tag"];
		$this->tag->AdvancedSearch->Save();

		// Field sortnum
		$this->sortnum->AdvancedSearch->SearchValue = @$filter["x_sortnum"];
		$this->sortnum->AdvancedSearch->SearchOperator = @$filter["z_sortnum"];
		$this->sortnum->AdvancedSearch->SearchCondition = @$filter["v_sortnum"];
		$this->sortnum->AdvancedSearch->SearchValue2 = @$filter["y_sortnum"];
		$this->sortnum->AdvancedSearch->SearchOperator2 = @$filter["w_sortnum"];
		$this->sortnum->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();

		// Field isdel
		$this->isdel->AdvancedSearch->SearchValue = @$filter["x_isdel"];
		$this->isdel->AdvancedSearch->SearchOperator = @$filter["z_isdel"];
		$this->isdel->AdvancedSearch->SearchCondition = @$filter["v_isdel"];
		$this->isdel->AdvancedSearch->SearchValue2 = @$filter["y_isdel"];
		$this->isdel->AdvancedSearch->SearchOperator2 = @$filter["w_isdel"];
		$this->isdel->AdvancedSearch->Save();

		// Field seo_title
		$this->seo_title->AdvancedSearch->SearchValue = @$filter["x_seo_title"];
		$this->seo_title->AdvancedSearch->SearchOperator = @$filter["z_seo_title"];
		$this->seo_title->AdvancedSearch->SearchCondition = @$filter["v_seo_title"];
		$this->seo_title->AdvancedSearch->SearchValue2 = @$filter["y_seo_title"];
		$this->seo_title->AdvancedSearch->SearchOperator2 = @$filter["w_seo_title"];
		$this->seo_title->AdvancedSearch->Save();

		// Field seo_keywords
		$this->seo_keywords->AdvancedSearch->SearchValue = @$filter["x_seo_keywords"];
		$this->seo_keywords->AdvancedSearch->SearchOperator = @$filter["z_seo_keywords"];
		$this->seo_keywords->AdvancedSearch->SearchCondition = @$filter["v_seo_keywords"];
		$this->seo_keywords->AdvancedSearch->SearchValue2 = @$filter["y_seo_keywords"];
		$this->seo_keywords->AdvancedSearch->SearchOperator2 = @$filter["w_seo_keywords"];
		$this->seo_keywords->AdvancedSearch->Save();

		// Field seo_description
		$this->seo_description->AdvancedSearch->SearchValue = @$filter["x_seo_description"];
		$this->seo_description->AdvancedSearch->SearchOperator = @$filter["z_seo_description"];
		$this->seo_description->AdvancedSearch->SearchCondition = @$filter["v_seo_description"];
		$this->seo_description->AdvancedSearch->SearchValue2 = @$filter["y_seo_description"];
		$this->seo_description->AdvancedSearch->SearchOperator2 = @$filter["w_seo_description"];
		$this->seo_description->AdvancedSearch->Save();

		// Field seo_url
		$this->seo_url->AdvancedSearch->SearchValue = @$filter["x_seo_url"];
		$this->seo_url->AdvancedSearch->SearchOperator = @$filter["z_seo_url"];
		$this->seo_url->AdvancedSearch->SearchCondition = @$filter["v_seo_url"];
		$this->seo_url->AdvancedSearch->SearchValue2 = @$filter["y_seo_url"];
		$this->seo_url->AdvancedSearch->SearchOperator2 = @$filter["w_seo_url"];
		$this->seo_url->AdvancedSearch->Save();

		// Field itime
		$this->itime->AdvancedSearch->SearchValue = @$filter["x_itime"];
		$this->itime->AdvancedSearch->SearchOperator = @$filter["z_itime"];
		$this->itime->AdvancedSearch->SearchCondition = @$filter["v_itime"];
		$this->itime->AdvancedSearch->SearchValue2 = @$filter["y_itime"];
		$this->itime->AdvancedSearch->SearchOperator2 = @$filter["w_itime"];
		$this->itime->AdvancedSearch->Save();

		// Field utime
		$this->utime->AdvancedSearch->SearchValue = @$filter["x_utime"];
		$this->utime->AdvancedSearch->SearchOperator = @$filter["z_utime"];
		$this->utime->AdvancedSearch->SearchCondition = @$filter["v_utime"];
		$this->utime->AdvancedSearch->SearchValue2 = @$filter["y_utime"];
		$this->utime->AdvancedSearch->SearchOperator2 = @$filter["w_utime"];
		$this->utime->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->cat, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->productname, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->particlesize, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->mw, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->tag, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->id); // id
			$this->UpdateSort($this->cid); // cid
			$this->UpdateSort($this->cat); // cat
			$this->UpdateSort($this->productname); // productname
			$this->UpdateSort($this->particlesize); // particlesize
			$this->UpdateSort($this->mw); // mw
			$this->UpdateSort($this->description); // description
			$this->UpdateSort($this->isdel); // isdel
			$this->UpdateSort($this->utime); // utime
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->id->setSort("");
				$this->cid->setSort("");
				$this->cat->setSort("");
				$this->productname->setSort("");
				$this->particlesize->setSort("");
				$this->mw->setSort("");
				$this->description->setSort("");
				$this->isdel->setSort("");
				$this->utime->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if (TRUE)
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt) {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->id->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fwp_productslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fwp_productslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fwp_productslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fwp_productslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->cid->setDbValue($rs->fields('cid'));
		$this->cat->setDbValue($rs->fields('cat'));
		$this->productname->setDbValue($rs->fields('productname'));
		$this->particlesize->setDbValue($rs->fields('particlesize'));
		$this->mw->setDbValue($rs->fields('mw'));
		$this->description->setDbValue($rs->fields('description'));
		$this->detail->setDbValue($rs->fields('detail'));
		$this->tag->setDbValue($rs->fields('tag'));
		$this->sortnum->setDbValue($rs->fields('sortnum'));
		$this->status->setDbValue($rs->fields('status'));
		$this->isdel->setDbValue($rs->fields('isdel'));
		$this->seo_title->setDbValue($rs->fields('seo_title'));
		$this->seo_keywords->setDbValue($rs->fields('seo_keywords'));
		$this->seo_description->setDbValue($rs->fields('seo_description'));
		$this->seo_url->setDbValue($rs->fields('seo_url'));
		$this->itime->setDbValue($rs->fields('itime'));
		$this->utime->setDbValue($rs->fields('utime'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->cid->DbValue = $row['cid'];
		$this->cat->DbValue = $row['cat'];
		$this->productname->DbValue = $row['productname'];
		$this->particlesize->DbValue = $row['particlesize'];
		$this->mw->DbValue = $row['mw'];
		$this->description->DbValue = $row['description'];
		$this->detail->DbValue = $row['detail'];
		$this->tag->DbValue = $row['tag'];
		$this->sortnum->DbValue = $row['sortnum'];
		$this->status->DbValue = $row['status'];
		$this->isdel->DbValue = $row['isdel'];
		$this->seo_title->DbValue = $row['seo_title'];
		$this->seo_keywords->DbValue = $row['seo_keywords'];
		$this->seo_description->DbValue = $row['seo_description'];
		$this->seo_url->DbValue = $row['seo_url'];
		$this->itime->DbValue = $row['itime'];
		$this->utime->DbValue = $row['utime'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// cid
		// cat
		// productname
		// particlesize
		// mw
		// description
		// detail
		// tag
		// sortnum
		// status
		// isdel
		// seo_title
		// seo_keywords
		// seo_description
		// seo_url
		// itime
		// utime

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// id
		$this->id->ViewValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// cid
		if (strval($this->cid->CurrentValue) <> "") {
			$sFilterWrk = "`id`" . ew_SearchString("=", $this->cid->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `id`, `fullname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `wp_products_categories`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->cid, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `sno` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->cid->ViewValue = $this->cid->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->cid->ViewValue = $this->cid->CurrentValue;
			}
		} else {
			$this->cid->ViewValue = NULL;
		}
		$this->cid->ViewCustomAttributes = "";

		// cat
		$this->cat->ViewValue = $this->cat->CurrentValue;
		$this->cat->ViewCustomAttributes = "";

		// productname
		$this->productname->ViewValue = $this->productname->CurrentValue;
		$this->productname->ViewCustomAttributes = "";

		// particlesize
		$this->particlesize->ViewValue = $this->particlesize->CurrentValue;
		$this->particlesize->ViewCustomAttributes = "";

		// mw
		$this->mw->ViewValue = $this->mw->CurrentValue;
		$this->mw->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// tag
		$this->tag->ViewValue = $this->tag->CurrentValue;
		$this->tag->ViewCustomAttributes = "";

		// sortnum
		$this->sortnum->ViewValue = $this->sortnum->CurrentValue;
		$this->sortnum->ViewCustomAttributes = "";

		// status
		$this->status->ViewValue = $this->status->CurrentValue;
		$this->status->ViewCustomAttributes = "";

		// isdel
		$this->isdel->ViewValue = $this->isdel->CurrentValue;
		$this->isdel->ViewCustomAttributes = "";

		// seo_title
		$this->seo_title->ViewValue = $this->seo_title->CurrentValue;
		$this->seo_title->ViewCustomAttributes = "";

		// seo_keywords
		$this->seo_keywords->ViewValue = $this->seo_keywords->CurrentValue;
		$this->seo_keywords->ViewCustomAttributes = "";

		// itime
		$this->itime->ViewValue = $this->itime->CurrentValue;
		$this->itime->ViewCustomAttributes = "";

		// utime
		$this->utime->ViewValue = $this->utime->CurrentValue;
		$this->utime->ViewCustomAttributes = "";

			// id
			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";
			$this->id->TooltipValue = "";

			// cid
			$this->cid->LinkCustomAttributes = "";
			$this->cid->HrefValue = "";
			$this->cid->TooltipValue = "";

			// cat
			$this->cat->LinkCustomAttributes = "";
			$this->cat->HrefValue = "";
			$this->cat->TooltipValue = "";

			// productname
			$this->productname->LinkCustomAttributes = "";
			$this->productname->HrefValue = "";
			$this->productname->TooltipValue = "";

			// particlesize
			$this->particlesize->LinkCustomAttributes = "";
			$this->particlesize->HrefValue = "";
			$this->particlesize->TooltipValue = "";

			// mw
			$this->mw->LinkCustomAttributes = "";
			$this->mw->HrefValue = "";
			$this->mw->TooltipValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// isdel
			$this->isdel->LinkCustomAttributes = "";
			$this->isdel->HrefValue = "";
			$this->isdel->TooltipValue = "";

			// utime
			$this->utime->LinkCustomAttributes = "";
			$this->utime->HrefValue = "";
			$this->utime->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'wp_products';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($wp_products_list)) $wp_products_list = new cwp_products_list();

// Page init
$wp_products_list->Page_Init();

// Page main
$wp_products_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$wp_products_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fwp_productslist = new ew_Form("fwp_productslist", "list");
fwp_productslist.FormKeyCountName = '<?php echo $wp_products_list->FormKeyCountName ?>';

// Form_CustomValidate event
fwp_productslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwp_productslist.ValidateRequired = true;
<?php } else { ?>
fwp_productslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fwp_productslist.Lists["x_cid"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_fullname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
var CurrentSearchForm = fwp_productslistsrch = new ew_Form("fwp_productslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($wp_products_list->ExportOptions->Visible()) { ?>
<?php $wp_products_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($wp_products_list->SearchOptions->Visible()) { ?>
<?php $wp_products_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($wp_products_list->FilterOptions->Visible()) { ?>
<?php $wp_products_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $wp_products_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($wp_products_list->TotalRecs <= 0)
			$wp_products_list->TotalRecs = $wp_products->SelectRecordCount();
	} else {
		if (!$wp_products_list->Recordset && ($wp_products_list->Recordset = $wp_products_list->LoadRecordset()))
			$wp_products_list->TotalRecs = $wp_products_list->Recordset->RecordCount();
	}
	$wp_products_list->StartRec = 1;
	if ($wp_products_list->DisplayRecs <= 0 || ($wp_products->Export <> "" && $wp_products->ExportAll)) // Display all records
		$wp_products_list->DisplayRecs = $wp_products_list->TotalRecs;
	if (!($wp_products->Export <> "" && $wp_products->ExportAll))
		$wp_products_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$wp_products_list->Recordset = $wp_products_list->LoadRecordset($wp_products_list->StartRec-1, $wp_products_list->DisplayRecs);

	// Set no record found message
	if ($wp_products->CurrentAction == "" && $wp_products_list->TotalRecs == 0) {
		if ($wp_products_list->SearchWhere == "0=101")
			$wp_products_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$wp_products_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($wp_products_list->AuditTrailOnSearch && $wp_products_list->Command == "search" && !$wp_products_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $wp_products_list->getSessionWhere();
		$wp_products_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
$wp_products_list->RenderOtherOptions();
?>
<?php if ($wp_products->Export == "" && $wp_products->CurrentAction == "") { ?>
<form name="fwp_productslistsrch" id="fwp_productslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($wp_products_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fwp_productslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="wp_products">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($wp_products_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($wp_products_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $wp_products_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($wp_products_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($wp_products_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($wp_products_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($wp_products_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $wp_products_list->ShowPageHeader(); ?>
<?php
$wp_products_list->ShowMessage();
?>
<?php if ($wp_products_list->TotalRecs > 0 || $wp_products->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div class="panel-heading ewGridUpperPanel">
<?php if ($wp_products->CurrentAction <> "gridadd" && $wp_products->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($wp_products_list->Pager)) $wp_products_list->Pager = new cPrevNextPager($wp_products_list->StartRec, $wp_products_list->DisplayRecs, $wp_products_list->TotalRecs) ?>
<?php if ($wp_products_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($wp_products_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($wp_products_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $wp_products_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($wp_products_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($wp_products_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $wp_products_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $wp_products_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $wp_products_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $wp_products_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($wp_products_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="wp_products">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="10"<?php if ($wp_products_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($wp_products_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($wp_products_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($wp_products_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($wp_products_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($wp_products_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($wp_products_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fwp_productslist" id="fwp_productslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($wp_products_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $wp_products_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="wp_products">
<div id="gmp_wp_products" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($wp_products_list->TotalRecs > 0) { ?>
<table id="tbl_wp_productslist" class="table ewTable">
<?php echo $wp_products->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$wp_products_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$wp_products_list->RenderListOptions();

// Render list options (header, left)
$wp_products_list->ListOptions->Render("header", "left");
?>
<?php if ($wp_products->id->Visible) { // id ?>
	<?php if ($wp_products->SortUrl($wp_products->id) == "") { ?>
		<th data-name="id"><div id="elh_wp_products_id" class="wp_products_id"><div class="ewTableHeaderCaption"><?php echo $wp_products->id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="id"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->id) ?>',1);"><div id="elh_wp_products_id" class="wp_products_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->cid->Visible) { // cid ?>
	<?php if ($wp_products->SortUrl($wp_products->cid) == "") { ?>
		<th data-name="cid"><div id="elh_wp_products_cid" class="wp_products_cid"><div class="ewTableHeaderCaption"><?php echo $wp_products->cid->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cid"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->cid) ?>',1);"><div id="elh_wp_products_cid" class="wp_products_cid">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->cid->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->cid->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->cid->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->cat->Visible) { // cat ?>
	<?php if ($wp_products->SortUrl($wp_products->cat) == "") { ?>
		<th data-name="cat"><div id="elh_wp_products_cat" class="wp_products_cat"><div class="ewTableHeaderCaption"><?php echo $wp_products->cat->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cat"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->cat) ?>',1);"><div id="elh_wp_products_cat" class="wp_products_cat">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->cat->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->cat->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->cat->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->productname->Visible) { // productname ?>
	<?php if ($wp_products->SortUrl($wp_products->productname) == "") { ?>
		<th data-name="productname"><div id="elh_wp_products_productname" class="wp_products_productname"><div class="ewTableHeaderCaption"><?php echo $wp_products->productname->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="productname"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->productname) ?>',1);"><div id="elh_wp_products_productname" class="wp_products_productname">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->productname->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->productname->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->productname->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->particlesize->Visible) { // particlesize ?>
	<?php if ($wp_products->SortUrl($wp_products->particlesize) == "") { ?>
		<th data-name="particlesize"><div id="elh_wp_products_particlesize" class="wp_products_particlesize"><div class="ewTableHeaderCaption"><?php echo $wp_products->particlesize->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="particlesize"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->particlesize) ?>',1);"><div id="elh_wp_products_particlesize" class="wp_products_particlesize">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->particlesize->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->particlesize->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->particlesize->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->mw->Visible) { // mw ?>
	<?php if ($wp_products->SortUrl($wp_products->mw) == "") { ?>
		<th data-name="mw"><div id="elh_wp_products_mw" class="wp_products_mw"><div class="ewTableHeaderCaption"><?php echo $wp_products->mw->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mw"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->mw) ?>',1);"><div id="elh_wp_products_mw" class="wp_products_mw">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->mw->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->mw->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->mw->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->description->Visible) { // description ?>
	<?php if ($wp_products->SortUrl($wp_products->description) == "") { ?>
		<th data-name="description"><div id="elh_wp_products_description" class="wp_products_description"><div class="ewTableHeaderCaption"><?php echo $wp_products->description->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="description"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->description) ?>',1);"><div id="elh_wp_products_description" class="wp_products_description">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->description->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->description->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->description->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->isdel->Visible) { // isdel ?>
	<?php if ($wp_products->SortUrl($wp_products->isdel) == "") { ?>
		<th data-name="isdel"><div id="elh_wp_products_isdel" class="wp_products_isdel"><div class="ewTableHeaderCaption"><?php echo $wp_products->isdel->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="isdel"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->isdel) ?>',1);"><div id="elh_wp_products_isdel" class="wp_products_isdel">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->isdel->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->isdel->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->isdel->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($wp_products->utime->Visible) { // utime ?>
	<?php if ($wp_products->SortUrl($wp_products->utime) == "") { ?>
		<th data-name="utime"><div id="elh_wp_products_utime" class="wp_products_utime"><div class="ewTableHeaderCaption"><?php echo $wp_products->utime->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="utime"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $wp_products->SortUrl($wp_products->utime) ?>',1);"><div id="elh_wp_products_utime" class="wp_products_utime">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $wp_products->utime->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($wp_products->utime->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($wp_products->utime->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$wp_products_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($wp_products->ExportAll && $wp_products->Export <> "") {
	$wp_products_list->StopRec = $wp_products_list->TotalRecs;
} else {

	// Set the last record to display
	if ($wp_products_list->TotalRecs > $wp_products_list->StartRec + $wp_products_list->DisplayRecs - 1)
		$wp_products_list->StopRec = $wp_products_list->StartRec + $wp_products_list->DisplayRecs - 1;
	else
		$wp_products_list->StopRec = $wp_products_list->TotalRecs;
}
$wp_products_list->RecCnt = $wp_products_list->StartRec - 1;
if ($wp_products_list->Recordset && !$wp_products_list->Recordset->EOF) {
	$wp_products_list->Recordset->MoveFirst();
	$bSelectLimit = $wp_products_list->UseSelectLimit;
	if (!$bSelectLimit && $wp_products_list->StartRec > 1)
		$wp_products_list->Recordset->Move($wp_products_list->StartRec - 1);
} elseif (!$wp_products->AllowAddDeleteRow && $wp_products_list->StopRec == 0) {
	$wp_products_list->StopRec = $wp_products->GridAddRowCount;
}

// Initialize aggregate
$wp_products->RowType = EW_ROWTYPE_AGGREGATEINIT;
$wp_products->ResetAttrs();
$wp_products_list->RenderRow();
while ($wp_products_list->RecCnt < $wp_products_list->StopRec) {
	$wp_products_list->RecCnt++;
	if (intval($wp_products_list->RecCnt) >= intval($wp_products_list->StartRec)) {
		$wp_products_list->RowCnt++;

		// Set up key count
		$wp_products_list->KeyCount = $wp_products_list->RowIndex;

		// Init row class and style
		$wp_products->ResetAttrs();
		$wp_products->CssClass = "";
		if ($wp_products->CurrentAction == "gridadd") {
		} else {
			$wp_products_list->LoadRowValues($wp_products_list->Recordset); // Load row values
		}
		$wp_products->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$wp_products->RowAttrs = array_merge($wp_products->RowAttrs, array('data-rowindex'=>$wp_products_list->RowCnt, 'id'=>'r' . $wp_products_list->RowCnt . '_wp_products', 'data-rowtype'=>$wp_products->RowType));

		// Render row
		$wp_products_list->RenderRow();

		// Render list options
		$wp_products_list->RenderListOptions();
?>
	<tr<?php echo $wp_products->RowAttributes() ?>>
<?php

// Render list options (body, left)
$wp_products_list->ListOptions->Render("body", "left", $wp_products_list->RowCnt);
?>
	<?php if ($wp_products->id->Visible) { // id ?>
		<td data-name="id"<?php echo $wp_products->id->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_id" class="wp_products_id">
<span<?php echo $wp_products->id->ViewAttributes() ?>>
<?php echo $wp_products->id->ListViewValue() ?></span>
</span>
<a id="<?php echo $wp_products_list->PageObjName . "_row_" . $wp_products_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($wp_products->cid->Visible) { // cid ?>
		<td data-name="cid"<?php echo $wp_products->cid->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_cid" class="wp_products_cid">
<span<?php echo $wp_products->cid->ViewAttributes() ?>>
<?php echo $wp_products->cid->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($wp_products->cat->Visible) { // cat ?>
		<td data-name="cat"<?php echo $wp_products->cat->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_cat" class="wp_products_cat">
<span<?php echo $wp_products->cat->ViewAttributes() ?>>
<?php echo $wp_products->cat->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($wp_products->productname->Visible) { // productname ?>
		<td data-name="productname"<?php echo $wp_products->productname->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_productname" class="wp_products_productname">
<span<?php echo $wp_products->productname->ViewAttributes() ?>>
<?php echo $wp_products->productname->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($wp_products->particlesize->Visible) { // particlesize ?>
		<td data-name="particlesize"<?php echo $wp_products->particlesize->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_particlesize" class="wp_products_particlesize">
<span<?php echo $wp_products->particlesize->ViewAttributes() ?>>
<?php echo $wp_products->particlesize->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($wp_products->mw->Visible) { // mw ?>
		<td data-name="mw"<?php echo $wp_products->mw->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_mw" class="wp_products_mw">
<span<?php echo $wp_products->mw->ViewAttributes() ?>>
<?php echo $wp_products->mw->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($wp_products->description->Visible) { // description ?>
		<td data-name="description"<?php echo $wp_products->description->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_description" class="wp_products_description">
<span<?php echo $wp_products->description->ViewAttributes() ?>>
<?php echo $wp_products->description->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($wp_products->isdel->Visible) { // isdel ?>
		<td data-name="isdel"<?php echo $wp_products->isdel->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_isdel" class="wp_products_isdel">
<span<?php echo $wp_products->isdel->ViewAttributes() ?>>
<?php echo $wp_products->isdel->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($wp_products->utime->Visible) { // utime ?>
		<td data-name="utime"<?php echo $wp_products->utime->CellAttributes() ?>>
<span id="el<?php echo $wp_products_list->RowCnt ?>_wp_products_utime" class="wp_products_utime">
<span<?php echo $wp_products->utime->ViewAttributes() ?>>
<?php echo $wp_products->utime->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$wp_products_list->ListOptions->Render("body", "right", $wp_products_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($wp_products->CurrentAction <> "gridadd")
		$wp_products_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($wp_products->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($wp_products_list->Recordset)
	$wp_products_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($wp_products->CurrentAction <> "gridadd" && $wp_products->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($wp_products_list->Pager)) $wp_products_list->Pager = new cPrevNextPager($wp_products_list->StartRec, $wp_products_list->DisplayRecs, $wp_products_list->TotalRecs) ?>
<?php if ($wp_products_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($wp_products_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($wp_products_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $wp_products_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($wp_products_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($wp_products_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $wp_products_list->PageUrl() ?>start=<?php echo $wp_products_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $wp_products_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $wp_products_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $wp_products_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $wp_products_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($wp_products_list->TotalRecs > 0) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="wp_products">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm" onchange="this.form.submit();">
<option value="10"<?php if ($wp_products_list->DisplayRecs == 10) { ?> selected="selected"<?php } ?>>10</option>
<option value="20"<?php if ($wp_products_list->DisplayRecs == 20) { ?> selected="selected"<?php } ?>>20</option>
<option value="50"<?php if ($wp_products_list->DisplayRecs == 50) { ?> selected="selected"<?php } ?>>50</option>
<option value="100"<?php if ($wp_products_list->DisplayRecs == 100) { ?> selected="selected"<?php } ?>>100</option>
<option value="200"<?php if ($wp_products_list->DisplayRecs == 200) { ?> selected="selected"<?php } ?>>200</option>
<option value="500"<?php if ($wp_products_list->DisplayRecs == 500) { ?> selected="selected"<?php } ?>>500</option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($wp_products_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($wp_products_list->TotalRecs == 0 && $wp_products->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($wp_products_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fwp_productslistsrch.Init();
fwp_productslistsrch.FilterList = <?php echo $wp_products_list->GetFilterList() ?>;
fwp_productslist.Init();
</script>
<?php
$wp_products_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$wp_products_list->Page_Terminate();
?>
