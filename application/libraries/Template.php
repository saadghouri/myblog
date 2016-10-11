a<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    private $data;
    private $js_file;
    private $css_file;
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('url');

        // default CSS and JS that they must be load in any pages

        // CSS FILES ADDED HERE
        //$this->addCSS(base_url('assets/css/custom.css'));
        
        // JS FILES ARE ADDED HERE
        //$this->addJS(base_url('assets/plugins/jquery/jquery.min.js'));
        $this->addCSS('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,800&amp;subset=cyrillic,latin');
        $this->addCSS(base_url('assets/plugins/bootstrap/css/bootstrap.min.css'));
        $this->addCSS(base_url('assets/css/shop.style.css'));
        $this->addCSS(base_url('assets/css/headers/header-v5.css'));
        $this->addCSS(base_url('assets/css/footers/footer-v4.css'));
        $this->addCSS(base_url('assets/plugins/animate.css'));
        $this->addCSS(base_url('assets/plugins/line-icons/line-icons.css'));
        $this->addCSS(base_url('assets/plugins/font-awesome/css/font-awesome.min.css'));
        $this->addCSS(base_url('assets/plugins/scrollbar/css/jquery.mCustomScrollbar.css'));
        $this->addCSS(base_url('assets/plugins/owl-carousel/owl-carousel/owl.carousel.css'));
        $this->addCSS(base_url('assets/plugins/revolution-slider/rs-plugin/css/settings.css'));
        $this->addCSS(base_url('assets/plugins/ladda-buttons/css/custom-lada-btn.css'));
        $this->addCSS(base_url('assets/css/theme-colors/default.css'));
        $this->addCSS(base_url('assets/plugins/master-slider/masterslider/style/masterslider.css'));
        $this->addCSS(base_url('assets/plugins/master-slider/masterslider/skins/default/style.css'));
        $this->addCSS(base_url('assets/plugins/bootstrap/css/bootstrap-social.css'));
        $this->addCSS(base_url('assets/plugins/text-angular/textAngular.css'));
        $this->addCSS(base_url('assets/css/custom.css'));
        
    }

    public function show($folder, $page, $data = null, $menu = true) {
        if (!file_exists('application/views/' . $folder . '/' . $page . '.php')) {
            show_404();
        } else {
            $this->data['page_var'] = $data;
            $this->loadJsAndCSS();
            $this->initMenu();

            if ($menu)
                $this->data['content'] = $this->CI->load->view('template/menu.php', $this->data, true);
            else
                $this->data['content'] = '';
            
            if ($this->CI->session->userdata('logged_in')) {
                $session_data = $this->CI->session->userdata('logged_in');
                $this->data['userLoggedIn'] = true;
                $this->data['userId'] = $session_data['userId'];
                
            } else {
                $this->data['userLoggedIn'] = false;
            }

            $this->data['content'] .= $this->CI->load->view($folder . '/' . $page . '.php', $this->data, true);
            $this->CI->load->view('template.php', $this->data);
        }
    }

    public function addJS($name) {
        $js = new stdClass();
        $js->file = $name;
        $this->js_file[] = $js;
    }

    public function addCSS($name) {
        $css = new stdClass();
        $css->file = $name;
        $this->css_file[] = $css;
    }

    private function loadJsAndCSS() {
        $this->data['html_head'] = '';

        if ($this->css_file) {
            foreach ($this->css_file as $css) {
                $this->data['html_head'] .= "<link rel='stylesheet' type='text/css' href=" . $css->file . ">" . "\n";
            }
        }

        if ($this->js_file) {
            foreach ($this->js_file as $js) {
                $this->data['html_head'] .= "<script type='text/javascript' src=" . $js->file . "></script>" . "\n";
            }
        }
    }

    private function initMenu() {
        // your code to init menus
        // it's a sample code you can init some other part of your page
    }

}
