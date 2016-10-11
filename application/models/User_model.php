<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
        
    /**
     * This function returns user info based on userId.
     * @param int $userId
     * @return array
     */
    function getUserInfo($userId) {
        if ($userId == "")
            return false;

        $this->db->where('userId',$userId);
        $result = $this->db->get('users')->result();
        
        if(count($result) == 0)
            return false;
        
        return $result[0];
    }
        
    /**
     * This function gets user account balance based on userId.
     * @param int $userId
     * @return int
     */
    function getUserAccountBalance($userId){
        if($userId == "")
            return 0;
        $this->db->where('userId',$userId);
        $result = $this->db->get('users')->result();
        
        if(count($result) == 0)
            return 0;
        
        return $result[0]->accountBalance;
    }
    
    /**
     * This function is used to add a new user and returns userId.
     * @param array $data
     * @return int
     */
    function addNewUser($data) {
        if (count($data) == 0)
            return 0;

        if ($this->db->insert('users', $data)) {
            $result = $this->db->insert_id();
            return $result;
        }

        return 0;
    }
    
    function getOperatorImages($operatorId) {
        if ($operatorId == "")
            return false;

        $this->db->where('operatorId',$operatorId);
        $this->db->where('deleted',0);
        $this->db->order_by('orderIndex');
        $result = $this->db->get('operator_photos')->result();
        
        if(count($result) == 0)
            return false;
        
        return $result;
    }
    
    /**
     * This function is used to update user info
     * @param int $userId
     * @param array $data
     * @return int
     */
    function updateUserInfo($userId,$data) {
        if ($userId == 0 || count($data) == 0)
            return false;
        
        $this->db->where('userId',$userId);
        return $this->db->update('users',$data);
    }
    
    /**
     * This function checks if there is any user exists
     * in the database with the email and password provided.<br/>
     * @param string $email
     * @param string $password
     * @return int
     */
    function isValidUser($email,$password) {
        if ($email == "" || $password == "")
            return false;
        
        $this->db->where('email',$email);
        $this->db->where('password',md5($password));
        $this->db->where('status',1);
        $result = $this->db->get('users')->result();
        
        if(count($result) == 0)
            return false;
        
        return $result[0];
    }
    
    /**
     * This function checks if user is the owner of operator profile.
     * If so, it returns true. Otherwise, returns false.<br/>
     * @param int $userId
     * @param int $operatorId
     * @return boolean
     */
     
    function isOwner($userId,$operatorId) {
        if ($userId == "" || $operatorId == "")
            return false;
        
        $this->db->where('ownerId',$userId);
        $this->db->where('operatorId',$operatorId);
        $result = $this->db->get('operators')->result();
        
        if(count($result) == 0)
            return false;
        
        return true;
    }
    
    /**
     * This function checks if email exists in the database.<br/>
     * @param string $email
     * @return array
     */
    function emailExists($email) {
        if ($email == "")
            return false;
        
        $this->db->where('email',$email);
        $result = $this->db->get('users')->result();
        
        if(count($result) == 0)
            return false;
        
        return $result[0];
    }
    
    /**
     * This function checks if reset password token is valid.
     * If so, it returns user info. Otherwise, it returns false.<br/>
     * @param string $resetPasswordToken
     * @return boolean/array
     */
    function checkPasswordResetToken($resetPasswordToken) {
        if ($resetPasswordToken == "")
            return false;
        
        $this->db->where('resetPasswordToken',$resetPasswordToken);
        $result = $this->db->get('users')->result();
        
        if(count($result) == 0)
            return false;
        
        return $result[0];
    }
    
    /**
     * This function is used to send account activation email to user.
     * @param int $userId
     * @param string $email
     * @return boolean
     */
    function sendActivationEmail($userId,$email) {
        if ($userId == "" || $email == "")
            return false;
        
        $activationToken = md5($email.time());
        $activation_link = base_url('user/activate/' . $activationToken);
        $from = "SHEEP FUND<no-reply@inrentory.com>";
        $to = $email;

        $subject = "Activate your Sheep Fund account";

        $email_content = "You have just registered an account on Sheep Fund.<br/><br/>";
        $email_content .= "Please click on the following link to activate your account:<br/>";
        $email_content .= $activation_link;
        
        $data = array(
            'activationToken' => $activationToken
        );
        $this->updateUserInfo($userId, $data);

        $emailData = array(
            'subject' => $subject,
            'messageBody' => $email_content,
            'btnText' => "Activate Account",
            'btnLink' => $activation_link
        );
        
        $this->emailsending->sendemail($from, $to, $subject, $emailData);

        return true;
    }
    
    /**
     * This function is used to modify user account balance. This is called whenever a user adds to his account balance, whenever an order is approved, and whenever and order is rejected.
     * After modifing user account balance it then updates
     * sheepfund account balance if modification is set to true.<br/>
     * @param int $userId
     * @param int $amount
     * @param string $reasonModified
     * @param int $isManualModification
     * @param boolean $escrowUpdate
     * @return int
     */
    function modifyUserAccountBalance($userId, $amount = 0,$reasonModified="",$isManualModification=0, $escrowUpdate = false) {
        $userAccountBalance = $this->common_model->getSingleFieldsWhereArr('users', 'accountBalance', array('userId' => $userId));
        $data = array('accountBalance' => $userAccountBalance + $amount);
        $this->common_model->updateRowsWhereArr('users', $data, array('userId' => $userId));

        if ($escrowUpdate) {//if update sheepfund balance flag is set, update the escrowBalance
            $escrowBalance = $this->common_model->getSingleFieldsWhereArr('global_variables', 'escrowBalance', array('id' => 1));
            $global_data = array('escrowBalance' => $escrowBalance - $amount);
            $this->common_model->updateRowsWhereArr('global_variables', $global_data, array('id' => 1));
        }
        
        //Add Entry to account balance modification function
        return $this->addAccountBalanceModificationHistory($userId,$userAccountBalance,$amount,0,$reasonModified,$isManualModification);
    }

    /**
     * This function is used to modify operator account balance. This is called whenever an order is confirmed, and only if that Operator's part of the order has quantityConfirmed > 0
     * After modifing operator account balance it then updates
     * sheepfund account balance if modification is set to true.<br/>
     * @param int $operatorId
     * @param int $amount
     * @param string $reasonModified
     * @param int $isManualModification
     * @param boolean $escrowUpdate
     * @return int
     */
    function modifyOperatorAccountBalance($operatorId,$amount = 0,$reasonModified="",$isManualModification=0,$escrowUpdate = false){
        $operatorAccountBalance = $this->common_model->getSingleFieldsWhereArr('operators', 'accountBalance', array('operatorId' => $operatorId));
        $data = array('accountBalance' => $operatorAccountBalance + $amount);
        $this->common_model->updateRowsWhereArr('operators', $data, array('operatorId' => $operatorId));
        
        if ($escrowUpdate) {//if update sheepfund balance flag is set, update the escrowBalance.
            $escrowBalance = $this->common_model->getSingleFieldsWhereArr('global_variables', 'escrowBalance', array('id' => 1));
            $global_data = array('escrowBalance' => $escrowBalance - $amount);
            $this->common_model->updateRowsWhereArr('global_variables', $global_data, array('id' => 1));
        }
        
        //Add Entry to account balance modification function
        return $this->addAccountBalanceModificationHistory($operatorId,$operatorAccountBalance,$amount,1,$reasonModified,$isManualModification);
    }
    
    /**
     * This function adds account balance modification history to db.
     * This function requires user to be logged in.<br/>
     * @param int $accountId
     * @param int $initialAmount
     * @param int $amountModified
     * @param int $isOperator
     * @param string $reasonModified
     * @param boolean $isManualModification
     * @return int
     */
    function addAccountBalanceModificationHistory($accountId,$initialAmount,$amountModified,$isOperator,$reasonModified,$isManualModification) {
        
        if ($this->session->userdata('logged_in')) {//check if user is logged in. If so, update user account balance
            $session_data = $this->session->userdata('logged_in');
            $userId = $session_data['userId'];

            $newAmount = $initialAmount + $amountModified;
            $account_balance_modification_data = array(
                "isOperator" => $isOperator,
                "accountId" => $accountId,
                "isManualModification" => $isManualModification,
                "initialAmount" => $initialAmount,
                "amountModified" => $amountModified,
                "reasonModified" => $reasonModified,
                "newAmount" => $newAmount,
                "timestampModified" => date("Y-m-d H:i:s"),
                "modifiedBy" => $userId
            );

            $accountBalanceModificationId = $this->common_model->insertRow('account_balance_modifications', $account_balance_modification_data);

            return $accountBalanceModificationId;
        }
    }

}
