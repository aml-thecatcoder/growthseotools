<?php 
namespace App\Classes;

class CreditCardValidatorClass{

    /**
     * Validate credit card number and return card type.
     * Optionally you can validate if it is a specific type.
     *
     * @param string $ccnumber
     * @param string $cardtype
     * @param string $allowTest
     * @return mixed
     */
    public function Validator($ccnumber, $cardtype = '', $allowTest = false){
        // Check for test cc number
        if($allowTest == false && $ccnumber == '4111111111111111'){
            return false;
        }
        
        $ccnumber = preg_replace('/[^0-9]/','',$ccnumber); // Strip non-numeric characters
        
        $creditcard = array(
            'visa'          =>  "/^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/",
            'mastercard'    =>  "/^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/",
            'discover'      =>  "/^6011-?\d{4}-?\d{4}-?\d{4}$/",
            'amex'          =>  "/^3[4,7]\d{13}$/",
            'diners'        =>  "/^3[0,6,8]\d{12}$/",
            'bankcard'      =>  "/^5610-?\d{4}-?\d{4}-?\d{4}$/",
            'jcb'           =>  "/^35\d{14}$/",
            'enroute'       =>  "/^[2014|2149]\d{11}$/",
            'switch'        =>  "/^[4903|4911|4936|5641|6333|6759|6334|6767]\d{12}$/"
        );
        
        if(empty($cardtype)){
            $match=false;
            foreach($creditcard as $cardtype=>$pattern){
                if(preg_match($pattern,$ccnumber)==1){
                    $match=true;
                    break;
                }
            }
            if(!$match){
                return false;
            }
        }elseif(@preg_match($creditcard[strtolower(trim($cardtype))],$ccnumber)==0){
            return false;
        }       
        
        $return['valid']    =   $this->LuhnCheck($ccnumber);
        $return['ccnum']    =   $ccnumber;
        $return['type']     =   $cardtype;
        return $return;
    }
    
    /**
     * Do a modulus 10 (Luhn algorithm) check
     *
     * @param string $ccnum
     * @return boolean
     */
    public function LuhnCheck($number){
        $sum = 0;
        $flag = 0;

        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $add = $flag++ & 1 ? $number[$i] * 2 : $number[$i];
            $sum += $add > 9 ? $add - 9 : $add;
        }

        return $sum % 10 === 0;
    }
    
}