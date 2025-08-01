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
    }

    function build_menu() {
        $parent='';
        $child='';
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $site_url = str_replace(base_url(), '', $actual_link);
        $this->ci->db->select('id_acl_module,parent_id');
        $this->ci->db->where('rel_url',$site_url);
         $this->ci->db->where('status_id',1);
        $queryRes = $this->ci->db->get('acl_modules');
        $result = $queryRes->row();
        
        if($result){
           $parent = $result->parent_id; 
           $child = $result->id_acl_module;
        }
        

        $menu = array();
        $this->ci->db->where('parent_id',NULL);
        $query = $this->ci->db->get('acl_modules');
       // $query = $this->ci->db->query("select * from acl_modules where parent_id is NULL");


        $html_out = '<ul ' . $this->class_menu . '>';

//`id_acl_module``mod_name` `mod_icon` `parent_id` `sort` `rel_url` `is_active`
        // me despliega del query los rows de la base de datos que deseo utilizar
        foreach ($query->result() as $row) {
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
                        // CodeIgniter's anchor(uri segments, text, attributes) tag.

                        $html_out .= '<li ' . $class_pr . '>' . anchor($url, $div_icon . '<span>' . $title . '</span>', 'name="' . $title . '"');
                    } else {
                        $html_out .= '<li>' . anchor($url, '<span>' . $title . '</span>', 'name="' . $title . '"');
                    }
                }
            }
            $html_out .= $this->get_childs($id,$child);
            // print_r($id);
        }
        // loop through and build all the child submenus.

        $html_out .= '</li>';
        $html_out .= '</ul>';
        return $html_out;
    }

    function get_childs($id,$child) {
        $has_subcats = FALSE;

        $html_out = '';
        $html_out = '<ul ' . $this->class_chield . '>';
        $query = $this->ci->db->query("select * from acl_modules where parent_id = $id");

        foreach ($query->result() as $row) {
            $id = $row->id_acl_module;
            $title = $row->mod_name;
            $url = $row->rel_url;
            $class_ch = ($child == $row->id_acl_module) ? 'class="active"' : '';
            $has_subcats = TRUE;
            $html_out .= '<li>' . anchor($url, $title, 'name="' . $title . '"'.$class_ch);
        }
        $html_out .= '</li>';
        $html_out .= '</ul>';

        return ($has_subcats) ? $html_out : FALSE;
    }

}
