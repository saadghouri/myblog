<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends CI_Controller {

    public $message;

    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->library('template');
    }
    
    public function index() {
        echo "Invalid Request";
        exit;
    }


    public function registerTutorial(){
        $data['mymessage'] = "THIS IS THE REGISTER PAGE";
        $this->template->show("", "register", $data);
    }
    
    public function mypostTutorial(){
        $data['mypostmessage'] = "THIS IS THE REGISTER PAGE";
        $this->template->show("", "register", $data);
    }
    /**
     * This function loads CSS and JS and list of animal types for Home page/ Landing Page<br/>
     * URL: base_url() + '/home'
     */
    public function home() {
        //default CSS and JS for home page
        $this->template->addCSS(base_url('assets/css/spa.style.css'));
        $this->templateate->addCSS(base_url('assets/css/one.style.css'));
        $this->template->addJS(base_url('assets/js/one.app.js'));
        $this->template->addJS(base_url('assets/js/initializeOnePage.js'));


        $this->template->show("", "home", $data);
    }

    /**
     * This function loads list of animal types info owned by operators to show on search page.<br/>
     * URL: base_url() + '/search'
     */
    public function search() {
        $data = array();
        //Get List of all animal types assigned to an operator
        $animalSKUAssignmentList = $this->common_model->getRowsWhereArr('animal_sku_operator_assignments','*',array('enabled'=>1));
        $animalSKUList = array();
        if ($animalSKUAssignmentList) {//if there is any animal type assigned to an operator
            foreach ($animalSKUAssignmentList as $animalSKUAssignment) {//Loop through each animal type assignment
                $operatorInfo = $this->common_model->getSingleRowFieldsWhereArr('operators', '*', array('operatorId' => $animalSKUAssignment->operatorId));
                if($operatorInfo) {//if operator info
                    $animalSKUInfo = $this->animal_model->getAnimalSKUInfo($animalSKUAssignment->animalSKUId);
                    if($animalSKUInfo){
                        $animalSKUInfo->operator = $operatorInfo->operatorCompanyName;
                        $animalSKUInfo->operatorLocation = $operatorInfo->city;
                        $animalSKUInfo->animalSKUOperatorAssignmentId = $animalSKUAssignment->animalSKUOperatorAssignmentId;
                        $animalSKUList[] = $animalSKUInfo;
                    }
                }
            }
        }
        //get list of all animal sub types
        $animalSKUTypes = $this->common_model->getRowsWhereArr('animal_types','*',array('animalParentTypeId'=>1));
        
        
        $data['postSearch'] = @$_POST;
        
        $data['animalSKUTypes'] = $animalSKUTypes;
        $data['animalSKUList'] = $animalSKUList;
        $this->template->show("", "search", $data);
    }

    /**
     * This function displays the message based on the $messageId<br/>
     * URL: base_url() + '/message/$messageId'
     * @param int $messageId
     */
    public function message($messageId) {
        $data['socialIcons'] = false;
        switch ($messageId) {
            case "1":
                $data['message'] = MESSAGE_1;//page not found
                break;
            case "2":
                $data['message'] = MESSAGE_2;//permission denied
                break;
            case "orderSubmitted":
                $data['message'] = "Your order has been submitted. Waiting for confirmation from the operator.";
                $data['socialIcons'] = true;
                break;
            default:
                redirect('message/1');
                break;
        }
        $this->template->show("", "message", $data);
    }

    /**
     * This function checks if the user is logged. If so, it will redirect the user to profile page. Otherwise,
     * loads css and js files for login page<br/>
     * URL: base_url() + '/login'
     */
    public function login() {
        $data['title'] = "Login";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $userId = $session_data['userId'];
            redirect('profile/' . $userId);
        } else { //if user is not logged in
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/login-form.js'));
            $this->template->show("", "login", $data);
        }
    }

    /**
     * This function checks if the user is logged. If so, it will redirect the user to profile page. Otherwise,
     * loads css and js files for registration page<br/>
     * URL: base_url() + '/register'
     */
    public function register() {
        $data['mymessage'] = "Register";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $userId = $session_data['userId'];
            redirect('profile/' . $userId);
        } else {//if user is not logged in
            //$this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            //$this->template->addJS(base_url('assets/js/forms/register-form.js'));
            $this->template->show("", "register", $data);
        }
    }
    public function mypost() {
        $data['mypostmessage'] = "Mypost";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $userId = $session_data['userId'];
            redirect('profile/' . $userId);
        } else {//if user is not logged in
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/register-form.js'));
            $this->template->show("", "mypost", $data);
        }
    }

    /**
     * This function loads css and js files for forgot password page.<br/>
     * URL: base_url() + '/forgot-password'
     */
    public function forgotPassword() {
        $data['title'] = "Enter Email for Password Reset";

        //load CSS and JS files required for forgot password page
        $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
        $this->template->addJS(base_url('assets/js/forms/forgot-password-form.js'));
        $this->template->show("", "forgot_password", $data);
    }

    /**
     * This function loads css and js files for reset password page.<br/>
     * URL: base_url() + '/reset-password/$resetPassword'
     * @param string $resetPassword
     */
    public function newPassword($resetPassword) {
        $data['title'] = "Save New Password";
        $data['resetPasswordToken'] = $resetPassword;

        //load CSS and JS files required for fogot password
        $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
        $this->template->addJS(base_url('assets/js/forms/new-password-form.js'));
        $this->template->show("", "reset_password", $data);
    }

    /**
     * This function shows account activation success message<br/>
     * URL: base_url() + '/activated'
     */
    public function accountActivated() {
        $data['title'] = "Account Activated Successfully";

        $this->template->show("", "account_activated", $data);
    }

    /**
     * This function loads the user info for the user profile page. It first checks if the user is 
     * logged in. If so, it checks if the viewer is the owner or admin. If so, it loads user info.
     * Otherwise, it redirects to login page.<br/>
     * URL: base_url() + '/profile/$userId'
     * @param int $userId
     */
    public function profile($userId) {
        $data['title'] = "Basic Info";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $data['isAdmin'] = $session_data['isAdmin'];
            $ownerUserId = $session_data['userId'];
            $data['ownerUserId'] = $ownerUserId; //userId of user logged in
            $data['profilUserId'] = $userId; //userId of viewing user profile
            if ($ownerUserId == $userId) {//if viewer is the owner of his profile
                $data['profileOwner'] = true;
            } else {
                $data['profileOwner'] = false;
            }

            if ($data['profileOwner'] || $data['isAdmin']) {//if user is an admin or he is the owner of his profile
                $userInfo = $this->user_model->getUserInfo($userId);
                if ($userInfo) {//if $userId is valid
                    $data['userInfo'] = $userInfo;
                    $this->template->show("", "user_profile", $data);
                } else {
                    redirect('login');
                }
            } else {
                redirect('profile/' . $ownerUserId);
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function loads the user info for the edit user profile page. It first checks if the user is 
     * logged in. If so, it checks if the viewer is the owner or admin. If so, it loads user info.
     * Otherwise, it redirects to login page.<br/>
     * URL: base_url() + '/edit/profile/$userId'
     * @param int $userId
     */
    public function editProfilePage($userId) {
        $data['title'] = "Edit Basic Info";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $data['isAdmin'] = $session_data['isAdmin'];
            $ownerUserId = $session_data['userId'];
            $data['ownerUserId'] = $ownerUserId; //userId of user logged in
            $data['profilUserId'] = $userId; //userId of viewing user profile
            if ($ownerUserId == $userId) {
                $data['profileOwner'] = true;
            } else {
                $data['profileOwner'] = false;
            }

            if ($data['profileOwner'] || $data['isAdmin']) {
                $userInfo = $this->user_model->getUserInfo($userId);
                if ($userInfo) {
                    $data['userInfo'] = $userInfo;
                    $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
                    $this->template->addJS(base_url('assets/js/forms/edit-profile-form.js'));
                    $this->template->show("", "edit_user_profile", $data);
                } else {
                    redirect('login');
                }
            } else {
                redirect('edit/profile/' . $ownerUserId);
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function loads the operator profile info. This function requires user to be logged in.
     * It then checks if operatorId is valid. If so, it loads operator info and operator images.<br/>
     * URL: base_url() + '/operator/$operatorId'
     * @param int $operatorId
     */
    public function operatorProfile($operatorId) {
        $data['title'] = "Operator 1";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            //get operator details
            $operatorInfo = $this->common_model->getSingleRowFieldsWhereArr('operators', '*', array('operatorId'=>$operatorId));
            if ($operatorInfo) {//if $operatorId is valid
                $data['operatorLocation'] = $operatorInfo->city . ', ' . $operatorInfo->region . ', ' . $operatorInfo->country;
                $data['taxesPercentage'] = $operatorInfo->taxesPercentage . '%';
                $data['operatorProfileId'] = $operatorId;
                $data['operatorInfo'] = $operatorInfo;

                //getOperatorImages
                $operatorImages = $this->common_model->getRowsWhereArr('operator_photos','*',array('operatorId'=>$operatorId,'deleted'=>0),0,0,'orderIndex desc');

                $data['operatorImages'] = $operatorImages;
            }
            
            $session_data = $this->session->userdata('logged_in');
            $userId = $session_data['userId'];
            
            //getUserInfo
            $userInfo = $this->common_model->getSingleRowFieldsWhereArr('users','*',array('userId'=>$userId));
            $data['userInfo'] = $userInfo;

            $this->template->show("", "operator_profile", $data);
        } else {
            redirect('login');
        }
    }

    /**
     * * This function loads the operator profile info. This function requires user to be logged in.
     * It then checks if operatorId is valid. If so, it loads operator info and operator images.<br/>
     * URL: base_url() + '/edit/operator/$operatorId'
     */
    public function editOperatorProfile($operatorId) {

        if ($this->session->userdata('logged_in')) { //check if user is logged in
        $data['title'] = "Edit Operator Profile";
            $operatorInfo = $this->common_model->getSingleRowFieldsWhereArr('operators', '*', array('operatorId'=>$operatorId));
            if ($operatorInfo) { // if operatorId is valid
                $data['operatorCompanyName'] = $operatorInfo->operatorCompanyName;
                $data['operatorLocation'] = $operatorInfo->city . ', ' . $operatorInfo->region . ', ' . $operatorInfo->country;
                $data['taxesPercentage'] = $operatorInfo->taxesPercentage . '%';
                $data['operatorProfileId'] = $operatorId;
                $data['operatorInfo'] = $operatorInfo;
            }
            //load css and js files
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/edit-operator-profile.js'));
            $this->template->show("", "edit_operator_profile", $data);
        } else {// if user is not logged in
            redirect('login');
        }
    }

    /**
     * This function loads css and js files for add new operator page.
     * This function requires user to be logged in.<br/>
     * URL: base_url() + '/new/operator'
     */
    public function newOperator() {

        if ($this->session->userdata('logged_in')) { //check if user is logged in
        $data['title'] = "New Operator";
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/new-operator-form.js'));
            $this->template->show("", "new_operator", $data);
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to display the list of orders to the Admin. 
     * It first checks the user's role, and then based on his role, it will
     * display the page appropriately, or redirect him.<br/>
     * URL: base_url() + '/orders'
     */
    public function orders() {
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $data['title'] = 'Orders';
            $this->template->show("", "orders", $data);
        } else {// if user is not logged in
            redirect('login');
        }
    }

    /**
     * This function is used to display the list of traders to the Admin. 
     * It first checks the user's role, and then based on his role, it will
     * display the page appropriately, or redirect him.<br/>
     * URL: base_url() + '/traders'
     */
    public function traders() {
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            if($session_data['isAdmin']) { //if user is an admin
                $data['title'] = "Traders";
                
                $tradersList = $this->common_model->getRowsWhereArr('users', '*', array('isAdmin' => 0));//get list of all traders
                $data['traders'] = $tradersList;
                $this->template->show("", "traders", $data);
            } else {//if user is not an admin
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to display the list of operators to the Admin. 
     * It first checks the user's role, and then based on his role, it will
     * display the page appropriately, or redirect him.<br/>
     * URL: base_url() + '/operators'
     */
    public function operators() {
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            if($session_data['isAdmin']) {// if user is admin
                $data['title'] = "Operators";

                $operatorsList = $this->common_model->getInnerJoin('operators', 'users', '*,operators.accountBalance as operatorBalance', 'operators.ownerId = users.userId', array('isAdmin' => 0, 'status' => 1), null, null);//get list of all operators
                $data['operators'] = $operatorsList;

                $this->template->show("", "operators", $data);
            } else {//if user is not logged in
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to get all of the animal SKU assignments of
     * the operator. It first has to check his role to verify that he is
     * an operator, and then get the appropriate information based on his operatorId<br/>
     * URL: base_url() + '/my-animal'
     */
    public function myAnimals() {
        $data['title'] = "My Sheep Types";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            //get operator profile attached to user - getOperatorProfileAttachedToUser
            $operatorsAttachedToUser = $this->common_model->getRowsWhereArr('operators', '*', array('ownerId' => $session_data['userId']));
            $data['operatorProfile'] = $operatorsAttachedToUser;

            if (count($operatorsAttachedToUser) > 0) {//if there is not operator attached to user logged in
                if ($operatorsAttachedToUser[0]->operatorId) {//if operatorId specified
                    $data['defaultOperatorId'] = $operatorsAttachedToUser[0]->operatorId;
                }
                $this->template->show("", "my_animals", $data);
            } else {// if no operator is attached to the user 
                redirect('message/2');//permission denied page
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to get all of the animal serial #'s assignments of
     * the operator. It first has to check his role to verify that he is
     * an operator, and then get the appropriate information based on his operatorId<br/>
     * URL: base_url() + '/my-animal-stock'
     */
    public function myAnimalsStock() {
        $data['title'] = "My Sheep Stock";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            //get operator profile attached to user - getOperatorProfileAttachedToUser
            $operatorsAttachedToUser = $this->common_model->getRowsWhereArr('operators', '*', array('ownerId' => $session_data['userId']));
            $data['operatorProfile'] = $operatorsAttachedToUser;

            if ($operatorsAttachedToUser != 0) {//if there is not operator attached to user logged in
                if ($operatorsAttachedToUser[0]->operatorId) {//if operatorId specified
                    $data['defaultOperatorId'] = $operatorsAttachedToUser[0]->operatorId;
                }
                $this->template->show("", "my_animals_stock", $data);
            } else {// if no operator is attached to the user
                redirect('message/2');
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to edit animal type info. This function requires user 
     * to be logged in. It then checks his role to verify that he is an operator.
     * If so, it will load appropriate info to display. Other wise it will show error.<br/>
     * URL: base_url() + '/edit-animal/$animalSKUOperatorAssignmentId'
     * @param int $animalSKUOperatorAssignmentId
     */
    public function editMyAnimalType($animalSKUOperatorAssignmentId) {
        $data['title'] = "Edit Sheep";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            //load css and js files for this page
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/add-animal-form.js'));

            // get animal type operator assignment info
            $animalSKUOperatorAssignmentInfo = $this->common_model->getSingleRowFieldsWhereArr('animal_sku_operator_assignments','*',array('animalSKUOperatorAssignmentId'=>$animalSKUOperatorAssignmentId));
            // get animal type info
            $animalSKUInfo = $this->common_model->getSingleRowFieldsWhereArr('animal_skus','*',array('animalSKUId'=>$animalSKUOperatorAssignmentInfo->animalSKUId));
            //get list of all animal sub types
            $animalSKUTypes = $this->common_model->getRowsWhereArr('animal_types','*',array('animalParentTypeId'=>1));

            $data['operatorId'] = $animalSKUOperatorAssignmentInfo->operatorId;
            $data['animalSKUTypes'] = $animalSKUTypes;
            $data['animalSKUInfo'] = $animalSKUInfo;
            $this->template->show("", "edit_my_animal", $data);
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to edit animal serial info. This function requires user 
     * to be logged in. It then checks his role to verify that he is an operator.
     * If so, it will load appropriate info to display. Other wise it will show error.<br/>
     * URL: base_url() + '/edit-animal-stock/$animalId'
     * @param int $animalId
     */
    public function editMyAnimalStock($animalId) {
        $data['title'] = "Edit Sheep Stock";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            //load css and js files
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/edit-animal-stock-form.js'));
            
            //get animal info
            $animalInfo = $this->common_model->getSingleRowFieldsWhereArr('animals','*',array('animalId'=>$animalId));
            //get list of all animal sub types
            $animalSKUTypes = $this->common_model->getRowsWhereArr('animal_types','*',array('animalParentTypeId'=>1));
            $animalInfo->birthday = date('Y-m-d',strtotime($animalInfo->birthday));
            $animalInfo->maturityDate = date('Y-m-d',strtotime($animalInfo->maturityDate));
            
            //get operator profile attached to user - getOperatorProfileAttachedToUser
            $operatorsAttachedToUser = $this->common_model->getRowsWhereArr('operators', '*', array('ownerId' => $session_data['userId']));
            
            $data['operatorProfile'] = $operatorsAttachedToUser;
            $data['operatorId'] = $animalInfo->operatorId;
            $data['animalSKUTypes'] = $animalSKUTypes;
            $data['aniamlInfo'] = $animalInfo;
            $this->template->show("", "edit_my_animal_stock", $data);
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to add animal type. This function requires user 
     * to be logged in. It then checks his role to verify that he is an operator.
     * If so, it will load appropriate info to display. Other wise it will show error.<br/>
     * URL: base_url() + '/add/animal/$operatorId'
     * @param int $operatorId
     */
    public function addAnimal($operatorId) {
        $data['title'] = "Add Sheep SKU";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            //load css and js files
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/add-animal-form.js'));

            //get list of all animal sub types
            $animalSKUTypes = $this->common_model->getRowsWhereArr('animal_types','*',array('animalParentTypeId'=>1));

            $data['operatorId'] = $operatorId;
            $data['animalSKUTypes'] = $animalSKUTypes;
            $this->template->show("", "add_animal", $data);
        } else {
            redirect('login');
        }
    }

    /**
     * This function is used to add animal serial #. This function requires user 
     * to be logged in. It then checks his role to verify that he is an operator.
     * If so, it will load appropriate info to display. Other wise it will show error.<br/>
     * URL: base_url() + '/add-animal-stock'
     */
    public function addAnimalStock() {
        $data['title'] = "Add Sheep Stock";

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $this->template->addCSS(base_url('assets/css/pages/log-reg-v3.css'));
            $this->template->addJS(base_url('assets/js/forms/add-animal-stock-form.js'));

            //get list of all animal sub types
            $animalSKUTypes = $this->common_model->getRowsWhereArr('animal_types','*',array('animalParentTypeId'=>1));
            //get operator profile attached to user - getOperatorProfileAttachedToUser
            $operatorsAttachedToUser = $this->common_model->getRowsWhereArr('operators', '*', array('ownerId' => $session_data['userId']));
            $data['operatorProfile'] = $operatorsAttachedToUser;

            if (count($operatorsAttachedToUser) > 0) { //if there is any operator attached to this user 
                $data['animalSKUTypes'] = $animalSKUTypes;
                $this->template->show("", "add_animal_stock", $data);
            } else {
                redirect('message/2');
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function loads the product details for owner page
     * view. It first checks to make sure the product exists. If so,
     * it will load appropriate info to show on product page.
     * Otherwise, redirect to an error page <br/>
     * URL: base_url() + '/product/$animalSKUAssignmentId'
     * @param $animalSKUAssignmentId
     */
    public function product($animalSKUAssignmentId) {
        // getAnimalSKUAssignmentInfo
        $animalSKUAssignmentInfo = $this->common_model->getSingleRowFieldsWhereArr('animal_sku_operator_assignments', '*', array('animalSKUOperatorAssignmentId' => $animalSKUAssignmentId));
        // animal type info
        $animalSKUInfo = $this->common_model->getSingleRowFieldsWhereArr('animal_skus', '*', array('animalSKUId' => $animalSKUAssignmentInfo->animalSKUId));
        if ($animalSKUInfo) {//if the animal type id is valid
            //get animal type
            $animalTypeInfo = $this->animal_model->getAnimalType($animalSKUInfo->animalTypeId);
            $data['title'] = $animalTypeInfo->description;
            $data['animalSKUInfo'] = $animalSKUInfo;
            $data['isAdmin'] = false;
            $data['isOwner'] = false;
            $data['animalSKUOperatorAssignmentId'] = $animalSKUAssignmentId;
            if ($this->session->userdata('logged_in')) { //check if user is logged in
                $session_data = $this->session->userdata('logged_in');
                $data['isAdmin'] = $session_data['isAdmin'];
                $userId = $session_data['userId'];
                $data['isOwner'] = $this->user_model->isOwner($userId, $animalSKUAssignmentInfo->operatorId);
            }
            //getAnimalSKUImages
            $animalSKUImages = $this->common_model->getRowsWhereArr('animal_sku_operator_assignment_photos','*',array('animalSKUOperatorAssignmentId'=>$animalSKUAssignmentId,'deleted'=>0),0,0,'orderIndex desc');

            $data['animalSKUImages'] = $animalSKUImages;
            $data['pageUrl'] = base_url('product/'.$animalSKUAssignmentId);

            $this->template->show("", "product", $data);
        } else { //if anial type id is not valid
            redirect('message/1');
        }
    }

    /**
     * This function loads the product details for owner page
     * view. This function requires user to be looged in. It
     * then checks to make sure the product exists. If so,
     * then check his role to verify that he is
     * an admin or owner of this product. Otherwise, redirect to an error page <br/>
     * URL: base_url() + '/product/ownerview/$animalSKUAssignmentId'
     * @param int $animalSKUAssignmentId
     */
    public function productOwnerview($animalSKUAssignmentId) {
        
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            // getAnimalSKUAssignmentInfo
            $animalSKUAssignmentInfo = $this->common_model->getSingleRowFieldsWhereArr('animal_sku_operator_assignments', '*', array('animalSKUOperatorAssignmentId' => $animalSKUAssignmentId));
            $operatorId = $animalSKUAssignmentInfo->operatorId;
            $operatorInfo = $this->common_model->getSingleRowFieldsWhereArr('operators', '*', array('operatorId'=>$operatorId));
            $animalSKUInfo = $this->common_model->getSingleRowFieldsWhereArr('animal_skus', '*', array('animalSKUId' => $animalSKUAssignmentInfo->animalSKUId));
            if ($animalSKUInfo) { //Check to make sure this one exists. If so, show the info, otherwise, redirect to an error page
                $animalTypeInfo = $this->animal_model->getAnimalType($animalSKUInfo->animalTypeId);
                $data['title'] = $animalTypeInfo->description;
                $data['animalSKUInfo'] = $animalSKUInfo;
                $data['operatorInfo'] = $operatorInfo;
                $data['animalSKUOperatorAssignmentId'] = $animalSKUAssignmentId;
                $data['animalSKUAssignmentInfo'] = $animalSKUAssignmentInfo;
                $session_data = $this->session->userdata('logged_in');
                $data['isAdmin'] = $session_data['isAdmin'];
                $userId = $session_data['userId'];
                $data['isOwner'] = $this->user_model->isOwner($userId, $animalSKUAssignmentInfo->operatorId);

                if ($data['isAdmin'] || $data['isOwner']) {//if user is an admin or owner of animal type
                    //getAnimalSKUImages
                    $animalSKUImages = $this->common_model->getRowsWhereArr('animal_sku_operator_assignment_photos', '*', array('animalSKUOperatorAssignmentId' => $animalSKUAssignmentId, 'deleted' => 0), 0, 0, 'orderIndex desc');
                    $data['animalSKUImages'] = $animalSKUImages;
                    $this->template->show("", "product_ownerview", $data);
                } else {//if user is not an admin or owner of animal type
                    redirect('message/2');
                }
            } else {
                redirect('message/1');
            }
        } else {
            redirect('login');
        }
    }

    /**
     * This function checks user session. If user is logged in it will show incoming orders page.
     * Otherwise it will redirect to login page.
     * URL: base_url() + '/incoming-orders'
     */
    function incomingOrders() {
        //This function is for the operators. if will check if the user is an operator, and loads the incoming orders for this operator.
        $data['title'] = 'Incoming Orders';

        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $this->template->show("", "incoming_orders", $data);
        } else {//if user is not logged in
            redirect('login');
        }
    }

    /**
     * This function checks user session. If user is logged in it will show orders page.
     * Otherwise it will redirect to login page.<br/>
     * URL: base_url() + '/my-orders'
     */
    function myOrders() {

        $data['title'] = 'Orders Made';

        if ($this->session->userdata('logged_in')) { //check if user is logged in

            $this->template->show("", "my_orders", $data);
        } else {
            redirect('login');
        }
    }

    /**
     * This function shows checkout page. This function requires user to be logged in.<br/>
     * URL: base_url() + '/checkout'
     */
    function checkout() {
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $data['title'] = 'Checkout';

            $this->template->show("", "checkout", $data);
        } else {//if user is not logged in
            redirect('login');
        }
    }

    /**
     * This function is used to get all of the animal serial #'s bought by
     * the user. This function requires user to be logged in.<br/>
     * URL: base_url() + '/animal-bought'
     */
    public function bought() {
        $data['title'] = "My Livestock Portfolio";
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $userId = $session_data['userId'];
            //get list of sheeps user have bought
            $sheepsIveBought = $this->common_model->getRowsWhereArr('animals', '*', array('ownedByUserId' => $userId));
            
            $data['sheepsIveBought'] = $sheepsIveBought;
            $this->template->show("", "bought", $data);
        } else {// if user is not logged in
            redirect('login');
        }
    }

     /**
     * This function is used to load the about us description for about us page.
     * In order to edit the about us description user needs to be logged login.<br/>
     * URL: base_url() + '/about-us'
     */
    public function aboutUs() {
        $data['title'] = "About Us";
        //get about us description
        $data['aboutUs'] = $this->common_model->getSingleFieldsWhereArr('global_variables','aboutUsDesc',array('id'=>1));
        
        $data['isAdmin'] = false;
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $data['isAdmin'] = $session_data['isAdmin'];
        }
        $this->template->show("", "about_us", $data);
    }
    
     /**
     * This function is used to load faqs. This function requires user
     * to be logged and should be an admin in order to edit faq<br/>
     * URL: base_url() + '/faq'
     */
    public function faq() {
        $data['title'] = "Frequently Asked Questions";
        $data['isAdmin'] = false;
        if ($this->session->userdata('logged_in')) { //check if user is logged in
            $session_data = $this->session->userdata('logged_in');
            $data['isAdmin'] = $session_data['isAdmin'];
        }

        $this->template->show("", "faq", $data);
    }

     /** 
     * This function is not in used. Will be removed when refactoring<br/>
     * URL: base_url() + '/edit-faq'
     */
    public function editFaq() {
        $data['title'] = "Edit Frequently Asked Questions";

        $this->template->show("", "edit_faq", $data);
    }

     /**
     * This function is used for testing purposes.
     * URL: base_url() + '/test'
     */
    public function test() {
        $data['title'] = "Test Page";

        $this->template->show("", "test", $data);
    }

}
