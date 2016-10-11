<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->library('template');
    }

    function index() {
        echo 'Access Denied';
        exit;
    }

    /*=====================================================================*/
    /*                            ABOUT US PAGE                            */
    /*=====================================================================*/
    
    /**
     * This function gets about us description of about us page.<br/>
     */
    function getAboutUsDesc() {
        $errors = array();
        $success = array();
        //get about us description
        $desc = $this->common_model->getSingleFieldsWhereArr('global_variables', 'aboutUsDesc', array('id' => 1));

        $success['message'] = "Changes saved successfully";
        $success['data'] = array('aboutUsDesc' => $desc);

        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    /**
     * This function saves about us description sent from about us page.<br/>
     * Data Required: description
     */
    function saveAboutUsDesc() {
        $errors = array();
        $success = array();

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $isAdmin = $session_data['isAdmin'];
            if ($isAdmin) {//if user is an admin, save description in database
                $description = @$_POST['description'];
                if ($description) {//if description is not empty, save in db 
                    $data = array(
                        'aboutUsDesc' => $description
                    );
                    //update about us description
                    $this->common_model->updateRowsWhereArr('global_variables', $data, array('id' => 1));

                    $success['message'] = "Changes saved successfully";
                } else {//if description is not provided show error.
                    $errors['message'] = "Invalid Data. Contact admin for more details.";
                }
            } else {//if user is not an admin show error.
                $errors['message'] = "You don't have permission to perform this operation.";
            }
        } else {//if user is not logged in show error.
            $errors['message'] = "Invalid Request";
        }


        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }
    
    /*=====================================================================*/
    /*                               FAQ PAGE                              */
    /*=====================================================================*/
    
    /**
     * This function gets list of all faqs<br/>
     */
    function getAllFaqs() {
        $errors = array();
        $success = array();

        $faqs = array();
        //get list of faq sections
        $faqSections = $this->common_model->getRowsWhereArr('faq_sections', '*', array('deleted' => '0'),0,0,'orderIndex');
        if ($faqSections) {//if there is any section specified, get list of faqs
            foreach ($faqSections as $faqSection) {//loop through each faq section and get list of faqs
                //get list of questions in faq section
                $faqSectionQuestions = $this->common_model->getRowsWhereArr('faqs', '*', array('deleted' => '0', 'faqSectionId' => $faqSection->faqSectionId),0,0,'orderIndex');
                $faqSection->questions = $faqSectionQuestions;
                $faqs[] = $faqSection;
            }
        }

        $success['message'] = "Loaded successfully";
        $success['data'] = array('faqs' => $faqs);

        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    /**
     * This function adds a new faq section<br/>
     * Data Required: sectionDesc
     */
    function addNewFaqSection() {
        $errors = array();
        $success = array();

        if ($this->session->userdata('logged_in')) { //check if user is logged in, and add new faq section
            $session_data = $this->session->userdata('logged_in');
            $isAdmin = $session_data['isAdmin'];
            if ($isAdmin) {//if user is an admin, add new faq section
                $sectionDesc = @$_POST['sectionDesc'];
                //get faq sections new order index
                $orderIndex = $this->common_model->getFaqSectionNewOrderIndex();
                if ($sectionDesc) {// if section desc is specified, save description
                    $data = array(
                        'faqSectionDescription' => $sectionDesc,
                        'timestampAdded' => date("Y-m-d H:i:s"),
                        'addedById' => $session_data['userId'],
                        'orderIndex' => $orderIndex,
                        'deleted' => 0
                    );
                    //add new row in the db
                    $this->common_model->insertRow('faq_sections', $data);

                    $success['message'] = "Section Added Successfully";
                } else {// show error if section description is not provided 
                    $errors['message'] = "Invalid Data. Contact admin for more details.";
                }
            } else {//show error if user is not an admin
                $errors['message'] = "You don't have permission to perform this operation.";
            }
        } else {// show error if user is not logged in
            $errors['message'] = "Invalid Request";
        }


        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    /**
     * This function adds a new question to faq section<br/>
     * Data Required: newFaqQuestion, newFaqAnswer, faqSectionId
     */
    function addNewQuestionSection() {
        $errors = array();
        $success = array();

        if ($this->session->userdata('logged_in')) { //check if user is logged in, if so, add new question section
            $session_data = $this->session->userdata('logged_in');
            $isAdmin = $session_data['isAdmin'];
            if ($isAdmin) { //if user is not admin
                $faqContent = @$_POST['newFaqQuestion'];
                $faqAnswer = @$_POST['newFaqAnswer'];
                $faqSectionId = @$_POST['faqSectionId'];
                
                //get the new order index of faq section question
                $orderIndex = $this->common_model->getFaqSectionQuestionNewOrderIndex($faqSectionId);
                if ($faqContent && $faqAnswer) {//if question and answer are not empty or null, add in the database
                    $data = array(
                        'faqSectionId' => $faqSectionId,
                        'faqContent' => $faqContent,
                        'faqAnswer' => $faqAnswer,
                        'timestampAdded' => date("Y-m-d H:i:s"),
                        'addedById' => $session_data['userId'],
                        'orderIndex' => $orderIndex,
                        'deleted' => 0
                    );
                    $this->common_model->insertRow('faqs', $data);

                    $success['message'] = "Question Added Successfully";
                } else {//show error if question or answer are empty.
                    $errors['message'] = "Invalid Data. Contact admin for more details.";
                }
            } else {// show error if user is not an admin.
                $errors['message'] = "You don't have permission to perform this operation.";
            }
        } else {//show error if user is not logged in.
            $errors['message'] = "Invalid Request";
        }


        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    /**
     * This function deletes faq question<br/>
     * Data Required: faqId
     */
    function deleteFaqQuestion() {
        $errors = array();
        $success = array();

        if ($this->session->userdata('logged_in')) { //check if user is logged in, delete question
            $session_data = $this->session->userdata('logged_in');
            $isAdmin = $session_data['isAdmin'];
            if ($isAdmin) {// if user is an admin, delete question
                $faqId = @$_POST['faqId'];
                if ($faqId) { //if faqId is not empty, set deleted = 1
                    $data = array(
                        'deleted' => 1,
                        'deletedBy' => $session_data['userId'],//user who performed this action
                        'timestampDeleted' => date("Y-m-d H:i:s")//current timestamp
                    );
                    
                    $this->common_model->deleteFaqQuestion($faqId, $data);

                    $success['message'] = "Question Deleted Successfully";
                } else {// show error if faqId is empty
                    $errors['message'] = "Invalid Data. Contact admin for more details.";
                }
            } else {//show error if user is not an admin
                $errors['message'] = "You don't have permission to perform this operation.";
            }
        } else {// show error if user is not logged in
            $errors['message'] = "Invalid Request";
        }


        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    /**
     * This function deletes faq section<br/>
     * Data Required: faqSectionId
     */
    function deleteFaqSection() {
        $errors = array();
        $success = array();
        
        if ($this->session->userdata('logged_in')) { //check if user is logged in. If so, get section Id and delete it
            $session_data = $this->session->userdata('logged_in');
            $isAdmin = $session_data['isAdmin'];
            if ($isAdmin) {// if user is an admin
                $faqSectionId = @$_POST['faqSectionId'];
                if ($faqSectionId) {//if faqSectionid is not null
                    $data = array(
                        'deleted' => 1,
                        'deletedBy' => $session_data['userId'],
                        'timestampDeleted' => date("Y-m-d H:i:s")
                    );
                    
                    $this->common_model->deleteFaqSection($faqSectionId, $data);

                    $success['message'] = "Section Deleted Successfully";
                } else {//show error if faqSectionId is null
                    $errors['message'] = "Invalid Data. Contact admin for more details.";
                }
            } else {//show error if user is not an admin
                $errors['message'] = "You don't have permission to perform this operation.";
            }
        } else {//show error if user is not logged in
            $errors['message'] = "Invalid Request";
        }


        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }
    
    /**
     * This function modifies all faqs from edit page<br/>
     * Data Required: editFaqs
     */
    function saveAllFaqEditPage() {
        $errors = array();
        $success = array();
        
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $isAdmin = $session_data['isAdmin'];
            if ($isAdmin) {//if user is an admin
                $faqData = @$_POST['editFaqs'];
                if ($faqData) {//if faq list is not empty
                    foreach ($faqData as $faq) {//loop through each faq and update info in database
                        $data = array(
                            'faqSectionDescription' => $faq['faqSectionDescription']
                        );

                        $this->common_model->updateRowsWhereArr('faq_sections', $data, array('faqSectionId' => $faq['faqSectionId']));


                        foreach ($faq['questions'] as $question) {//loop through each question in a section and update info
                            if($question['faqContent'] != "" && $question['faqAnswer'] != "") {//if question and answer is not empty
                                $data = array(
                                    'faqContent' => $question['faqContent'],
                                    'faqAnswer' => $question['faqAnswer']
                                );

                                $this->common_model->updateRowsWhereArr('faqs', $data, array('faqId' => $question['faqId']));
                            }
                        }
                    }

                    $success['message'] = "Information Updated Successfully";
                } else {//show error if faq list is not provided
                    $errors['message'] = "Invalid Data. Contact admin for more details.";
                }
            } else {//show error if user is not an admin
                $errors['message'] = "You don't have permission to perform this operation.";
            }
        } else {// show error if user is not logged in
            $errors['message'] = "Invalid Request";
        }


        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }
    
    /**
     * This function reorders faq section<br/>
     * Data Required: reorderSectionEditFaqs
     */
    function reorderSection(){
        $success = array();
        $errors = array();
        
        $reorderSectionEditFaqs = @$_POST['reorderSectionEditFaqs'];
        
        if($reorderSectionEditFaqs){//if faq section list is not empty, reorder the list in an order provided
            $i = 1;
            foreach($reorderSectionEditFaqs as $faqSection){//loop through each faq section and update section info
                $data = array(
                    'orderIndex' => $i
                );
                $this->common_model->updateRowsWhereArr('faq_sections',$data, array('faqSectionId'=>$faqSection['faqSectionId']));
                $i++;
            }
            
            $success['message'] = "Updated successfully";
            
        } else {// if faq section is empty show error
            $errors['message'] = "Error updating. Please contact admin for more details.";
        }
        
        
        if(count($errors) != 0 )
            $success = false;
        
        $data['errors'] = $errors;
        $data['success'] = $success;
        
        $this->common_model->response_json($data);
    }
    
    
    /**
     * This function reorders faq question<br/>
     * Data Required: reorderQuestionsEditFaqs
     */
    function reorderQuestions(){
        $success = array();
        $errors = array();
        
        $reorderQuestionsEditFaqs = @$_POST['reorderQuestionsEditFaqs'];
        
        if($reorderQuestionsEditFaqs){// if faq question list is not empty, update questions order
            foreach ($reorderQuestionsEditFaqs as $faqs) {//loop through each faq section
                if ($faqs['questions']) {//if there is atleast one question in the section
                    $i = 1;
                    foreach ($faqs['questions'] as $faqQuestion) {//loop through each section question, update question order
                        $data = array(
                            'orderIndex' => $i
                        );
                        $this->common_model->updateRowsWhereArr('faqs', $data, array('faqId' => $faqQuestion['faqId']));
                        $i++;
                    }
                }
            }
            
            $success['message'] = "Updated successfully";
            
        } else {//show error if question list is empty
            $errors['message'] = "Error updating. Please contact admin for more details.";
        }
        
        
        if(count($errors) != 0 )
            $success = false;
        
        $data['errors'] = $errors;
        $data['success'] = $success;
        
        $this->common_model->response_json($data);
    }
    
    /**
     * This function moves question from one section to another section<br/>
     * Data Required: faqId, sectionId
     */
    function moveQuestionToAnotherSection(){
        $success = array();
        $errors = array();

        $faqId = @$_POST['faqId'];
        $sectionId = @$_POST['sectionId']; //section id to move to

        if ($sectionId) {//if sectionId is not empty, update section information of the question
            $data = array(
                'faqSectionId' => $sectionId
            );
            $this->common_model->updateRowsWhereArr('faqs', $data, array('faqId' => $faqId));
            $success['message'] = "Updated successfully";
        } else {//if sectionId is empty show error
            $errors['message'] = "Error updating. Please contact admin for more details.";
        }


        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }
    

}
