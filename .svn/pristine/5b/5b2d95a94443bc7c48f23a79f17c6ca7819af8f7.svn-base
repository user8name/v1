<?php
/**
 * @author zeke
 */
class pager
{
    public $each_disNums; // The number of items displayed on each page
    public $nums; //Total number of contents
    public $current_page; //The currently selected page
    public $sub_pages; //The number of pages displayed each time
    public $pageNums; //Total page
    public $page_array = array(); //An array used to construct paging
    public $subPage_link; //Links for each paging
    public $subPage_type; //Display the type of paging
    public $_lang = array(
        'index_page' => 'First',
        'pre_page' => 'Previous',
        'next_page' => 'Next',
        'last_page' => 'Last',
        'current_page' => 'The current page:',
        'total_page' => 'Total page:',
        'current_show' => 'The current display:',
        'total_record' => 'Total number of records:',
    );
    public $pagenavstr='';
    /**
     * __construct is the constructor of SubPages, which is used to run automatically when creating classes.
     * @total_page total number of pages
     * @current_num the currently selected page
     * @sub_pages number of pages displayed each time
     * @subPage_link links for each page
     * @subPage_type displays the type of paging
     * When @subPage_type=1, www.phpfensi.com is a normal paging mode.
     * example: a total of 4523 records, 10 pages per page, the current 1/453 page [home page] [last page] [bottom page] [end page]
     * Classic paging style when @subPage_type=2
     * Example: current 1/453 page [home page] [top page] 12345678910 [bottom page] [tail]
     */
    public function __construct($total_page, $current_page, $sub_pages = 10, $subPage_link = '', $subPage_type = 3,$pagesize=10)
    {
        $this->pager($total_page, $current_page, $sub_pages, $subPage_link, $subPage_type,$pagesize);
    }

    public function pager($total_page, $current_page, $sub_pages = 10, $subPage_link = '', $subPage_type = 3,$pagesize=10)
    {
        if (!$current_page) {
            $this->current_page = 1;
        } else {
            $this->current_page = intval($current_page);
        }
        $this->sub_pages = intval($sub_pages);
        $this->pageNums = ceil($total_page / $pagesize);
        if ($subPage_link) {
            if (strpos($subPage_link, '?page=') === false and strpos($subPage_link, '&page=') === false) {
                $subPage_link .= (strpos($subPage_link, '?') === false ? '?' : '&') . 'page=';
            }
        }
        //$this->subPage_link = $subPage_link ? $subPage_link : $_SERVER['PHP_SELF'] . '?page=';
        $this->subPage_link = $subPage_link ? $subPage_link :'?page=';
        $this->subPage_type = $subPage_type;
    }

    /**
     * The show_SubPages function is used inside the constructor. And used to judge what paging is like
     */
    public function showpager()
    {
        if ($this->subPage_type == 1) {
            return $this->pagelist1();
        } elseif ($this->subPage_type == 2) {
            return $this->pagelist2();
        } elseif ($this->subPage_type == 3) {
            return $this->pagelist3();
        }
    }

    /**
     * Function used to initialize arrays for paging.
     */
    public function initArray()
    {
        for ($i = 0; $i < $this->sub_pages; $i++) {
            $this->page_array[$i] = $i;
        }
        return $this->page_array;
    }

