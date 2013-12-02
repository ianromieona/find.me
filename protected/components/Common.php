<?php
class Common {
    public static function pre($array,$exit=false){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        if($exit){
            exit;
        }
    }

    public static function userdetails(){
        return  Yii::app()->user->userFirstname. " " . Yii::app()->user->userLastname ;
    }

    public static function transfer($amount,$to_id,$to_wallet_id){
        if(!Yii::app()->user->isGuest){
             $params = array(
                   'access_token'=>Yii::app()->user->token,
                   'from_wallet_id'=>$to_wallet_id,
                   'to_id'=> $to_id,
                   'to_type'=> 'user',
                   'to_wallet_id'=> $to_wallet_id,
                    'amount' => $amount,
               );

            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, Yii::app()->params['walletTransferUrl']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $data = json_decode(curl_exec($ch));
            curl_close($ch);  
            if($data->result="success"){
                return true;
            }else{
                return false;
            }
        }else{
            throw new Exception("Login first", 1);
            
        }
        return true;

    }

    public static function avatar(){
        if(!Yii::app()->user->isGuest){
            return Yii::app()->params['avatarUrl'] ."?access_token=". Yii::app()->user->token; 
        }

    }
    public static function getOtherUserAvatar($id){
        return Yii::app()->params['avatarUrl']."/" .$id."?access_token=". Yii::app()->user->token; 
    }
    public static function otherUser($id){
        if(!Yii::app()->user->isGuest){
            $params = array(
                       'access_token' => Yii::app()->user->token, 
            );
            $profile = curl_init();
            $url =Yii::app()->params['profileUrl']."/".$id ;

            curl_setopt($profile, CURLOPT_URL, $url);
            curl_setopt($profile, CURLOPT_POST, 1);
            curl_setopt($profile, CURLOPT_POSTFIELDS, $params);
            curl_setopt($profile, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($profile, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($profile, CURLOPT_SSL_VERIFYHOST, false);
            $dataprofile = json_decode(curl_exec($profile));
            curl_close($profile);  
            // Common::pre( $dataprofile,true);
        }
    }
    public static function getWalletDetails($wallet_id){
        if(!Yii::app()->user->isGuest){
            $objData = '';
            $params = array(
               'access_token'=>Yii::app()->user->token,
               'wallet_type_id' => $wallet_id,
           );

            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, Yii::app()->params['walletListUrl']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $data = json_decode(curl_exec($ch));
            curl_close($ch);  
            if(!$data->result){
               
                $ch = curl_init();
                
                curl_setopt($ch, CURLOPT_URL, Yii::app()->params['createWalletUrl']);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                $data = json_decode(curl_exec($ch));      
                curl_close($ch);  
                if($data->status == "success"){
                    $ch = curl_init();
                    
                    curl_setopt($ch, CURLOPT_URL, Yii::app()->params['walletListUrl']);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    $data = json_decode(curl_exec($ch));
                    curl_close($ch);  
                    $objData = array('amount'=>$data->result[0]->balance_amount,'currency'=>$data->result[0]->currency_code,'walletName'=>$data->result[0]->wallet_name);
                }else{
                    throw new Exception("Creation of wallet failed/duplicate", 1);
                }

            }else{
                $objData = array('amount'=>$data->result[0]->balance_amount,'currency'=>$data->result[0]->currency_code,'walletName'=>$data->result[0]->wallet_name);
            }
            return $objData;
            
        }else{
            throw new Exception("Login first", 1);
            
        } 
    }

    public static function getAllWallets(){
        $params = array(
               'access_token'=>Yii::app()->user->token,
               // 'wallet_type_id' => 7,
           );

            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, Yii::app()->params['walletListUrl']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $data = json_decode(curl_exec($ch)); 
            if($data->status == "success"){
                return $data->result;     
            }
            throw new Exception("No wallet available", 1);
    }
    public static function logout(){

            $params = array(
               'access_token'=>Yii::app()->user->token,
               // 'wallet_type_id' => 7,
            );

            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, Yii::app()->params['logoutUrl']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $data = json_decode(curl_exec($ch)); 
            // Common::pre($data,true);
            if($data->status == "success"){
                return true;    
            }
            return false;
    }

}
?>