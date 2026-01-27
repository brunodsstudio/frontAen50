<?php

namespace App\Helpers;

class PaginacaoHelper{

    static public function paginacao($page, $aData){
        // The page to display (Usually is received in a url parameter)
       // $page = intval($_GET['page']);

        // The number of records to display per page
        $page_size = 25;

        // Calculate total number of records, and total number of pages
        $total_records = count($aData);
        $total_pages   = ceil($total_records / $page_size);

        // Validation: Page to display can not be greater than the total number of pages
        if ($page > $total_pages) {
            $page = $total_pages;
        }

        // Validation: Page to display can not be less than 1
        if ($page < 1) {
            $page = 1;
        }

        // Calculate the position of the first record of the page to display
        $offset = ($page - 1) * $page_size;

        // Get the subset of records to be displayed from the array
        $data = array_slice($aData, $offset, $page_size);

        return $data;
    }
}
?>