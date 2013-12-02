<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

		 $params = array(
	               'client_id'=>Yii::app()->params['client_id'],
	               'client_secret'=>Yii::app()->params['client_secret'],
	               // 'user_email'=>$this->username,
	               // 'user_password'=>$this->password,
	               'grant_type'=>'authorization_code',
	               // 'response_type' => 'code',
	               'redirect_uri'=> Yii::app()->params['redirect_uri'],
	               'state' => Yii::app()->params['state'],
	               'code' =>$this->username, 
	       );

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, Yii::app()->params['accesstokenUrl']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);     
       // Common::pre($data,true);
        Yii::app()->session['accesstoken']= $data->result->access_token;
 		$Pparams = array(
	               'access_token' => $data->result->access_token, 
	       );
        $profile = curl_init();
        
        curl_setopt($profile, CURLOPT_URL, Yii::app()->params['profileUrl']);
        curl_setopt($profile, CURLOPT_POST, 1);
        curl_setopt($profile, CURLOPT_POSTFIELDS, $Pparams);
        curl_setopt($profile, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($profile, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($profile, CURLOPT_SSL_VERIFYHOST, false);
        $dataprofile = json_decode(curl_exec($profile));
        curl_close($profile);     
        
       	// Common::pre($dataprofile,true);
        if($dataprofile->result){
        	if(!UserTable::checkIfUserExist($dataprofile->result->id)){
        		$usermodel = new UserTable;
        		$usermodel->tagbond_id = $dataprofile->result->id;
        		$usermodel->userName = $dataprofile->result->user_firstname." ".$dataprofile->result->user_lastname;
        		$usermodel->userEmail = $dataprofile->result->profile_email;
        		// $usermodel->userVerification =;
        		$usermodel->userRegDate = date("Y-m-d H:i:s");
        		if($usermodel->save(false)){
        			$this->setState('userId', $usermodel['userId']);
		            $this->setState('userName', $usermodel['userName']);
		            $this->setState('userRegDate', $usermodel['userRegDate']);
        		}
        	}else{
        		$userApp = UserTable::model()->findByAttributes(array('tagbond_id'=>$dataprofile->result->id));
        		$this->setState('userId', $userApp['userId']);
	            $this->setState('userName', $userApp['userName']);
	            $this->setState('userRegDate', $userApp['userRegDate']);
        	}
            // $this->_id=$dataprofile->result->id;
            $this->setState('tagbond_id', $dataprofile->result->id);
            $this->setState('userEmail', $dataprofile->result->profile_email);
            $this->setState('userFirstname', $dataprofile->result->user_firstname);
            $this->setState('userLastname', $dataprofile->result->user_lastname);
            $this->setState('token',  $data->result->access_token);
            return $this->errorCode=self::ERROR_NONE;
        } else {
            return $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
	}
}