    /**
     * Construct_num_Page this function is used to construct the displayed items.
     * Even: [1][2][3][4][5][6][7][8][9][10]
     */
    public function construct_num_Page()
    {
        if ($this->pageNums < $this->sub_pages) {
            $current_array = array();
            for ($i = 0; $i < $this->pageNums; $i++) {
                $current_array[$i] = $i + 1;
            }
        } else {
            $current_array = $this->initArray();
            if ($this->current_page <= 3) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $i + 1;
                }
            } elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = ($this->pageNums) - ($this->sub_pages) + 1 + $i;
                }
            } else {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $this->current_page - 2 + $i;
                }
            }
        }

        return $current_array;
    }

    /**
     * Construction of a common pattern paging
     * A total of 4523 records, each page shows 10, the current 1/453 page [home page] [last page] [bottom page] [End]
     */
    public function pagelist1()
    {
        $subPageCss1Str = "";
        $subPageCss1Str .= $this->_lang['current_page'] . $this->current_page . " / " . $this->pageNums . "   ";
        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl = $this->subPage_link . ($this->current_page - 1);
            $subPageCss1Str .= "<a href='$firstPageUrl'>{$this->_lang['index_page']}</a> ";
            $subPageCss1Str .= "<a href='$prewPageUrl'>{$this->_lang['pre_page']}</a> ";
        } else {
            $subPageCss1Str .= "{$this->_lang['index_page']} ";
            $subPageCss1Str .= "{$this->_lang['pre_page']} ";
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            $subPageCss1Str .= " <a href='$nextPageUrl'>{$this->_lang['next_page']}</a> ";
            $subPageCss1Str .= "<a href='$lastPageUrl'>{$this->_lang['last_page']}</a> ";
        } else {
            $subPageCss1Str .= "{$this->_lang['next_page']} ";
            $subPageCss1Str .= "{$this->_lang['last_page']} ";
        }

        return $subPageCss1Str;
    }

    /**
     * Construction of classical pattern paging
     * Current page 1/453 [home page] [top page] 12345678910 [bottom page] [End]
     */
    public function pagelist2()
    {
        $subPageCss2Str = "";
        $subPageCss2Str .= $this->_lang['current_page'] . $this->current_page . "/" . $this->pageNums . " ";

        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl = $this->subPage_link . ($this->current_page - 1);
            $subPageCss2Str .= "<a href='$firstPageUrl'>{$this->_lang['index_page']}</a> ";
            $subPageCss2Str .= "<a href='$prewPageUrl'>{$this->_lang['pre_page']}</a> ";
        } else {
            $subPageCss2Str .= "{$this->_lang['index_page']} ";
            $subPageCss2Str .= "{$this->_lang['pre_page']} ";
        }

        $a = $this->construct_num_Page();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $subPageCss2Str .= "[<span style='color:red;font-weight:bold;'>" . $s . "</span>]";
            } else {
                $url = $this->subPage_link . $s;
                $subPageCss2Str .= "[<a href='$url'>" . $s . "</a>]";
            }
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            $subPageCss2Str .= " <a href='$nextPageUrl'>{$this->_lang['next_page']}</a> ";
            $subPageCss2Str .= "<a href='$lastPageUrl'>{$this->_lang['last_page']}</a> ";
        } else {
            $subPageCss2Str .= "{$this->_lang['next_page']} ";
            $subPageCss2Str .= "{$this->_lang['last_page']} ";
        }
        return $subPageCss2Str;
    }
   /**
    * Construction of classical pattern paging
    * [pre page] 12345678910 [next page]
    */
    public function pagelist3()
    {
        $this->pagenavstr='';
        $subPageCss2Str = "";
        //$subPageCss2Str .= $this->_lang['current_page'] . $this->current_page . "/" . $this->pageNums . " ";

        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl = $this->subPage_link . ($this->current_page - 1);
            //$subPageCss2Str .= "<a href='$firstPageUrl'>{$this->_lang['index_page']}</a> ";
            $subPageCss2Str .= "<a href='$prewPageUrl'>{$this->_lang['pre_page']}</a> ";

            $this->pagenavstr .='<link rel="prev" href="'.$prewPageUrl.'" />';
        } else {
            //$subPageCss2Str .= "{$this->_lang['index_page']} ";
            $subPageCss2Str .= "{$this->_lang['pre_page']} ";
        }

        $a = $this->construct_num_Page();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $subPageCss2Str .= "<a href='javascript:void(0)' style='color:red;font-weight:bold;'>" . $s . "</a>";
            } else {
                $url = $this->subPage_link . $s;
                $subPageCss2Str .= "<a href='$url'>" . $s . "</a>";
            }
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            $subPageCss2Str .= " <a href='$nextPageUrl'>{$this->_lang['next_page']}</a> ";
            //$subPageCss2Str .= "<a href='$lastPageUrl'>{$this->_lang['last_page']}</a> ";
            $this->pagenavstr .='<link rel="next" href="'.$nextPageUrl.'" />';
        } else {
            $subPageCss2Str .= " {$this->_lang['next_page']} ";

            //$subPageCss2Str .= "{$this->_lang['last_page']} ";
        }
        //do_action的含义是在这里调用函数
        //do_action('v1_nav_action',$this->$pagenavstr);
        
        add_filter('v1_nav_filter',array(&$this, 'v1_nav_filter'));
        return $subPageCss2Str;
    }

    public function v1_nav_filter($s){
        return $this->pagenavstr;
    }

    /**
     * __destruct:Destructor is called when the class is not in use. This function is used to release resources.
     */
    public function __destruct()
    {
        unset($each_disNums);
        unset($nums);
        unset($current_page);
        unset($sub_pages);
        unset($pageNums);
        unset($page_array);
        unset($subPage_link);
        unset($subPage_type);
    }
}

