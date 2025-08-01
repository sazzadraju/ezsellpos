<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class common
{

    public static function layout($layout_url = null, $link_url = null)
    {
        $CI = &get_instance();
        if ($layout_url == null) {
            $layout_url = 'template/default/';
        }
        ($link_url == null) ? $CI->link_url = $CI->data['link_url'] = base_url() . 'themes/default/' : $CI->data['link_url'] = $link_url;
        $CI->tamplate['header'] = $CI->load->view($layout_url . 'header', $CI->data, TRUE);
        $CI->tamplate['top_menu'] = $CI->load->view($layout_url . 'top-menu', $CI->data, TRUE);
        $CI->tamplate['site_menu'] = $CI->load->view($layout_url . 'site-menu', $CI->data, TRUE);
        $CI->tamplate['page'] = $CI->load->view($CI->page, $CI->data, TRUE);
        $CI->tamplate['footer'] = $CI->load->view($layout_url . 'footer', $CI->data, TRUE);
        $CI->load->view($layout_url . 'main', $CI->tamplate);

    }

    public static function get_breadcrumbs($breadcrumb_slag)
    {
        $CI = &get_instance();
        $CI->load->library('make_bread');
        $i = 0;
        $segs = $CI->uri->segment_array();
        foreach ($segs as $segment) {
            $CI->make_bread->add($breadcrumb_slag[$i], $segment, 1);
            $i++;

        }
        return $breadcrumb = $CI->make_bread->output();
    }

}

// Prints Array
if (!function_exists('upload_file')) {
    function upload_file($doc_type, $file)
    {
        $CI = &get_instance();
        $CI->load->library('DigitalOcean');
        $bucket = 'ezsellbd-clients';
        ##add bucket if not exist
        //$CI->aws3->addBucket($bucket);
        //$actual_link = isset($_SERVER['HTTPS']) ? "https://" : "http://";
        $actual_link ="https://";
        $url = base_url();
        $site_url = str_replace($actual_link, '', $url);
        $d_path = $CI->config->item('document_paths');
        $ext = @end(explode(".", $file['name']));
        $main_url = explode('.', $site_url)[0];
        $file_name = date('Ymd') . time() . '.' . $ext;
        $file_upload_path = $main_url . '/' . get_key($d_path, $doc_type) . '/' . $file_name;
        $CI->digitalocean->sendFile($bucket, $file_upload_path, $file['tmp_name']);
        return $file_name;
    }
}
if (!function_exists('delete_file')) {
    function delete_file($doc_type, $file)
    {
        $CI = &get_instance();
        $CI->load->library('DigitalOcean');
        $bucket = 'ezsellbd-clients';
        ##add bucket if not exist
        //$CI->aws3->addBucket($bucket);
       // $actual_link = isset($_SERVER['HTTPS']) ? "https://" : "http://";
        $actual_link ="https://";
        $url = base_url();
        $site_url = str_replace($actual_link, '', $url);
        $d_path = $CI->config->item('document_paths');
        $main_url = explode('.', $site_url)[0];
        $file_upload_path = $main_url . '/' . get_key($d_path, $doc_type);
        $result = $CI->digitalocean->deleteFile($bucket, $file_upload_path, $file);
        return $result;
    }
}
if (!function_exists('documentLink')) {
    function documentLink($type)
    {
        $CI = &get_instance();
        $d_path = $CI->config->item('document_paths');
        $CI = &get_instance();
        $actual_link ="https://";
        $url = base_url();
        $site_url = str_replace($actual_link, '', $url);
        $main_url = explode('.', $site_url)[0];
        $url='https://ezsellbd-clients.sgp1.digitaloceanspaces.com/'.$main_url.'/'.$d_path[$type].'/';
        return $url;
    }
}


// Prints Array
if (!function_exists('pa')) {
    function pa($array)
    {
        echo '<pre>';
        var_export($array);
        echo '</pre>';
    }
}

// Prints Array and stops further execution
if (!function_exists('dd')) {
    function dd($array)
    {
        echo '<pre>';
        var_export($array);
        echo '</pre>';
        exit;
    }
}
if (!function_exists('account_name_id')) {
    function account_name_id($id)
    {
        $ci=& get_instance();
        $ci->load->database();
        $ci->db->select('a.*,b.bank_name');
        $ci->db->from('accounts a');
        $ci->db->join('banks b', 'b.id_bank= a.bank_id','left');
        $ci->db->where('id_account', $id);
        $row = $ci->db->get()->row();
        $result='';
        if($row->account_name !=''){
            $result=$row->account_name;
        }else if($row->bank_id!='' && $row->acc_type_id==1){
            $result=$row->bank_name.' ('.$row->account_no.')';
        }else if($row->bank_id!='' && $row->acc_type_id==3){
            $result=$row->bank_name.' ('.$row->account_no.')';
        }
       // $fullName = $row->id_account . " " . $row->account_name.' 55';
        return $result;
    }
}

