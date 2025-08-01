<?php

class Dynamic_menu {

    private $ci;            // para CodeIgniter Super Global Referencias o variables globales
    private $id_menu = 'id="menu"';
    private $class_menu = 'class="main-menu"';
    private $class_parent = 'class="has-sub-menu"';
    private $class_chield = 'class="sub-menu"';
    private $class_last = 'class="last"';

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->database();
        $this->ci->load->library('session');
    }

    function build_menu() {
        $parent = '';
        $child = '';
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $site_url = str_replace(base_url(), '', $actual_link);
        $this->ci->db->select('id_acl_module,parent_id');
        $this->ci->db->where('rel_url', $site_url);
        $this->ci->db->where('status_id', 1);
        $queryRes = $this->ci->db->get('acl_modules');
        $result = $queryRes->row();

        if ($result) {
            $parent = $result->parent_id;
            $child = $result->id_acl_module;
        }
        $menu = array();
        $query= $this->_module_array();
        $html_out = '<ul ' . $this->class_menu . '>';
        foreach ($query as $row) {
            $id = $row->id_acl_module;
            $title = $row->mod_name;
            $icon = $row->mod_icon;
            $url_id = $row->rel_url;
            $active = $row->status_id;
            $parent_id = $row->parent_id;
            $div_icon = '<div class="icon-w">' . $icon . '</div>';
            $url = base_url() . $url_id;
            $class_pr = ($parent == $row->id_acl_module) ? 'class="has-sub-menu active"' : $this->class_parent; {
                if ($active == 1) {
                    if ($parent_id == NULL) {
                        $html_out .= '<li ' . $class_pr . '>' . anchor($url, $div_icon . '<span>' . $title . '</span>', 'name="' . $title . '"');
                    } else {
                        $html_out .= '<li>' . anchor($url, '<span>' . $title . '</span>', 'name="' . $title . '"');
                    }
                }
            }
            $html_out .= $this->get_childs($id, $child);
        }

        $html_out .= '</li>';
        $html_out .= '</ul>';
        return $html_out;
    }
    function build_menu_mobile() {
        $parent = '';
        $child = '';
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $site_url = str_replace(base_url(), '', $actual_link);
        $this->ci->db->select('id_acl_module,parent_id');
        $this->ci->db->where('rel_url', $site_url);
        $this->ci->db->where('status_id', 1);
        $queryRes = $this->ci->db->get('acl_modules');
        $result = $queryRes->row();

        if ($result) {
            $parent = $result->parent_id;
            $child = $result->id_acl_module;
        }
        $menu = array();
        $query= $this->_module_array();
        $html_out='';
        foreach ($query as $row) {
            $id = $row->id_acl_module;
            $title = $row->mod_name;
            $icon = $row->mod_icon;
            $url_id = $row->rel_url;
            $active = $row->status_id;
            $parent_id = $row->parent_id;
            $url = base_url() . $url_id;
            $html_out .= '<div class="col-list">';
            $html_out .= '<div class="list">';
            $html_out .= $icon;
            $html_out .='<p>'.$title.'</p>';
            $html_out .= '</div>';
            $html_out .= $this->get_child_mobile($id, $child);
            $html_out .= '</div>';
        }
        return $html_out;
    }
    function get_child_mobile($id, $child) {
        $has_subcats = FALSE;
        $html_out = '';
        $querySub= $this->_sub_module_array();
        $html_out .= '<div class="submenu">';
        $html_out .= '<div class="sb-menu-back">';
        $html_out .= '<i class="fa fa-arrow-left" aria-hidden="true"></i>';
        $html_out .= '</div>';
        $dataArray = array();
        foreach ($querySub as $row) {
            if ($row->parent_id == $id) {
                $dataArray[] = $row;
            }
        }
        $html_out .= '<ul>';
        foreach ($dataArray as $rowVal) {
            $id = $rowVal->id_acl_module;
            $title = $rowVal->mod_name;
            $url = $rowVal->rel_url;
            $class_ch = ($child == $rowVal->id_acl_module) ? 'class="active"' : '';
            $has_subcats = TRUE;
            $html_out .= '<li>' . anchor($url, $title, 'name="' . $title . '"' . $class_ch).'</li>';
        }
        $html_out .= '</ul>';
        $html_out .= '</div>';
        return ($has_subcats) ? $html_out : FALSE;
    }

    function get_childs($id, $child) {
        $has_subcats = FALSE;

        $html_out = '';
        $querySub= $this->_sub_module_array();
        $html_out = '<ul ' . $this->class_chield . '>';
        //$query = $this->ci->db->query("select * from acl_modules where parent_id = $id");
        // echo '<pre>';
        //print_r($querySub);
        // echo '</pre>';
        $dataArray = array();
        foreach ($querySub as $row) {
            if ($row->parent_id == $id) {
//                echo $row->id_acl_module;
//                echo $id;
//                echo '<br>';
                $dataArray[] = $row;
            }
        }
//        echo '<pre>';
//        //print_r($dataArray);
//        echo '</pre>';
        foreach ($dataArray as $rowVal) {
            $id = $rowVal->id_acl_module;
            $title = $rowVal->mod_name;
            $url = $rowVal->rel_url;
            $class_ch = ($child == $rowVal->id_acl_module) ? 'class="active"' : '';
            $has_subcats = TRUE;
            $blank=($title=='Sales')?' target=_blank':'';
            $html_out .= '<li>' . anchor($url, $title, 'name="' . $title . '"' . $class_ch.$blank);
        }
        $html_out .= '</li>';
        $html_out .= '</ul>';

        return ($has_subcats) ? $html_out : FALSE;
    }

    private function _sub_module_array() {
        if ($this->ci->session->userdata['login_info']['user_type_i92'] == 3) {
            $cacheSubModuel = 'acl_sub_module';
            if (!$querySub = $this->ci->cache->get($cacheSubModuel)) {
                $this->ci->db->where('parent_id!=', NULL);
                $this->ci->db->where('status_id', 1);
                $this->ci->db->order_by("sort asc");
                $que2 = $this->ci->db->get('acl_modules');
                $querySub = $que2->result();
                $this->ci->cache->save($cacheSubModuel, $querySub, 3600);
            }
        } else {
            $sub_user_id = $this->ci->session->userdata['login_info']['id_user_i90'];
            $cache = 'acl_sub_module_id_' . $sub_user_id;
            if (!$querySub = $this->ci->cache->get($cache)) {
                $this->ci->db->where('user_id', $sub_user_id);
                $this->ci->db->where('status_id', 1);
                $this->ci->db->order_by("sort asc");
                $que2 = $this->ci->db->get('acl_access_submodule');
                $querySub = $que2->result();
                $this->ci->cache->save($cache, $querySub, 900);
            }
        }
        return $querySub;
    }
    private function _module_array(){
        $this->ci->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
        // $this->ci->load->driver('cache', array('adapter' => 'file'));

        if ($this->ci->session->userdata['login_info']['user_type_i92'] == 3) {
            $cacheModuel = 'acl_module';
            if (!$query = $this->ci->cache->get($cacheModuel)) {
                $this->ci->db->where('parent_id', NULL);
                $this->ci->db->where('status_id', 1);
                $this->ci->db->order_by('sort', asc);
                $que2 = $this->ci->db->get('acl_modules');
                $query = $que2->result();
                $this->ci->cache->save($cacheModuel, $query, 3600);
            }
        } else {
            $id = $this->ci->session->userdata['login_info']['id_user_i90'];
            $cache = 'acl_module_id_' . $id;
            if (!$query = $this->ci->cache->get($cache)) {
                $this->ci->db->where('user_id', $id);
                $this->ci->db->where('status_id', 1);
                $this->ci->db->group_by('id_acl_module');
                $this->ci->db->order_by("sort asc");
                $que2 = $this->ci->db->get('acl_access_module');
                $query = $que2->result();
                $this->ci->cache->save($cache, $query, 900);
            }
        }
        return $query;
    }
    public function check_menu($url=null){
        if($url){
            $type_id = $this->ci->session->userdata['login_info']['user_type_i92'];
            $user_id = $this->ci->session->userdata['login_info']['id_user_i90'];
            if ($type_id != 3) {
                $this->ci->db->where('user_id', $user_id);
                $this->ci->db->where('rel_url', $url);
                $this->ci->db->where('status_id', 1);
                $query = $this->ci->db->get('acl_access_submodule');

                if($query->num_rows() > 0){
                    //echo ' success connection data';
                    return true;
                }else{
                    redirect('error-page');
                }
            }
           // return $id;
        }
        return TRUE;

    }

}