class pager_standard
{
    public $each_disNums; // The number of items displayed on each page
    public $nums; //Total number of contents
    public $current_page; //The currently selected page
    public $sub_pages; //The number of pages displayed each time
    public $pageNums; //Total page
    public $page_array = array(); //An array used to construct paging
    public $subPage_link; //Links for each paging
    public $subPage_type; //Display the type of paging
    public $_lang = array(
        'index_page' => 'First',
        'pre_page' => 'Previous',
        'next_page' => 'Next',
        'last_page' => 'Last',
        'current_page' => 'The current page:',
        'total_page' => 'Total page:',
        'current_show' => 'The current display:',
        'total_record' => 'Total number of records:',
    );
    public $pagenavstr='';
    /**
     * __construct is the constructor of SubPages, which is used to run automatically when creating classes.
     * @total_page total number of pages
     * @current_num the currently selected page
     * @sub_pages number of pages displayed each time
     * @subPage_link links for each page
     * @subPage_type displays the type of paging
     * When @subPage_type=1, www.phpfensi.com is a normal paging mode.
     * example: a total of 4523 records, 10 pages per page, the current 1/453 page [home page] [last page] [bottom page] [end page]
     * Classic paging style when @subPage_type=2
     * Example: current 1/453 page [home page] [top page] 12345678910 [bottom page] [tail]
     */
    public function __construct($total_page, $current_page, $sub_pages = 10, $subPage_link = '', $subPage_type = 3,$pagesize=10)
    {
        $this->pager($total_page, $current_page, $sub_pages, $subPage_link, $subPage_type,$pagesize);
    }

    public function pager($total_page, $current_page, $sub_pages = 10, $subPage_link = '', $subPage_type = 3,$pagesize=10)
    {
        if (!$current_page) {
            $this->current_page = 1;
        } else {
            $this->current_page = intval($current_page);
        }
        $this->sub_pages = intval($sub_pages);
        $this->pageNums = ceil($total_page / $pagesize);
        if ($subPage_link) {
            if (strpos($subPage_link, '?pages=') === false and strpos($subPage_link, '&pages=') === false) {
                $subPage_link .= (strpos($subPage_link, '?') === false ? '?' : '&') . 'pages=';
            }
        }
        //$this->subPage_link = $subPage_link ? $subPage_link : $_SERVER['PHP_SELF'] . '?page=';
        $this->subPage_link = $subPage_link ? $subPage_link :'?pages=';
        $this->subPage_type = $subPage_type;
    }

    /**
     * The show_SubPages function is used inside the constructor. And used to judge what paging is like
     */
    public function showpager()
    {
        if ($this->subPage_type == 1) {
            return $this->pagelist1();
        } elseif ($this->subPage_type == 2) {
            return $this->pagelist2();
        } elseif ($this->subPage_type == 3) {
            return $this->pagelist3();
        }
    }

    /**
     * Function used to initialize arrays for paging.
     */
    public function initArray()
    {
        for ($i = 0; $i < $this->sub_pages; $i++) {
            $this->page_array[$i] = $i;
        }
        return $this->page_array;
    }