if (!function_exists('get_key')) {
    function get_key($haystack, $needle, $default_value = '')
    {
        if (is_array($haystack)) {
            // We have an array. Find the key.
            return isset($haystack[$needle]) ? $haystack[$needle] : $default_value;
        } else {
            // If it's not an array it must be an object
            return isset($haystack->$needle) ? $haystack->$needle : $default_value;
        }
    }
}

if (!function_exists('get_val')) {
    function get_val($value, $default_value = '')
    {
        return isset($value) ? $value : $default_value;
    }
}


if (!function_exists('comma_seperator')) {
    function comma_seperator($number, $decimal_point = 2)
    {
        $number = number_format($number, $decimal_point, '.', ',');
        if (false !== strpos($number, '.')) {
            $number = rtrim(rtrim($number, '0'), '.');
        }

        return $number;
    }
}

## Removes unnecessary 0 from a number
## 7.80 => 7.8
## 7.00 => 7
if (!function_exists('trim_zero')) {
    function trim_zero($number)
    {
        return $number + 0;
    }
}


if (!function_exists('round_to_2dp')) {
    function round_to_2dp($number)
    {
        return number_format((float)$number, 2, '.', '');
    }
}

## Makes uppercase first character of a string keeping others smallercase
if (!function_exists('uc_first')) {
    function uc_first($str)
    {
        return ucfirst(strtolower($str));
    }
}

## Makes uppercase first character of each word keeping others in the word as smallercase
## example: o'connell converts to O'Connell.
if (!function_exists('uc_words')) {
    function uc_words($str)
    {
        return str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($str))));
    }
}

## converst mysql datetime format to viewable format
## example: converts 2017-01-31 13:05:59 to 31/01/17 1:05 PM
if (!function_exists('nice_datetime')) {
    function nice_datetime($datetime)
    {
        return date("j M, Y g:i A", strtotime($datetime));
    }
}
if (!function_exists('nice_time')) {
    function nice_time($datetime)
    {
        return date("g:i A", strtotime($datetime));
    }
}

## converst mysql datetime format to viewable format
## example: converts 2017-11-04 to 4 Nov, 2017
if (!function_exists('nice_date')) {
    function nice_date($date)
    {
        return date("j M, Y", strtotime($date));
    }
}


## converst mysql datetime format to viewable format
## example: converts 2017-11-04 to 4 Nov, 2017
if (!function_exists('date_diff')) {
    function date_diff($start, $end)
    {
        $diff = $end->diff($start)->format("%a");
        return $diff;
    }
}

if (!function_exists('get_file_extension')) {
    function get_file_extension($filename)
    {
        return @end(explode('.', $filename));
    }
}
if (!function_exists('get_url')) {
    function get_url()
    {
        // $actual_link = isset($_SERVER['HTTPS']) ? "https://" : "http://";
         $actual_link ="https://";
        $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $site_url = str_replace($actual_link, '', $url);
        return @current(explode('.', $site_url));
    }
}
if (!function_exists('set_currency')) {
    function set_currency($price='a')
    {
        $CI =& get_instance();
        $CI->load->model('common_model','common');

        $data = $CI->common->get_currency();
        $currency=$data[0]['param_val'];
        if($price=='a'){
            return $currency;
        }else if($price=='' ||$price=='0'){
            return ($data[0]['utilized_val']=='R')?'0.00 '.$currency:$currency.' 0.00';
        }
        else{
            return ($data[0]['utilized_val']=='R')?$price.' '.$currency:$currency.' '.$price;
        }

    }
}
if (!function_exists('set_js_currency')) {
    function set_js_currency()
    {
        $CI =& get_instance();
        $CI->load->model('common_model','common');

        $data = $CI->common->get_js_currency();
        return $data;
    }
}

## Formats unit of file/folder size from bytes to GB, MB, KB etc.
if (!function_exists('format_size_units')) {
    function format_size_units($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
if (!function_exists('sortData')) {
    function sortData($parm)
    {
        $price = array();
        foreach ($parm as $key => $row)
        {
            $price[$key] = $row['dtt_add'];
        }
        array_multisort($price, SORT_ASC, $parm);
        return $parm;
    }
}
if (!function_exists('arrayGroup')) {
    function arrayGroup($parm)
    {
        $data = array();
        for ($i = 0; $i < count($parm); $i++) {
            if(!in_array($parm[$i],$data)){
                array_push($data,$parm[$i]);
            }
        }
        return $data;
    }
}

