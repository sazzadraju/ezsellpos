<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auto_increment extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * UPDATES val for a keyword
     * 
     * @param string $keyword
     * @param int $new_val
     * @param int $old_val
     * @param int $store_id
     * @return boolean
     */
    public function updAutoIncKey($keyword, $new_val, $old_val, $store_id = 0) {

        if ($new_val == $old_val) {
            $new_val = $new_val + 1;
        }

        if (($old_val + 1) == $new_val) {
            $this->db->where('keyword', $keyword);
            if ($store_id > 0) {
                $this->db->where('store_id', $store_id);
            }
            $this->db->set('val', $new_val);
            $res = $this->db->update('config_auto_increments');
        } else {
            $res = false;
        }

        return $res;
    }

    /**
     * GET val for a keyword 
     * 
     * @param string $keyword
     * @param string $ref_tbl
     * @param strin $ref_col
     * @param int $store_id
     * @return int
     */
    public function getAutoIncKey($keyword, $ref_tbl = '', $ref_col = '', $store_id = 0) {

        $val = null;

        $this->db->select('val');
        $this->db->from('config_auto_increments');
        $this->db->where('keyword', $keyword);
        if ($store_id > 0) {
            $this->db->where('store_id', $store_id);
        }
        $query = $this->db->get();
        if ($query->num_rows()) {
            $res = $query->row_array();
            $val = $res['val'];
            if (!empty($ref_tbl) && !empty($ref_col)) {
                $val = $this->confirmValUnique($keyword, $val, $ref_tbl, $ref_col, $store_id);
            }
        }

        return $val;
    }

    /**
     * Confirms the value is unique. if not finds next incremental unique value
     * 
     * @param int $val
     * @param string $ref_tbl
     * @param string $ref_col
     * @param int $store_id
     * @return int
     */
    public function confirmValUnique($keyword, $val, $ref_tbl = '', $ref_col = '', $store_id = 0) {
        $i = 0;
        $new_val = $val;
        do {
            $i++;
            if ($this->chkValExists($new_val, $ref_tbl, $ref_col, $store_id)) {
                //echo $new_val.' exists<br>';
                $exists = true;
                $new_val = $new_val + 1;
            } else {
                //echo $new_val.' does not exist<br>';
                $exists = false;
            }
            // stop checking after looping 25 times to prevent infinite looping
            if ($i > 25) {
                break;
            }
        } while ($exists != false);

        if ($new_val != $val) {
            // Update in config table
            $this->_updConfigParam($keyword, $new_val, $store_id);
        }

        return $new_val;
    }

    private function _updConfigParam($key, $val, $store_id = 0) {
        $this->db->where('keyword', $key);
        if ($store_id > 0) {
            $this->db->where('store_id', $store_id);
        }
        $this->db->set('val', $val);
        $this->db->update('config_auto_increments');
    }

    /**
     * Checks if a value exists
     * 
     * @param int $val
     * @param string $ref_tbl
     * @param string $ref_col
     * @param int $store_id
     * @return boolean
     */
    public function chkValExists($val, $ref_tbl = '', $ref_col = '', $store_id = 0) {

        $this->db->select("1");
        $this->db->from($ref_tbl);
        $this->db->where($ref_col, $val);
        if ($store_id > 0) {
            $this->db->where('store_id', $store_id);
        }
        $query = $this->db->get();
        return $query->num_rows() ? true : false;
    }

    public function grabUniqueKey($keyword, $ref_tbl = '', $ref_col = '', $store_id = 0) {

        $val = null;

        $this->db->select('val');
        $this->db->from('config_auto_increments');
        $this->db->where('keyword', $keyword);
        if ($store_id > 0) {
            $this->db->where('store_id', $store_id);
        }
        $query = $this->db->get();
        if ($query->num_rows()) {
            $res = $query->row_array();
            $val = $res['val'];
            if (!empty($ref_tbl) && !empty($ref_col)) {
                $val = $this->confirmValUnique($keyword, $val, $ref_tbl, $ref_col, $store_id);
            }
        }
        
        $this->_updConfigParam($keyword, ($val+1), $store_id);

        return $val;
    }
}
