<?php

// Global variable for table object
$wp_products = NULL;

//
// Table class for wp_products
//
class cwp_products extends cTable {
	var $id;
	var $cid;
	var $cat;
	var $productname;
	var $particlesize;
	var $mw;
	var $description;
	var $detail;
	var $tag;
	var $sortnum;
	var $status;
	var $isdel;
	var $seo_title;
	var $seo_keywords;
	var $seo_description;
	var $seo_url;
	var $itime;
	var $utime;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'wp_products';
		$this->TableName = 'wp_products';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`wp_products`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// id
		$this->id = new cField('wp_products', 'wp_products', 'x_id', 'id', '`id`', '`id`', 3, -1, FALSE, '`id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['id'] = &$this->id;

		// cid
		$this->cid = new cField('wp_products', 'wp_products', 'x_cid', 'cid', '`cid`', '`cid`', 3, -1, FALSE, '`cid`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->cid->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['cid'] = &$this->cid;

		// cat
		$this->cat = new cField('wp_products', 'wp_products', 'x_cat', 'cat', '`cat`', '`cat`', 200, -1, FALSE, '`cat`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['cat'] = &$this->cat;

		// productname
		$this->productname = new cField('wp_products', 'wp_products', 'x_productname', 'productname', '`productname`', '`productname`', 200, -1, FALSE, '`productname`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['productname'] = &$this->productname;

		// particlesize
		$this->particlesize = new cField('wp_products', 'wp_products', 'x_particlesize', 'particlesize', '`particlesize`', '`particlesize`', 200, -1, FALSE, '`particlesize`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['particlesize'] = &$this->particlesize;

		// mw
		$this->mw = new cField('wp_products', 'wp_products', 'x_mw', 'mw', '`mw`', '`mw`', 200, -1, FALSE, '`mw`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['mw'] = &$this->mw;

		// description
		$this->description = new cField('wp_products', 'wp_products', 'x_description', 'description', '`description`', '`description`', 201, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['description'] = &$this->description;

		// detail
		$this->detail = new cField('wp_products', 'wp_products', 'x_detail', 'detail', '`detail`', '`detail`', 201, -1, FALSE, '`detail`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->fields['detail'] = &$this->detail;

		// tag
		$this->tag = new cField('wp_products', 'wp_products', 'x_tag', 'tag', '`tag`', '`tag`', 200, -1, FALSE, '`tag`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['tag'] = &$this->tag;

		// sortnum
		$this->sortnum = new cField('wp_products', 'wp_products', 'x_sortnum', 'sortnum', '`sortnum`', '`sortnum`', 3, -1, FALSE, '`sortnum`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->sortnum->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['sortnum'] = &$this->sortnum;

		// status
		$this->status = new cField('wp_products', 'wp_products', 'x_status', 'status', '`status`', '`status`', 3, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;

		// isdel
		$this->isdel = new cField('wp_products', 'wp_products', 'x_isdel', 'isdel', '`isdel`', '`isdel`', 3, -1, FALSE, '`isdel`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->isdel->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['isdel'] = &$this->isdel;

		// seo_title
		$this->seo_title = new cField('wp_products', 'wp_products', 'x_seo_title', 'seo_title', '`seo_title`', '`seo_title`', 200, -1, FALSE, '`seo_title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['seo_title'] = &$this->seo_title;

		// seo_keywords
		$this->seo_keywords = new cField('wp_products', 'wp_products', 'x_seo_keywords', 'seo_keywords', '`seo_keywords`', '`seo_keywords`', 200, -1, FALSE, '`seo_keywords`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['seo_keywords'] = &$this->seo_keywords;

		// seo_description
		$this->seo_description = new cField('wp_products', 'wp_products', 'x_seo_description', 'seo_description', '`seo_description`', '`seo_description`', 201, -1, FALSE, '`seo_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['seo_description'] = &$this->seo_description;

		// seo_url
		$this->seo_url = new cField('wp_products', 'wp_products', 'x_seo_url', 'seo_url', '`seo_url`', '`seo_url`', 201, -1, FALSE, '`seo_url`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['seo_url'] = &$this->seo_url;

		// itime
		$this->itime = new cField('wp_products', 'wp_products', 'x_itime', 'itime', '`itime`', 'DATE_FORMAT(`itime`, \'%y-%m-%d %H:%i:%s\')', 135, -1, FALSE, '`itime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['itime'] = &$this->itime;

		// utime
		$this->utime = new cField('wp_products', 'wp_products', 'x_utime', 'utime', '`utime`', 'DATE_FORMAT(`utime`, \'%y-%m-%d %H:%i:%s\')', 135, -1, FALSE, '`utime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['utime'] = &$this->utime;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`wp_products`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('id', $rs))
				ew_AddFilter($where, ew_QuotedName('id', $this->DBID) . '=' . ew_QuotedValue($rs['id'], $this->id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`id` = @id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@id@", ew_AdjustSql($this->id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "wp_productslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "wp_productslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("wp_productsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("wp_productsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "wp_productsadd.php?" . $this->UrlParm($parm);
		else
			$url = "wp_productsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("wp_productsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("wp_productsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("wp_productsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "id:" . ew_VarToJson($this->id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->id->CurrentValue)) {
			$sUrl .= "id=" . urlencode($this->id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["id"]))
				$arKeys[] = ew_StripSlashes($_POST["id"]);
			elseif (isset($_GET["id"]))
				$arKeys[] = ew_StripSlashes($_GET["id"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// id
		$this->id->EditAttrs["class"] = "form-control";
		$this->id->EditCustomAttributes = "";
		$this->id->EditValue = $this->id->CurrentValue;
		$this->id->ViewCustomAttributes = "";

		// cid
		$this->cid->EditAttrs["class"] = "form-control";
		$this->cid->EditCustomAttributes = "";

		// cat
		$this->cat->EditAttrs["class"] = "form-control";
		$this->cat->EditCustomAttributes = "";
		$this->cat->EditValue = $this->cat->CurrentValue;
		$this->cat->PlaceHolder = ew_RemoveHtml($this->cat->FldCaption());

		// productname
		$this->productname->EditAttrs["class"] = "form-control";
		$this->productname->EditCustomAttributes = "";
		$this->productname->EditValue = $this->productname->CurrentValue;
		$this->productname->PlaceHolder = ew_RemoveHtml($this->productname->FldCaption());

		// particlesize
		$this->particlesize->EditAttrs["class"] = "form-control";
		$this->particlesize->EditCustomAttributes = "";
		$this->particlesize->EditValue = $this->particlesize->CurrentValue;
		$this->particlesize->PlaceHolder = ew_RemoveHtml($this->particlesize->FldCaption());

		// mw
		$this->mw->EditAttrs["class"] = "form-control";
		$this->mw->EditCustomAttributes = "";
		$this->mw->EditValue = $this->mw->CurrentValue;
		$this->mw->PlaceHolder = ew_RemoveHtml($this->mw->FldCaption());

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
		$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

		// detail
		$this->detail->EditAttrs["class"] = "form-control";
		$this->detail->EditCustomAttributes = "";
		$this->detail->EditValue = $this->detail->CurrentValue;
		$this->detail->PlaceHolder = ew_RemoveHtml($this->detail->FldCaption());

		// tag
		$this->tag->EditAttrs["class"] = "form-control";
		$this->tag->EditCustomAttributes = "";
		$this->tag->EditValue = $this->tag->CurrentValue;
		$this->tag->PlaceHolder = ew_RemoveHtml($this->tag->FldCaption());

		// sortnum
		$this->sortnum->EditAttrs["class"] = "form-control";
		$this->sortnum->EditCustomAttributes = "";
		$this->sortnum->EditValue = $this->sortnum->CurrentValue;
		$this->sortnum->PlaceHolder = ew_RemoveHtml($this->sortnum->FldCaption());

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->CurrentValue;
		$this->status->PlaceHolder = ew_RemoveHtml($this->status->FldCaption());

		// isdel
		$this->isdel->EditAttrs["class"] = "form-control";
		$this->isdel->EditCustomAttributes = "";
		$this->isdel->EditValue = $this->isdel->CurrentValue;
		$this->isdel->PlaceHolder = ew_RemoveHtml($this->isdel->FldCaption());

		// seo_title
		$this->seo_title->EditAttrs["class"] = "form-control";
		$this->seo_title->EditCustomAttributes = "";
		$this->seo_title->EditValue = $this->seo_title->CurrentValue;
		$this->seo_title->PlaceHolder = ew_RemoveHtml($this->seo_title->FldCaption());

		// seo_keywords
		$this->seo_keywords->EditAttrs["class"] = "form-control";
		$this->seo_keywords->EditCustomAttributes = "";
		$this->seo_keywords->EditValue = $this->seo_keywords->CurrentValue;
		$this->seo_keywords->PlaceHolder = ew_RemoveHtml($this->seo_keywords->FldCaption());

		// seo_description
		$this->seo_description->EditAttrs["class"] = "form-control";
		$this->seo_description->EditCustomAttributes = "";
		$this->seo_description->EditValue = $this->seo_description->CurrentValue;
		$this->seo_description->PlaceHolder = ew_RemoveHtml($this->seo_description->FldCaption());

		// seo_url
		$this->seo_url->EditAttrs["class"] = "form-control";
		$this->seo_url->EditCustomAttributes = "";
		$this->seo_url->EditValue = $this->seo_url->CurrentValue;
		$this->seo_url->PlaceHolder = ew_RemoveHtml($this->seo_url->FldCaption());

		// itime
		$this->itime->EditAttrs["class"] = "form-control";
		$this->itime->EditCustomAttributes = "";
		$this->itime->EditValue = $this->itime->CurrentValue;
		$this->itime->PlaceHolder = ew_RemoveHtml($this->itime->FldCaption());

		// utime
		$this->utime->EditAttrs["class"] = "form-control";
		$this->utime->EditCustomAttributes = "";
		$this->utime->EditValue = $this->utime->CurrentValue;
		$this->utime->PlaceHolder = ew_RemoveHtml($this->utime->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->cid->Exportable) $Doc->ExportCaption($this->cid);
					if ($this->cat->Exportable) $Doc->ExportCaption($this->cat);
					if ($this->productname->Exportable) $Doc->ExportCaption($this->productname);
					if ($this->particlesize->Exportable) $Doc->ExportCaption($this->particlesize);
					if ($this->mw->Exportable) $Doc->ExportCaption($this->mw);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->detail->Exportable) $Doc->ExportCaption($this->detail);
					if ($this->tag->Exportable) $Doc->ExportCaption($this->tag);
					if ($this->sortnum->Exportable) $Doc->ExportCaption($this->sortnum);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->isdel->Exportable) $Doc->ExportCaption($this->isdel);
					if ($this->seo_title->Exportable) $Doc->ExportCaption($this->seo_title);
					if ($this->seo_keywords->Exportable) $Doc->ExportCaption($this->seo_keywords);
					if ($this->seo_description->Exportable) $Doc->ExportCaption($this->seo_description);
					if ($this->seo_url->Exportable) $Doc->ExportCaption($this->seo_url);
					if ($this->itime->Exportable) $Doc->ExportCaption($this->itime);
					if ($this->utime->Exportable) $Doc->ExportCaption($this->utime);
				} else {
					if ($this->id->Exportable) $Doc->ExportCaption($this->id);
					if ($this->cid->Exportable) $Doc->ExportCaption($this->cid);
					if ($this->cat->Exportable) $Doc->ExportCaption($this->cat);
					if ($this->productname->Exportable) $Doc->ExportCaption($this->productname);
					if ($this->particlesize->Exportable) $Doc->ExportCaption($this->particlesize);
					if ($this->mw->Exportable) $Doc->ExportCaption($this->mw);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->tag->Exportable) $Doc->ExportCaption($this->tag);
					if ($this->sortnum->Exportable) $Doc->ExportCaption($this->sortnum);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->isdel->Exportable) $Doc->ExportCaption($this->isdel);
					if ($this->seo_title->Exportable) $Doc->ExportCaption($this->seo_title);
					if ($this->seo_keywords->Exportable) $Doc->ExportCaption($this->seo_keywords);
					if ($this->itime->Exportable) $Doc->ExportCaption($this->itime);
					if ($this->utime->Exportable) $Doc->ExportCaption($this->utime);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->cid->Exportable) $Doc->ExportField($this->cid);
						if ($this->cat->Exportable) $Doc->ExportField($this->cat);
						if ($this->productname->Exportable) $Doc->ExportField($this->productname);
						if ($this->particlesize->Exportable) $Doc->ExportField($this->particlesize);
						if ($this->mw->Exportable) $Doc->ExportField($this->mw);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->detail->Exportable) $Doc->ExportField($this->detail);
						if ($this->tag->Exportable) $Doc->ExportField($this->tag);
						if ($this->sortnum->Exportable) $Doc->ExportField($this->sortnum);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->isdel->Exportable) $Doc->ExportField($this->isdel);
						if ($this->seo_title->Exportable) $Doc->ExportField($this->seo_title);
						if ($this->seo_keywords->Exportable) $Doc->ExportField($this->seo_keywords);
						if ($this->seo_description->Exportable) $Doc->ExportField($this->seo_description);
						if ($this->seo_url->Exportable) $Doc->ExportField($this->seo_url);
						if ($this->itime->Exportable) $Doc->ExportField($this->itime);
						if ($this->utime->Exportable) $Doc->ExportField($this->utime);
					} else {
						if ($this->id->Exportable) $Doc->ExportField($this->id);
						if ($this->cid->Exportable) $Doc->ExportField($this->cid);
						if ($this->cat->Exportable) $Doc->ExportField($this->cat);
						if ($this->productname->Exportable) $Doc->ExportField($this->productname);
						if ($this->particlesize->Exportable) $Doc->ExportField($this->particlesize);
						if ($this->mw->Exportable) $Doc->ExportField($this->mw);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->tag->Exportable) $Doc->ExportField($this->tag);
						if ($this->sortnum->Exportable) $Doc->ExportField($this->sortnum);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->isdel->Exportable) $Doc->ExportField($this->isdel);
						if ($this->seo_title->Exportable) $Doc->ExportField($this->seo_title);
						if ($this->seo_keywords->Exportable) $Doc->ExportField($this->seo_keywords);
						if ($this->itime->Exportable) $Doc->ExportField($this->itime);
						if ($this->utime->Exportable) $Doc->ExportField($this->utime);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {
		ew_Execute("INSERT INTO wp_products_json (productid,jsontxt) values (".$rsnew["id"].",'".$rsnew["detail"]."')");
		$str = $rsnew["detail"];
		$patterns = array();
			$patterns[0] = '/\s+/im';
			$patterns[1] = '/{/im';
			$patterns[2] = '/}/im';
			$replacements = array();
			$replacements[0] = ' ';
			$replacements[1] = '';
			$replacements[2] = '';
			$str = preg_replace($patterns, $replacements, $str);
			$str = str_replace('\"','',$str);
			$str = str_replace(',',' ',$str);
		ew_Execute("INSERT INTO wp_products_search (productid,searchtxt) values (".$rsnew["id"].",'".$str."')");
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
		ew_Execute("update wp_products_json set jsontxt='".$rsnew["detail"]."' where productid=".$rsold["id"]);
		$str = $rsnew["detail"];
		$patterns = array();
			$patterns[0] = '/\s+/im';
			$patterns[1] = '/{/im';
			$patterns[2] = '/}/im';
			$replacements = array();
			$replacements[0] = ' ';
			$replacements[1] = '';
			$replacements[2] = '';
			$str = preg_replace($patterns, $replacements, $str);
			$str = str_replace('\"','',$str);
			$str = str_replace(',',' ',$str);
		ew_Execute("update wp_products_search set searchtxt='".$str."' where productid=".$rsold["id"]);
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
