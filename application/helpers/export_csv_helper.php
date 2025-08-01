<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('arrayToCSV')) {
    function arrayToCSV($query, $fields, $dataTitle='',$filename = "CSV")
    {
        if (count($query) == 0) {
            return "The query is empty. It doesn't have any data.";
        } else {
            $headers = rowCSV($fields);
            $data = "";
            $title='';
            if($dataTitle!=''){
                foreach ($dataTitle as $row) {
                    $line = rowCSV($row);
                    $title .= trim($line) . "\n";
                }
            }
            if($query!='') {
                foreach ($query as $row) {
                    $line = rowCSV($row);
                    $data .= trim($line) . "\n";
                }
            }else{
                $data='No Data Found';
            }
            $data = str_replace("\r", "", $data);

            $content = $title."\n".$headers . "\n" . $data;
            $filename = date('YmdHis') . "_{$filename}.csv";

            header("Content-Description: File Transfer");
            header("Content-type: application/csv; charset=UTF-8");
            header("Content-Disposition: attachment; filename={$filename}");
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . strlen($content));

            return $content;
        }
    }
}

if (!function_exists('rowCSV')) {
    function rowCSV($fields)
    {
        $output = '';
        $separator = '';
        foreach ($fields as $field) {
            if (preg_match('/\\r|\\n|,|"/', $field)) {
                $field = '"' . str_replace('"', '""', $field) . '"';
            }
            $output .= $separator . $field;
            $separator = ',';
        }
        return $output . "\r\n";
    }
}