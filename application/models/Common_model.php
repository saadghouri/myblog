<?php

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * This function is used to get single row from the table
     * @param string $table name of the table
     * @param array $data array of columns to get or "*" to return all rows
     * @param string $field name of column
     * @param string $id value of column
     * @param int $limit number of rows to return
     * @param int $offset
     * @return array
     */
    function getSingleRowFields($table, $data, $field, $id, $limit = 0, $offset = 0) {
        $this->db->select($data);
        $this->db->where($field, $id);
        if ($limit != 0 && $offset == 0)
            $this->db->limit($limit);
        if ($limit != 0 && $offset != 0)
            $this->db->limit($limit, $offset);
        $query = $this->db->get($table);
        $result = $query->result();
        if (count($result) == 0)
            return 0;
        else
            return $result[0];
    }

    /**
     * This function is used to get the single row of the table based on the array
     * @param string $table name of the table
     * @param array $data array of columns to get or "*" to return all rows
     * @param string $where array of multiple conditions
     * @param int $limit number of rows to return
     * @param int $offset
     * @return array
     */
    function getSingleRowFieldsWhereArr($table, $data, $where, $limit = 0, $offset = 0) {
        $this->db->select($data);
        $this->db->where($where);
        if ($limit != 0 && $offset == 0)
            $this->db->limit($limit);
        if ($limit != 0 && $offset != 0)
            $this->db->limit($limit, $offset);
        $query = $this->db->get($table);
        $result = $query->result();
        if (count($result) == 0)
            return 0;
        else
            return $result[0];
    }

    function getSingleFieldsWhereArrOrNull($table, $fieldName, $where, $limit = 0, $offset = 0) {
        $this->db->select($fieldName);
        $this->db->where($where);
        if ($limit != 0 && $offset == 0)
            $this->db->limit($limit);
        if ($limit != 0 && $offset != 0)
            $this->db->limit($limit, $offset);
        $query = $this->db->get($table);
        $result = $query->result();
        if (count($result) == 0)
            return null;
        else
            return $result[0]->$fieldName;
    }

    function getSingleFieldsWhereArr($table, $fieldName, $where, $limit = 0, $offset = 0, $orderBy = false) {
        $this->db->select($fieldName);
        $this->db->where($where);
        if ($limit != 0 && $offset == 0)
            $this->db->limit($limit);
        if ($limit != 0 && $offset != 0)
            $this->db->limit($limit, $offset);
        if ($orderBy){
            $this->db->order_by($orderBy);
        }
        
        $query = $this->db->get($table);
        $result = $query->result();
        
        if (count($result) == 0)
            return 0;
        else
            return $result[0]->$fieldName;
    }

    function updateRowsWhereArr($table, $data, $where, $where_in = false) {
        $this->db->where($where);
        if($where_in) {
            $this->db->where_in($where_in);
        }
        $result = $this->db->update($table, $data);
        return $result;
    }

    function insertRow($table, $data) {
        $this->db->insert($table, $data);
        $lastInsertId = $this->db->insert_id();
        return $lastInsertId;
    }

    function getRows($table, $data, $field, $id, $limit = 0, $offset = 0) {
        $this->db->select($data);
        $this->db->where($field, $id);
        if ($limit != 0 && $offset == 0)
            $this->db->limit($limit);
        if ($limit != 0 && $offset != 0)
            $this->db->limit($limit, $offset);
        $query = $this->db->get($table);
        $result = $query->result();
        if (count($result) == 0)
            return 0;
        else
            return $result;
    }

    function getRowsWhereArr($table, $data, $where = false, $limit = 0, $offset = 0 , $orderBy = false, $where_in = false) {
        $this->db->select($data);
        if($where){
            $this->db->where($where);
        }
        if($where_in){
            $this->db->where_in($where_in);
        }
        if ($limit != 0 && $offset == 0)
            $this->db->limit($limit);
        if ($limit != 0 && $offset != 0)
            $this->db->limit($limit, $offset);
        if($orderBy){
            $this->db->order_by($orderBy);
        }
        $query = $this->db->get($table);
        $result = $query->result();

        if (count($result) == 0)
            return 0;
        else
            return $result;
    }

    function getDescRowsWhereArr($table, $data, $where, $orderBy, $limit = 0, $offset = 0) {
        $this->db->select($data);
        $this->db->where($where);
        $this->db->order_by($orderBy, "desc");
        if ($limit != 0 && $offset == 0)
            $this->db->limit($limit);
        if ($limit != 0 && $offset != 0)
            $this->db->limit($limit, $offset);


        $query = $this->db->get($table);
        $result = $query->result_array();
        if (count($result) == 0)
            return 0;
        else
            return $result;
    }

    function getRowCount($table, $where) {
        $this->db->where($where);
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') == $date;
    }

    public function resize_image($source_path, $target_path) {
        $this->load->library('image_lib');
        $this->image_lib->clear();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_path;
        $config['new_image'] = $target_path;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 400;
        $config['height'] = 400;

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            return false;
        } else {
            return true;
        }
        $this->image_lib->clear();
    }

    public function create_thumb($source_path, $target_path) {
        $this->load->library('image_lib');
        $this->image_lib->clear();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source_path;
        $config['new_image'] = $target_path;
        $config['create_thumb'] = FALSE;
        $config['thumb_marker'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        //$config['width'] = 350;
        $config['height'] = 350;

        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {
            return false;
        } else {
            return true;
        }
        $this->image_lib->clear();
    }

    public function ago($time) {

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $difference = $now - $time;
        $tense = "ago";

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j].= "s";
        }
        return "$difference $periods[$j] ago";
    }

    public function from_now($time) {

        $translation_model = $this->model_load_model('translation_model');
        $translation_arr = $translation_model->get_translated_array(true);

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $now = time();

        $deadlinePassed = false;
        if ($time > $now) {
            $difference = $time - $now;
        } else {
            $difference = $now - $time;
            $deadlinePassed = true;
        }
        $tense = "ago";

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j].= "s";
        }

        if ($deadlinePassed) {
            return $translation_arr['label']['deadline_passed'] . " " . $difference . " " . $periods[$j] . " " . $translation_arr['label']['ago'];
        } else {
            return $difference . " " . $periods[$j] . " " . $translation_arr['label']['from_now'];
        }
    }

    public function response_json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    public function rotate_image($source_path, $orientation) {
        log_message('debug', 'Rotating Image: ' . $orientation);
        if ($orientation != 1) {
            $this->load->library('image_lib');
            $this->image_lib->clear();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $source_path;
            $config['new_image'] = $source_path;
            if ($orientation == 8)
                $config['rotation_angle'] = '90';
            else if ($orientation == 3)
                $config['rotation_angle'] = '180';
            else if ($orientation == 6)
                $config['rotation_angle'] = '270';
            else
                return true;
            log_message('debug', 'Rotating Image: Angle: ' . $config['rotation_angle']);
            $this->image_lib->initialize($config);
            if (!$this->image_lib->rotate()) {
                return false;
            } else {
                return true;
            }
            $this->image_lib->clear();
        } else {
            return true;
        }
    }

    /**
     * Check If the date is last day of the month
     * @param date $date
     * @return boolean
     */
    public function check_last_date_of_month($date) {
        if ($date == "") {
            return false;
        }

        $checkdate = date('d-m-Y', strtotime($date));
        $lastDate = date('t-m-Y', strtotime($date));

        if ($lastDate == $checkdate) {
            return true;
        } else {
            return false;
        }
    }

    public function getInnerJoin($table1, $table2, $data, $joinon, $where, $limit , $limitStart) {
        $this->db->select($data)
                ->from($table1)
                ->join($table2, $joinon)
                ->where($where)
                ->limit($limit,$limitStart);
        $query = $this->db->get();
        return $query->result();
    }

    public function getInnerJoinCount($table1, $table2, $data, $joinon, $where) {
        $this->db->select("COUNT(".$data.") as total")
                ->from($table1)
                ->join($table2, $joinon)
                ->where($where);
        $query = $this->db->get();
        $result = $query->result();
        
        return $result[0]->total;
    }

    public function getLeftJoin($table1, $table2, $data, $joinon, $where) {
        $this->db->select($data)
                ->from($table1)
                ->join($table2, $joinon, 'left')
                ->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    function getMax($table, $fieldName, $where) {
        $this->db->select_max($fieldName, 'value');
        $this->db->where($where);
        $query = $this->db->get($table);
        $result = $query->result();
        if (count($result) == 0)
            return 0;
        else
            return $result['value'];
    }

    function getMin($table, $fieldName, $where) {
        $this->db->select_min($fieldName, 'value');
        $this->db->where($where);
        $query = $this->db->get($table);
        $result = $query->result();
        if (count($result) == 0)
            return 0;
        else
            return $result['value'];
    }

    function base64_to_image_content($image) {
        $img = preg_replace('#^data:image/\w+;base64,#i', '', $image);
        //$img = str_replace('data:image/jpg;base64,', '', $image);
        //$img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        return $data;
    }

    function model_load_model($model_name) {
        $CI = & get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }

    public function convert_totime($sec) {

        $seconds = $sec;
        $ret = array();
        $divs = array(3600, 60, 1);

        for ($d = 0; $d < 3; $d++) {
            $q = $seconds / $divs[$d];
            $r = $seconds % $divs[$d];
            $ret[substr('hms', $d, 1)] = $q;

            $seconds = $r;
        }

        return sprintf("%dh, %dm, %ds\n", $ret['h'], $ret['m'], $ret['s']);
    }

    public function test_email($email) {
        $email = str_replace(' ', '', $email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else
            return false;
    }

    /*
     * This function checks if the string is a phone number
     */

    public function test_phone_no($string) {
        $phone_no = str_replace(' ', '', $string);
        $phone_no = str_replace('+', '', $phone_no);
        $phone_no = str_replace('(', '', $phone_no);
        $phone_no = str_replace(')', '', $phone_no);
        $phone_no = str_replace('-', '', $phone_no);
        if (is_numeric($phone_no)) {
            return $phone_no;
        } else {
            return false;
        }
    }

    /*
     * This function checks if the string is a name
     */

    public function test_name($string) {
        $regx = "/^[A-Za-z\s]{1,}[\.\-\']{0,1}[A-Za-z\s]{0,}$/";
        if (preg_match($regx, $string)) {
            return true;
        } else {
            return false;
        }
    }

    public function pagination_array($arr, $page, $toShow) {
        $total_result = count($arr);
        $index = $page * $toShow;
        if ($total_result < $toShow) {
            $arrayList = $arr;
        } else if ($index == 0 && $total_result >= $toShow) {
            $arrayList = array_slice($arr, $index, $toShow);
        } else if ($total_result >= $index) {
            $selected_element_length = $total_result - $toShow;
            $arrayList = array_slice($arr, $index, $selected_element_length > $toShow ? $toShow : $selected_element_length);
        } else {
            $arrayList = array();
        }

        return $arrayList;
    }

    public function get_time_different($from, $to) {
        $to_time = strtotime($to);
        $from_time = strtotime($from);
        return round(abs($to_time - $from_time) / 60, 2);
    }

    /**
     * This function is used to get difference in months between two dates
     * @param date $date_1 first date
     * @param date $date_2 sencond date
     * @return int
     */
    public function dateDifferenceMonth($date_1, $date_2) {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($interval->m + 12 * $interval->y);
    }

    /**
     * This function is used remove spaces and special characters from a string.
     * @param string $string string to clean
     * @return string
     */
    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
    }

    /**
     * This function is used to send asyn curl request
     * @param string $detailUrl url to send curl request
     * @param string $requestParameter parameters
     * @return int
     */
    function sendAsyncCurlRequest($detailUrl, $requestParameter) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $detailUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestParameter));
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_exec($ch);
        //$response = json_decode(curl_exec($ch), true);
        return 1;
    }
    
    /**
     * This function is used to convert months to years format
     * @param string $months number of months
     * @return int
     */
    function monthsToYearMonth($months){
        $result = "";

        $years = floor($months / 12);
        if ($years != 0) {
            $result = $years . ($years == 1 ? " year " : " years ");
        }
        if ($months % 12 != 0) {
            $months = $months % 12;
            $result .= $months . ($months == 1 ? " month" : " months");
        }
        return $result;
    }
    
    /**
     * This function is used to get order index of faq section
     * @return int
     */
    function getFaqSectionNewOrderIndex(){
        $query = "SELECT max(orderIndex) as orderIndex from faq_sections where deleted != 1";
        $result = $this->db->query($query)->result();
        
        if(count($result) == 0 ){
            return 1;
        } else {
            return $result[0]->orderIndex + 1;
        }
    }
    
    /**
     * This function is used to get new order index of faq section question
     * @param string $faqSectionId faq section id
     * @return int
     */
    function getFaqSectionQuestionNewOrderIndex($faqSectionId){
        $query = "SELECT max(orderIndex) as orderIndex from faqs where deleted != 1 and faqSectionId = ".$faqSectionId;
        $result = $this->db->query($query)->result();
        
        if(count($result) == 0 ){
            return 1;
        } else {
            return $result[0]->orderIndex + 1;
        }
    }
    
    /**
     * This function is used to delete faq section
     * @param string $faqId faq id
     * @param array $data array of columns to update
     * @return boolean
     */
    function deleteFaqQuestion($faqId, $data) {
        $this->updateRowsWhereArr('faqs', $data, array('faqId' => $faqId));
        $orderIndex = $this->getSingleFieldsWhereArr('faqs', 'orderIndex', array('faqId' => $faqId));

        
        $updateOrderIndexQuery = "UPDATE faqs SET orderIndex = orderIndex - 1 WHERE deleted != 1 AND orderIndex > ".$orderIndex;
        return $this->db->query($updateOrderIndexQuery);
    }
    
    /**
     * This function is used to delete faq section
     * @param string $faqSectionId faq Section id
     * @param array $data array of columns to update
     * @return boolean
     */
    function deleteFaqSection($faqSectionId, $data) {
        $this->updateRowsWhereArr('faq_sections', $data, array('faqSectionId' => $faqSectionId));
        $orderIndex = $this->getSingleFieldsWhereArr('faq_sections', 'orderIndex', array('faqSectionId' => $faqSectionId));

        
        $updateOrderIndexQuery = "UPDATE faq_sections SET orderIndex = orderIndex - 1 WHERE deleted != 1 AND orderIndex > ".$orderIndex;
        return $this->db->query($updateOrderIndexQuery);
    }

}