    /**
     * Construct_num_Page this function is used to construct the displayed items.
     * Even: [1][2][3][4][5][6][7][8][9][10]
     */
    public function construct_num_Page()
    {
        if ($this->pageNums < $this->sub_pages) {
            $current_array = array();
            for ($i = 0; $i < $this->pageNums; $i++) {
                $current_array[$i] = $i + 1;
            }
        } else {
            $current_array = $this->initArray();
            if ($this->current_page <= 3) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $i + 1;
                }
            } elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = ($this->pageNums) - ($this->sub_pages) + 1 + $i;
                }
            } else {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $this->current_page - 2 + $i;
                }
            }
        }

        return $current_array;
    }

    /**
     * Construction of a common pattern paging
     * A total of 4523 records, each page shows 10, the current 1/453 page [home page] [last page] [bottom page] [End]
     */
    public function pagelist1()
    {
        $subPageCss1Str = "";
        $subPageCss1Str .= $this->_lang['current_page'] . $this->current_page . " / " . $this->pageNums . "   ";
        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl = $this->subPage_link . ($this->current_page - 1);
            $subPageCss1Str .= "<a href='$firstPageUrl'>{$this->_lang['index_page']}</a> ";
            $subPageCss1Str .= "<a href='$prewPageUrl'>{$this->_lang['pre_page']}</a> ";
        } else {
            $subPageCss1Str .= "{$this->_lang['index_page']} ";
            $subPageCss1Str .= "{$this->_lang['pre_page']} ";
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            $subPageCss1Str .= " <a href='$nextPageUrl'>{$this->_lang['next_page']}</a> ";
            $subPageCss1Str .= "<a href='$lastPageUrl'>{$this->_lang['last_page']}</a> ";
        } else {
            $subPageCss1Str .= "{$this->_lang['next_page']} ";
            $subPageCss1Str .= "{$this->_lang['last_page']} ";
        }

        return $subPageCss1Str;
    }

    /**
     * Construction of classical pattern paging
     * Current page 1/453 [home page] [top page] 12345678910 [bottom page] [End]
     */
    public function pagelist2()
    {
        $subPageCss2Str = "";
        $subPageCss2Str .= $this->_lang['current_page'] . $this->current_page . "/" . $this->pageNums . " ";

        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl = $this->subPage_link . ($this->current_page - 1);
            $subPageCss2Str .= "<a href='$firstPageUrl'>{$this->_lang['index_page']}</a> ";
            $subPageCss2Str .= "<a href='$prewPageUrl'>{$this->_lang['pre_page']}</a> ";
        } else {
            $subPageCss2Str .= "{$this->_lang['index_page']} ";
            $subPageCss2Str .= "{$this->_lang['pre_page']} ";
        }

        $a = $this->construct_num_Page();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $subPageCss2Str .= "[<span style='color:red;font-weight:bold;'>" . $s . "</span>]";
            } else {
                $url = $this->subPage_link . $s;
                $subPageCss2Str .= "[<a href='$url'>" . $s . "</a>]";
            }
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            $subPageCss2Str .= " <a href='$nextPageUrl'>{$this->_lang['next_page']}</a> ";
            $subPageCss2Str .= "<a href='$lastPageUrl'>{$this->_lang['last_page']}</a> ";
        } else {
            $subPageCss2Str .= "{$this->_lang['next_page']} ";
            $subPageCss2Str .= "{$this->_lang['last_page']} ";
        }
        return $subPageCss2Str;
    }
    /**
     * Construction of classical pattern paging
     * [pre page] 12345678910 [next page]
     */
    public function pagelist3()
    {
        $this->pagenavstr='';
        $subPageCss2Str = "";
        //$subPageCss2Str .= $this->_lang['current_page'] . $this->current_page . "/" . $this->pageNums . " ";

        if ($this->current_page > 1) {
            $firstPageUrl = $this->subPage_link . "1";
            $prewPageUrl = $this->subPage_link . ($this->current_page - 1);
            //$subPageCss2Str .= "<a href='$firstPageUrl'>{$this->_lang['index_page']}</a> ";
            $subPageCss2Str .= "<a href='$prewPageUrl'>{$this->_lang['pre_page']}</a> ";

            $this->pagenavstr .='<link rel="prev" href="'.$prewPageUrl.'" />';
        } else {
            //$subPageCss2Str .= "{$this->_lang['index_page']} ";
            $subPageCss2Str .= "{$this->_lang['pre_page']} ";
        }

        $a = $this->construct_num_Page();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $subPageCss2Str .= "<a href='javascript:void(0)' style='color:red;font-weight:bold;'>" . $s . "</a>";
            } else {
                $url = $this->subPage_link . $s;
                $subPageCss2Str .= "<a href='$url'>" . $s . "</a>";
            }
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->subPage_link . $this->pageNums;
            $nextPageUrl = $this->subPage_link . ($this->current_page + 1);
            $subPageCss2Str .= " <a href='$nextPageUrl'>{$this->_lang['next_page']}</a> ";
            //$subPageCss2Str .= "<a href='$lastPageUrl'>{$this->_lang['last_page']}</a> ";
            $this->pagenavstr .='<link rel="next" href="'.$nextPageUrl.'" />';
        } else {
            $subPageCss2Str .= " {$this->_lang['next_page']} ";

            //$subPageCss2Str .= "{$this->_lang['last_page']} ";
        }
        //do_action的含义是在这里调用函数
        //do_action('v1_nav_action',$this->$pagenavstr);

        add_filter('v1_nav_filter',array(&$this, 'v1_nav_filter'));
        return $subPageCss2Str;
    }

    public function v1_nav_filter($s){
        return $this->pagenavstr;
    }

    /**
     * __destruct:Destructor is called when the class is not in use. This function is used to release resources.
     */
    public function __destruct()
    {
        unset($each_disNums);
        unset($nums);
        unset($current_page);
        unset($sub_pages);
        unset($pageNums);
        unset($page_array);
        unset($subPage_link);
        unset($subPage_type);
    }
}