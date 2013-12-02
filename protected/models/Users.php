<?php

    class Users extends CFormModel{
        public $username;
        public $password;
        public $rememberMe;
        public $code;
        public $state;
    
        private $_identity;
        public function rules(){
            return array(
//                array('username,password','required'),
                array('username,password,code,state', 'safe', 'on'=>'search'),
                
            );
        } 
        public function attributeLabels(){
            return array(
                'username'=>'Username',
                'password'=>'Password',
                'code'=>'Code',
                'state'=>'State',
            );
        }
        public function validate($attributes = NULL, $clearErrors = true){
            $this->validatorList->add(CValidator::createValidator('required', $this, 'username'));
            $this->validatorList->add(CValidator::createValidator('required', $this, 'password'));
            return parent::validate();
        }
        public function authenticate($attribute,$params)
        {
            // Common::pre($this,true);
            if(!$this->hasErrors())
            {
                $this->_identity=new UserIdentity($this->code,$this->state);
                if(!$this->_identity->authenticate())
                    $this->addError('password','Missing Code or state.');
            }
        }
        public function login()
        {
            if($this->_identity===null)
            {
                $this->_identity=new UserIdentity($this->code,$this->state);
                $this->_identity->authenticate();
            }
            if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
            {
                $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
                Yii::app()->user->login($this->_identity,$duration);
                return true;
            }
            else
                return false;
        }
    }

?>