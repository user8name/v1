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

$wp_products_edit = NULL; // Initialize page object first

class cwp_products_edit extends cwp_products {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{2ACFE866-F5EE-4BCB-8DD0-02E059CEE335}";

	// Table name
	var $TableName = 'wp_products';

	// Page object name
	var $PageObjName = 'wp_products_edit';

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
    var $AuditTrailOnAdd = FALSE;
    var $AuditTrailOnEdit = TRUE;
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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'wp_products', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["id"] <> "") {
			$this->id->setQueryStringValue($_GET["id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->id->CurrentValue == "")
			$this->Page_Terminate("wp_productslist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("wp_productslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "wp_productslist.php")
					$sReturnUrl = $this->AddMasterUrl($this->GetListUrl()); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->id->FldIsDetailKey)
			$this->id->setFormValue($objForm->GetValue("x_id"));
		if (!$this->cid->FldIsDetailKey) {
			$this->cid->setFormValue($objForm->GetValue("x_cid"));
		}
		if (!$this->cat->FldIsDetailKey) {
			$this->cat->setFormValue($objForm->GetValue("x_cat"));
		}
		if (!$this->productname->FldIsDetailKey) {
			$this->productname->setFormValue($objForm->GetValue("x_productname"));
		}
		if (!$this->particlesize->FldIsDetailKey) {
			$this->particlesize->setFormValue($objForm->GetValue("x_particlesize"));
		}
		if (!$this->mw->FldIsDetailKey) {
			$this->mw->setFormValue($objForm->GetValue("x_mw"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->detail->FldIsDetailKey) {
			$this->detail->setFormValue($objForm->GetValue("x_detail"));
		}
		if (!$this->tag->FldIsDetailKey) {
			$this->tag->setFormValue($objForm->GetValue("x_tag"));
		}
		if (!$this->sortnum->FldIsDetailKey) {
			$this->sortnum->setFormValue($objForm->GetValue("x_sortnum"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->isdel->FldIsDetailKey) {
			$this->isdel->setFormValue($objForm->GetValue("x_isdel"));
		}
		if (!$this->seo_title->FldIsDetailKey) {
			$this->seo_title->setFormValue($objForm->GetValue("x_seo_title"));
		}
		if (!$this->seo_keywords->FldIsDetailKey) {
			$this->seo_keywords->setFormValue($objForm->GetValue("x_seo_keywords"));
		}
		if (!$this->seo_description->FldIsDetailKey) {
			$this->seo_description->setFormValue($objForm->GetValue("x_seo_description"));
		}
		if (!$this->seo_url->FldIsDetailKey) {
			$this->seo_url->setFormValue($objForm->GetValue("x_seo_url"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->id->CurrentValue = $this->id->FormValue;
		$this->cid->CurrentValue = $this->cid->FormValue;
		$this->cat->CurrentValue = $this->cat->FormValue;
		$this->productname->CurrentValue = $this->productname->FormValue;
		$this->particlesize->CurrentValue = $this->particlesize->FormValue;
		$this->mw->CurrentValue = $this->mw->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->detail->CurrentValue = $this->detail->FormValue;
		$this->tag->CurrentValue = $this->tag->FormValue;
		$this->sortnum->CurrentValue = $this->sortnum->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->isdel->CurrentValue = $this->isdel->FormValue;
		$this->seo_title->CurrentValue = $this->seo_title->FormValue;
		$this->seo_keywords->CurrentValue = $this->seo_keywords->FormValue;
		$this->seo_description->CurrentValue = $this->seo_description->FormValue;
		$this->seo_url->CurrentValue = $this->seo_url->FormValue;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// id
			$this->id->EditAttrs["class"] = "form-control";
			$this->id->EditCustomAttributes = "";
			$this->id->EditValue = $this->id->CurrentValue;
			$this->id->ViewCustomAttributes = "";

			// cid
			$this->cid->EditAttrs["class"] = "form-control";
			$this->cid->EditCustomAttributes = "";
			if (trim(strval($this->cid->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->cid->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `id`, `fullname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `wp_products_categories`";
			$sWhereWrk = "";
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->cid, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `sno` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->cid->EditValue = $arwrk;

			// cat
			$this->cat->EditAttrs["class"] = "form-control";
			$this->cat->EditCustomAttributes = "";
			$this->cat->EditValue = ew_HtmlEncode($this->cat->CurrentValue);
			$this->cat->PlaceHolder = ew_RemoveHtml($this->cat->FldCaption());

			// productname
			$this->productname->EditAttrs["class"] = "form-control";
			$this->productname->EditCustomAttributes = "";
			$this->productname->EditValue = ew_HtmlEncode($this->productname->CurrentValue);
			$this->productname->PlaceHolder = ew_RemoveHtml($this->productname->FldCaption());

			// particlesize
			$this->particlesize->EditAttrs["class"] = "form-control";
			$this->particlesize->EditCustomAttributes = "";
			$this->particlesize->EditValue = ew_HtmlEncode($this->particlesize->CurrentValue);
			$this->particlesize->PlaceHolder = ew_RemoveHtml($this->particlesize->FldCaption());

			// mw
			$this->mw->EditAttrs["class"] = "form-control";
			$this->mw->EditCustomAttributes = "";
			$this->mw->EditValue = ew_HtmlEncode($this->mw->CurrentValue);
			$this->mw->PlaceHolder = ew_RemoveHtml($this->mw->FldCaption());

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = ew_HtmlEncode($this->description->CurrentValue);
			$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

			// detail
			$this->detail->EditAttrs["class"] = "form-control";
			$this->detail->EditCustomAttributes = "";
			$this->detail->EditValue = ew_HtmlEncode($this->detail->CurrentValue);
			$this->detail->PlaceHolder = ew_RemoveHtml($this->detail->FldCaption());

			// tag
			$this->tag->EditAttrs["class"] = "form-control";
			$this->tag->EditCustomAttributes = "";
			$this->tag->EditValue = ew_HtmlEncode($this->tag->CurrentValue);
			$this->tag->PlaceHolder = ew_RemoveHtml($this->tag->FldCaption());

			// sortnum
			$this->sortnum->EditAttrs["class"] = "form-control";
			$this->sortnum->EditCustomAttributes = "";
			$this->sortnum->EditValue = ew_HtmlEncode($this->sortnum->CurrentValue);
			$this->sortnum->PlaceHolder = ew_RemoveHtml($this->sortnum->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);
			$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

			// isdel
			$this->isdel->EditAttrs["class"] = "form-control";
			$this->isdel->EditCustomAttributes = "";
			$this->isdel->EditValue = ew_HtmlEncode($this->isdel->CurrentValue);
			$this->isdel->PlaceHolder = ew_RemoveHtml($this->isdel->FldCaption());

			// seo_title
			$this->seo_title->EditAttrs["class"] = "form-control";
			$this->seo_title->EditCustomAttributes = "";
			$this->seo_title->EditValue = ew_HtmlEncode($this->seo_title->CurrentValue);
			$this->seo_title->PlaceHolder = ew_RemoveHtml($this->seo_title->FldCaption());

			// seo_keywords
			$this->seo_keywords->EditAttrs["class"] = "form-control";
			$this->seo_keywords->EditCustomAttributes = "";
			$this->seo_keywords->EditValue = ew_HtmlEncode($this->seo_keywords->CurrentValue);
			$this->seo_keywords->PlaceHolder = ew_RemoveHtml($this->seo_keywords->FldCaption());

			// seo_description
			$this->seo_description->EditAttrs["class"] = "form-control";
			$this->seo_description->EditCustomAttributes = "";
			$this->seo_description->EditValue = ew_HtmlEncode($this->seo_description->CurrentValue);
			$this->seo_description->PlaceHolder = ew_RemoveHtml($this->seo_description->FldCaption());

			// seo_url
			$this->seo_url->EditAttrs["class"] = "form-control";
			$this->seo_url->EditCustomAttributes = "";
			$this->seo_url->EditValue = ew_HtmlEncode($this->seo_url->CurrentValue);
			$this->seo_url->PlaceHolder = ew_RemoveHtml($this->seo_url->FldCaption());

			// Edit refer script
			// id

			$this->id->LinkCustomAttributes = "";
			$this->id->HrefValue = "";

			// cid
			$this->cid->LinkCustomAttributes = "";
			$this->cid->HrefValue = "";

			// cat
			$this->cat->LinkCustomAttributes = "";
			$this->cat->HrefValue = "";

			// productname
			$this->productname->LinkCustomAttributes = "";
			$this->productname->HrefValue = "";

			// particlesize
			$this->particlesize->LinkCustomAttributes = "";
			$this->particlesize->HrefValue = "";

			// mw
			$this->mw->LinkCustomAttributes = "";
			$this->mw->HrefValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// detail
			$this->detail->LinkCustomAttributes = "";
			$this->detail->HrefValue = "";

			// tag
			$this->tag->LinkCustomAttributes = "";
			$this->tag->HrefValue = "";

			// sortnum
			$this->sortnum->LinkCustomAttributes = "";
			$this->sortnum->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// isdel
			$this->isdel->LinkCustomAttributes = "";
			$this->isdel->HrefValue = "";

			// seo_title
			$this->seo_title->LinkCustomAttributes = "";
			$this->seo_title->HrefValue = "";

			// seo_keywords
			$this->seo_keywords->LinkCustomAttributes = "";
			$this->seo_keywords->HrefValue = "";

			// seo_description
			$this->seo_description->LinkCustomAttributes = "";
			$this->seo_description->HrefValue = "";

			// seo_url
			$this->seo_url->LinkCustomAttributes = "";
			$this->seo_url->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->cid->FldIsDetailKey && !is_null($this->cid->FormValue) && $this->cid->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cid->FldCaption(), $this->cid->ReqErrMsg));
		}
		if (!$this->cat->FldIsDetailKey && !is_null($this->cat->FormValue) && $this->cat->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->cat->FldCaption(), $this->cat->ReqErrMsg));
		}
		if (!$this->productname->FldIsDetailKey && !is_null($this->productname->FormValue) && $this->productname->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->productname->FldCaption(), $this->productname->ReqErrMsg));
		}
		if (!$this->description->FldIsDetailKey && !is_null($this->description->FormValue) && $this->description->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->description->FldCaption(), $this->description->ReqErrMsg));
		}
		if (!$this->sortnum->FldIsDetailKey && !is_null($this->sortnum->FormValue) && $this->sortnum->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sortnum->FldCaption(), $this->sortnum->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->sortnum->FormValue)) {
			ew_AddMessage($gsFormError, $this->sortnum->FldErrMsg());
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->status->FormValue)) {
			ew_AddMessage($gsFormError, $this->status->FldErrMsg());
		}
		if (!$this->isdel->FldIsDetailKey && !is_null($this->isdel->FormValue) && $this->isdel->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->isdel->FldCaption(), $this->isdel->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->isdel->FormValue)) {
			ew_AddMessage($gsFormError, $this->isdel->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		if ($this->cat->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`cat` = '" . ew_AdjustSql($this->cat->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->cat->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->cat->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// cid
			$this->cid->SetDbValueDef($rsnew, $this->cid->CurrentValue, 0, $this->cid->ReadOnly);

			// cat
			$this->cat->SetDbValueDef($rsnew, $this->cat->CurrentValue, "", $this->cat->ReadOnly);

			// productname
			$this->productname->SetDbValueDef($rsnew, $this->productname->CurrentValue, "", $this->productname->ReadOnly);

			// particlesize
			$this->particlesize->SetDbValueDef($rsnew, $this->particlesize->CurrentValue, NULL, $this->particlesize->ReadOnly);

			// mw
			$this->mw->SetDbValueDef($rsnew, $this->mw->CurrentValue, NULL, $this->mw->ReadOnly);

			// description
			$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, $this->description->ReadOnly);

			// detail
			$this->detail->SetDbValueDef($rsnew, $this->detail->CurrentValue, NULL, $this->detail->ReadOnly);

			// tag
			$this->tag->SetDbValueDef($rsnew, $this->tag->CurrentValue, NULL, $this->tag->ReadOnly);

			// sortnum
			$this->sortnum->SetDbValueDef($rsnew, $this->sortnum->CurrentValue, 0, $this->sortnum->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);

			// isdel
			$this->isdel->SetDbValueDef($rsnew, $this->isdel->CurrentValue, 0, $this->isdel->ReadOnly);

			// seo_title
			$this->seo_title->SetDbValueDef($rsnew, $this->seo_title->CurrentValue, NULL, $this->seo_title->ReadOnly);

			// seo_keywords
			$this->seo_keywords->SetDbValueDef($rsnew, $this->seo_keywords->CurrentValue, NULL, $this->seo_keywords->ReadOnly);

			// seo_description
			$this->seo_description->SetDbValueDef($rsnew, $this->seo_description->CurrentValue, NULL, $this->seo_description->ReadOnly);

			// seo_url
			$this->seo_url->SetDbValueDef($rsnew, $this->seo_url->CurrentValue, NULL, $this->seo_url->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("wp_productslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'wp_products';
		$usr = CurrentUserName();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'wp_products';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['id'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserName();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($wp_products_edit)) $wp_products_edit = new cwp_products_edit();

// Page init
$wp_products_edit->Page_Init();

// Page main
$wp_products_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$wp_products_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fwp_productsedit = new ew_Form("fwp_productsedit", "edit");

// Validate form
fwp_productsedit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_cid");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $wp_products->cid->FldCaption(), $wp_products->cid->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_cat");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $wp_products->cat->FldCaption(), $wp_products->cat->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_productname");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $wp_products->productname->FldCaption(), $wp_products->productname->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_description");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $wp_products->description->FldCaption(), $wp_products->description->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sortnum");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $wp_products->sortnum->FldCaption(), $wp_products->sortnum->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sortnum");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($wp_products->sortnum->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $wp_products->status->FldCaption(), $wp_products->status->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($wp_products->status->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_isdel");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $wp_products->isdel->FldCaption(), $wp_products->isdel->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_isdel");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($wp_products->isdel->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fwp_productsedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fwp_productsedit.ValidateRequired = true;
<?php } else { ?>
fwp_productsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fwp_productsedit.Lists["x_cid"] = {"LinkField":"x_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_fullname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $wp_products_edit->ShowPageHeader(); ?>
<?php
$wp_products_edit->ShowMessage();
?>
<form name="fwp_productsedit" id="fwp_productsedit" class="<?php echo $wp_products_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($wp_products_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $wp_products_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="wp_products">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($wp_products->id->Visible) { // id ?>
	<div id="r_id" class="form-group">
		<label id="elh_wp_products_id" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->id->CellAttributes() ?>>
<span id="el_wp_products_id">
<span<?php echo $wp_products->id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $wp_products->id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="wp_products" data-field="x_id" name="x_id" id="x_id" value="<?php echo ew_HtmlEncode($wp_products->id->CurrentValue) ?>">
<?php echo $wp_products->id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->cid->Visible) { // cid ?>
	<div id="r_cid" class="form-group">
		<label id="elh_wp_products_cid" for="x_cid" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->cid->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->cid->CellAttributes() ?>>
<span id="el_wp_products_cid">
<select data-table="wp_products" data-field="x_cid" data-value-separator="<?php echo ew_HtmlEncode(is_array($wp_products->cid->DisplayValueSeparator) ? json_encode($wp_products->cid->DisplayValueSeparator) : $wp_products->cid->DisplayValueSeparator) ?>" id="x_cid" name="x_cid"<?php echo $wp_products->cid->EditAttributes() ?>>
<?php
if (is_array($wp_products->cid->EditValue)) {
	$arwrk = $wp_products->cid->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($wp_products->cid->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $wp_products->cid->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($wp_products->cid->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($wp_products->cid->CurrentValue) ?>" selected><?php echo $wp_products->cid->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `id`, `fullname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `wp_products_categories`";
$sWhereWrk = "";
$wp_products->cid->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$wp_products->cid->LookupFilters += array("f0" => "`id` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$wp_products->Lookup_Selecting($wp_products->cid, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `sno` ASC";
if ($sSqlWrk <> "") $wp_products->cid->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_cid" id="s_x_cid" value="<?php echo $wp_products->cid->LookupFilterQuery() ?>">
</span>
<?php echo $wp_products->cid->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->cat->Visible) { // cat ?>
	<div id="r_cat" class="form-group">
		<label id="elh_wp_products_cat" for="x_cat" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->cat->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->cat->CellAttributes() ?>>
<span id="el_wp_products_cat">
<input type="text" data-table="wp_products" data-field="x_cat" name="x_cat" id="x_cat" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($wp_products->cat->getPlaceHolder()) ?>" value="<?php echo $wp_products->cat->EditValue ?>"<?php echo $wp_products->cat->EditAttributes() ?>>
</span>
<?php echo $wp_products->cat->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->productname->Visible) { // productname ?>
	<div id="r_productname" class="form-group">
		<label id="elh_wp_products_productname" for="x_productname" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->productname->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->productname->CellAttributes() ?>>
<span id="el_wp_products_productname">
<input type="text" data-table="wp_products" data-field="x_productname" name="x_productname" id="x_productname" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($wp_products->productname->getPlaceHolder()) ?>" value="<?php echo $wp_products->productname->EditValue ?>"<?php echo $wp_products->productname->EditAttributes() ?>>
</span>
<?php echo $wp_products->productname->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->particlesize->Visible) { // particlesize ?>
	<div id="r_particlesize" class="form-group">
		<label id="elh_wp_products_particlesize" for="x_particlesize" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->particlesize->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->particlesize->CellAttributes() ?>>
<span id="el_wp_products_particlesize">
<input type="text" data-table="wp_products" data-field="x_particlesize" name="x_particlesize" id="x_particlesize" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($wp_products->particlesize->getPlaceHolder()) ?>" value="<?php echo $wp_products->particlesize->EditValue ?>"<?php echo $wp_products->particlesize->EditAttributes() ?>>
</span>
<?php echo $wp_products->particlesize->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->mw->Visible) { // mw ?>
	<div id="r_mw" class="form-group">
		<label id="elh_wp_products_mw" for="x_mw" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->mw->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->mw->CellAttributes() ?>>
<span id="el_wp_products_mw">
<input type="text" data-table="wp_products" data-field="x_mw" name="x_mw" id="x_mw" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($wp_products->mw->getPlaceHolder()) ?>" value="<?php echo $wp_products->mw->EditValue ?>"<?php echo $wp_products->mw->EditAttributes() ?>>
</span>
<?php echo $wp_products->mw->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_wp_products_description" for="x_description" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->description->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->description->CellAttributes() ?>>
<span id="el_wp_products_description">
<textarea data-table="wp_products" data-field="x_description" name="x_description" id="x_description" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($wp_products->description->getPlaceHolder()) ?>"<?php echo $wp_products->description->EditAttributes() ?>><?php echo $wp_products->description->EditValue ?></textarea>
</span>
<?php echo $wp_products->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->detail->Visible) { // detail ?>
	<div id="r_detail" class="form-group">
		<label id="elh_wp_products_detail" for="x_detail" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->detail->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->detail->CellAttributes() ?>>
<span id="el_wp_products_detail">
<textarea data-table="wp_products" data-field="x_detail" name="x_detail" id="x_detail" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($wp_products->detail->getPlaceHolder()) ?>"<?php echo $wp_products->detail->EditAttributes() ?>><?php echo $wp_products->detail->EditValue ?></textarea>
</span>
<?php echo $wp_products->detail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->tag->Visible) { // tag ?>
	<div id="r_tag" class="form-group">
		<label id="elh_wp_products_tag" for="x_tag" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->tag->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->tag->CellAttributes() ?>>
<span id="el_wp_products_tag">
<input type="text" data-table="wp_products" data-field="x_tag" name="x_tag" id="x_tag" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($wp_products->tag->getPlaceHolder()) ?>" value="<?php echo $wp_products->tag->EditValue ?>"<?php echo $wp_products->tag->EditAttributes() ?>>
</span>
<?php echo $wp_products->tag->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->sortnum->Visible) { // sortnum ?>
	<div id="r_sortnum" class="form-group">
		<label id="elh_wp_products_sortnum" for="x_sortnum" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->sortnum->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->sortnum->CellAttributes() ?>>
<span id="el_wp_products_sortnum">
<input type="text" data-table="wp_products" data-field="x_sortnum" name="x_sortnum" id="x_sortnum" size="30" placeholder="<?php echo ew_HtmlEncode($wp_products->sortnum->getPlaceHolder()) ?>" value="<?php echo $wp_products->sortnum->EditValue ?>"<?php echo $wp_products->sortnum->EditAttributes() ?>>
</span>
<?php echo $wp_products->sortnum->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_wp_products_status" for="x_status" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->status->CellAttributes() ?>>
<span id="el_wp_products_status">
<input type="text" data-table="wp_products" data-field="x_status" name="x_status" id="x_status" size="30" placeholder="<?php echo ew_HtmlEncode($wp_products->status->getPlaceHolder()) ?>" value="<?php echo $wp_products->status->EditValue ?>"<?php echo $wp_products->status->EditAttributes() ?>>
</span>
<?php echo $wp_products->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->isdel->Visible) { // isdel ?>
	<div id="r_isdel" class="form-group">
		<label id="elh_wp_products_isdel" for="x_isdel" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->isdel->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->isdel->CellAttributes() ?>>
<span id="el_wp_products_isdel">
<input type="text" data-table="wp_products" data-field="x_isdel" name="x_isdel" id="x_isdel" size="30" placeholder="<?php echo ew_HtmlEncode($wp_products->isdel->getPlaceHolder()) ?>" value="<?php echo $wp_products->isdel->EditValue ?>"<?php echo $wp_products->isdel->EditAttributes() ?>>
</span>
<?php echo $wp_products->isdel->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->seo_title->Visible) { // seo_title ?>
	<div id="r_seo_title" class="form-group">
		<label id="elh_wp_products_seo_title" for="x_seo_title" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->seo_title->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->seo_title->CellAttributes() ?>>
<span id="el_wp_products_seo_title">
<input type="text" data-table="wp_products" data-field="x_seo_title" name="x_seo_title" id="x_seo_title" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($wp_products->seo_title->getPlaceHolder()) ?>" value="<?php echo $wp_products->seo_title->EditValue ?>"<?php echo $wp_products->seo_title->EditAttributes() ?>>
</span>
<?php echo $wp_products->seo_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->seo_keywords->Visible) { // seo_keywords ?>
	<div id="r_seo_keywords" class="form-group">
		<label id="elh_wp_products_seo_keywords" for="x_seo_keywords" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->seo_keywords->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->seo_keywords->CellAttributes() ?>>
<span id="el_wp_products_seo_keywords">
<input type="text" data-table="wp_products" data-field="x_seo_keywords" name="x_seo_keywords" id="x_seo_keywords" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($wp_products->seo_keywords->getPlaceHolder()) ?>" value="<?php echo $wp_products->seo_keywords->EditValue ?>"<?php echo $wp_products->seo_keywords->EditAttributes() ?>>
</span>
<?php echo $wp_products->seo_keywords->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->seo_description->Visible) { // seo_description ?>
	<div id="r_seo_description" class="form-group">
		<label id="elh_wp_products_seo_description" for="x_seo_description" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->seo_description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->seo_description->CellAttributes() ?>>
<span id="el_wp_products_seo_description">
<input type="text" data-table="wp_products" data-field="x_seo_description" name="x_seo_description" id="x_seo_description" placeholder="<?php echo ew_HtmlEncode($wp_products->seo_description->getPlaceHolder()) ?>" value="<?php echo $wp_products->seo_description->EditValue ?>"<?php echo $wp_products->seo_description->EditAttributes() ?>>
</span>
<?php echo $wp_products->seo_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($wp_products->seo_url->Visible) { // seo_url ?>
	<div id="r_seo_url" class="form-group">
		<label id="elh_wp_products_seo_url" for="x_seo_url" class="col-sm-2 control-label ewLabel"><?php echo $wp_products->seo_url->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $wp_products->seo_url->CellAttributes() ?>>
<span id="el_wp_products_seo_url">
<input type="text" data-table="wp_products" data-field="x_seo_url" name="x_seo_url" id="x_seo_url" placeholder="<?php echo ew_HtmlEncode($wp_products->seo_url->getPlaceHolder()) ?>" value="<?php echo $wp_products->seo_url->EditValue ?>"<?php echo $wp_products->seo_url->EditAttributes() ?>>
</span>
<?php echo $wp_products->seo_url->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $wp_products_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fwp_productsedit.Init();
</script>
<?php
$wp_products_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$wp_products_edit->Page_Terminate();
?>
