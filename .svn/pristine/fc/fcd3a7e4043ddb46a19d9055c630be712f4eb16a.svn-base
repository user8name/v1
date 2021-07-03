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

$wp_products_view = NULL; // Initialize page object first

class cwp_products_view extends cwp_products {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{2ACFE866-F5EE-4BCB-8DD0-02E059CEE335}";

	// Table name
	var $TableName = 'wp_products';

	// Page object name
	var $PageObjName = 'wp_products_view';

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
		$KeyUrl = "";
		if (@$_GET["id"] <> "") {
			$this->RecKey["id"] = $_GET["id"];
			$KeyUrl .= "&amp;id=" . urlencode($this->RecKey["id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'wp_products', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
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

		// Create Token
		$this->CreateToken();
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["id"] <> "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->RecKey["id"] = $this->id->QueryStringValue;
			} elseif (@$_POST["id"] <> "") {
				$this->id->setFormValue($_POST["id"]);
				$this->RecKey["id"] = $this->id->FormValue;
			} else {
				$sReturnUrl = "wp_productslist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "wp_productslist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "wp_productslist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "");

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "");

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = TRUE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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
		if ($this->AuditTrailOnView) $this->WriteAuditTrailOnView($row);
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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

		// detail
		$this->detail->ViewValue = $this->detail->CurrentValue;
		$this->detail->ViewCustomAttributes = "";

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

		// seo_description
		$this->seo_description->ViewValue = $this->seo_description->CurrentValue;
		$this->seo_description->ViewCustomAttributes = "";

		// seo_url
		$this->seo_url->ViewValue = $this->seo_url->CurrentValue;
		$this->seo_url->ViewCustomAttributes = "";

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

			// detail
			$this->detail->LinkCustomAttributes = "";
			$this->detail->HrefValue = "";
			$this->detail->TooltipValue = "";

			// tag
			$this->tag->LinkCustomAttributes = "";
			$this->tag->HrefValue = "";
			$this->tag->TooltipValue = "";

			// sortnum
			$this->sortnum->LinkCustomAttributes = "";
			$this->sortnum->HrefValue = "";
			$this->sortnum->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// isdel
			$this->isdel->LinkCustomAttributes = "";
			$this->isdel->HrefValue = "";
			$this->isdel->TooltipValue = "";

			// seo_title
			$this->seo_title->LinkCustomAttributes = "";
			$this->seo_title->HrefValue = "";
			$this->seo_title->TooltipValue = "";

			// seo_keywords
			$this->seo_keywords->LinkCustomAttributes = "";
			$this->seo_keywords->HrefValue = "";
			$this->seo_keywords->TooltipValue = "";

			// seo_description
			$this->seo_description->LinkCustomAttributes = "";
			$this->seo_description->HrefValue = "";
			$this->seo_description->TooltipValue = "";

			// seo_url
			$this->seo_url->LinkCustomAttributes = "";
			$this->seo_url->HrefValue = "";
			$this->seo_url->TooltipValue = "";

			// itime
			$this->itime->LinkCustomAttributes = "";
			$this->itime->HrefValue = "";
			$this->itime->TooltipValue = "";

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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("wp_productslist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($wp_products_view)) $wp_products_view = new cwp_products_view();

// Page init
$wp_products_view->Page_Init();

// Page main
$wp_products_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$wp_products_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fwp_productsview = new ew_Form("fwp_productsview", "view");

// Form_CustomValidate event
fwp_productsview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwp_productsview.ValidateRequired = true;
<?php } else { ?>
fwp_productsview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fwp_productsview.Lists["x_cid"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_fullname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $wp_products_view->ExportOptions->Render("body") ?>
<?php
	foreach ($wp_products_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $wp_products_view->ShowPageHeader(); ?>
<?php
$wp_products_view->ShowMessage();
?>
<form name="fwp_productsview" id="fwp_productsview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($wp_products_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $wp_products_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="wp_products">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($wp_products->id->Visible) { // id ?>
	<tr id="r_id">
		<td><span id="elh_wp_products_id"><?php echo $wp_products->id->FldCaption() ?></span></td>
		<td data-name="id"<?php echo $wp_products->id->CellAttributes() ?>>
<span id="el_wp_products_id">
<span<?php echo $wp_products->id->ViewAttributes() ?>>
<?php echo $wp_products->id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->cid->Visible) { // cid ?>
	<tr id="r_cid">
		<td><span id="elh_wp_products_cid"><?php echo $wp_products->cid->FldCaption() ?></span></td>
		<td data-name="cid"<?php echo $wp_products->cid->CellAttributes() ?>>
<span id="el_wp_products_cid">
<span<?php echo $wp_products->cid->ViewAttributes() ?>>
<?php echo $wp_products->cid->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->cat->Visible) { // cat ?>
	<tr id="r_cat">
		<td><span id="elh_wp_products_cat"><?php echo $wp_products->cat->FldCaption() ?></span></td>
		<td data-name="cat"<?php echo $wp_products->cat->CellAttributes() ?>>
<span id="el_wp_products_cat">
<span<?php echo $wp_products->cat->ViewAttributes() ?>>
<?php echo $wp_products->cat->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->productname->Visible) { // productname ?>
	<tr id="r_productname">
		<td><span id="elh_wp_products_productname"><?php echo $wp_products->productname->FldCaption() ?></span></td>
		<td data-name="productname"<?php echo $wp_products->productname->CellAttributes() ?>>
<span id="el_wp_products_productname">
<span<?php echo $wp_products->productname->ViewAttributes() ?>>
<?php echo $wp_products->productname->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->particlesize->Visible) { // particlesize ?>
	<tr id="r_particlesize">
		<td><span id="elh_wp_products_particlesize"><?php echo $wp_products->particlesize->FldCaption() ?></span></td>
		<td data-name="particlesize"<?php echo $wp_products->particlesize->CellAttributes() ?>>
<span id="el_wp_products_particlesize">
<span<?php echo $wp_products->particlesize->ViewAttributes() ?>>
<?php echo $wp_products->particlesize->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->mw->Visible) { // mw ?>
	<tr id="r_mw">
		<td><span id="elh_wp_products_mw"><?php echo $wp_products->mw->FldCaption() ?></span></td>
		<td data-name="mw"<?php echo $wp_products->mw->CellAttributes() ?>>
<span id="el_wp_products_mw">
<span<?php echo $wp_products->mw->ViewAttributes() ?>>
<?php echo $wp_products->mw->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->description->Visible) { // description ?>
	<tr id="r_description">
		<td><span id="elh_wp_products_description"><?php echo $wp_products->description->FldCaption() ?></span></td>
		<td data-name="description"<?php echo $wp_products->description->CellAttributes() ?>>
<span id="el_wp_products_description">
<span<?php echo $wp_products->description->ViewAttributes() ?>>
<?php echo $wp_products->description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->detail->Visible) { // detail ?>
	<tr id="r_detail">
		<td><span id="elh_wp_products_detail"><?php echo $wp_products->detail->FldCaption() ?></span></td>
		<td data-name="detail"<?php echo $wp_products->detail->CellAttributes() ?>>
<span id="el_wp_products_detail">
<span<?php echo $wp_products->detail->ViewAttributes() ?>>
<?php echo $wp_products->detail->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->tag->Visible) { // tag ?>
	<tr id="r_tag">
		<td><span id="elh_wp_products_tag"><?php echo $wp_products->tag->FldCaption() ?></span></td>
		<td data-name="tag"<?php echo $wp_products->tag->CellAttributes() ?>>
<span id="el_wp_products_tag">
<span<?php echo $wp_products->tag->ViewAttributes() ?>>
<?php echo $wp_products->tag->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->sortnum->Visible) { // sortnum ?>
	<tr id="r_sortnum">
		<td><span id="elh_wp_products_sortnum"><?php echo $wp_products->sortnum->FldCaption() ?></span></td>
		<td data-name="sortnum"<?php echo $wp_products->sortnum->CellAttributes() ?>>
<span id="el_wp_products_sortnum">
<span<?php echo $wp_products->sortnum->ViewAttributes() ?>>
<?php echo $wp_products->sortnum->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->status->Visible) { // status ?>
	<tr id="r_status">
		<td><span id="elh_wp_products_status"><?php echo $wp_products->status->FldCaption() ?></span></td>
		<td data-name="status"<?php echo $wp_products->status->CellAttributes() ?>>
<span id="el_wp_products_status">
<span<?php echo $wp_products->status->ViewAttributes() ?>>
<?php echo $wp_products->status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->isdel->Visible) { // isdel ?>
	<tr id="r_isdel">
		<td><span id="elh_wp_products_isdel"><?php echo $wp_products->isdel->FldCaption() ?></span></td>
		<td data-name="isdel"<?php echo $wp_products->isdel->CellAttributes() ?>>
<span id="el_wp_products_isdel">
<span<?php echo $wp_products->isdel->ViewAttributes() ?>>
<?php echo $wp_products->isdel->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->seo_title->Visible) { // seo_title ?>
	<tr id="r_seo_title">
		<td><span id="elh_wp_products_seo_title"><?php echo $wp_products->seo_title->FldCaption() ?></span></td>
		<td data-name="seo_title"<?php echo $wp_products->seo_title->CellAttributes() ?>>
<span id="el_wp_products_seo_title">
<span<?php echo $wp_products->seo_title->ViewAttributes() ?>>
<?php echo $wp_products->seo_title->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->seo_keywords->Visible) { // seo_keywords ?>
	<tr id="r_seo_keywords">
		<td><span id="elh_wp_products_seo_keywords"><?php echo $wp_products->seo_keywords->FldCaption() ?></span></td>
		<td data-name="seo_keywords"<?php echo $wp_products->seo_keywords->CellAttributes() ?>>
<span id="el_wp_products_seo_keywords">
<span<?php echo $wp_products->seo_keywords->ViewAttributes() ?>>
<?php echo $wp_products->seo_keywords->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->seo_description->Visible) { // seo_description ?>
	<tr id="r_seo_description">
		<td><span id="elh_wp_products_seo_description"><?php echo $wp_products->seo_description->FldCaption() ?></span></td>
		<td data-name="seo_description"<?php echo $wp_products->seo_description->CellAttributes() ?>>
<span id="el_wp_products_seo_description">
<span<?php echo $wp_products->seo_description->ViewAttributes() ?>>
<?php echo $wp_products->seo_description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->seo_url->Visible) { // seo_url ?>
	<tr id="r_seo_url">
		<td><span id="elh_wp_products_seo_url"><?php echo $wp_products->seo_url->FldCaption() ?></span></td>
		<td data-name="seo_url"<?php echo $wp_products->seo_url->CellAttributes() ?>>
<span id="el_wp_products_seo_url">
<span<?php echo $wp_products->seo_url->ViewAttributes() ?>>
<?php echo $wp_products->seo_url->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->itime->Visible) { // itime ?>
	<tr id="r_itime">
		<td><span id="elh_wp_products_itime"><?php echo $wp_products->itime->FldCaption() ?></span></td>
		<td data-name="itime"<?php echo $wp_products->itime->CellAttributes() ?>>
<span id="el_wp_products_itime">
<span<?php echo $wp_products->itime->ViewAttributes() ?>>
<?php echo $wp_products->itime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($wp_products->utime->Visible) { // utime ?>
	<tr id="r_utime">
		<td><span id="elh_wp_products_utime"><?php echo $wp_products->utime->FldCaption() ?></span></td>
		<td data-name="utime"<?php echo $wp_products->utime->CellAttributes() ?>>
<span id="el_wp_products_utime">
<span<?php echo $wp_products->utime->ViewAttributes() ?>>
<?php echo $wp_products->utime->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fwp_productsview.Init();
</script>
<?php
$wp_products_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$wp_products_view->Page_Terminate();
?>
