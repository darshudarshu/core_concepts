<?php
/*******************************************************************
 * @discription : AOP implimentation
 *******************************************************************/
/**
 * interface bank
 * @method abstract saveAccount
 * @method abstract deleteAccount
 */
interface Bank
{
    public function saveAccount();
    public function deleteAccount();
    public function saveAccountWithAspects();
    public function deleteAccountWithAspects();
}
/**
 * banker class providing implementation to bank interface
 * implements Bank interface
 */
class Banker implements Bank
{
    public function saveAccount()
    {
         /**
         * before providing Aspects
         */
        echo "Banker Saving Bank Account\n\n";
    }
    public function deleteAccount()
    {
         /**
         * before providing Aspects
         */
        echo "Banker Deleting Bank Account\n\n";
    }
    public function saveAccountWithAspects()
    {
        /**
         * providing security Aspects to SaveAccount method
         */
        $security = new SecurityAspects();
        echo $security->security() . " to banker\n";
         /**
         * before providing Aspects
         */
        echo "Banker Saving Bank Account\n\n";
    }
    public function deleteAccountWithAspects()
    {
        /**
         * providing Authentication Aspects to deleteAccount method
         */
        $authenticate = new AuthenticationAspects();
        echo $authenticate->authentication() . " to banker\n";
         /**
         * before providing Aspects
         */
        echo "Banker Deleting Bank Account\n\n";
    }
}
/**
 * customer class providing implementation to bank interface
 * implements Bank interface
 */
class Customer implements Bank
{
    public function saveAccount()
    {
        /**
         * before providing Aspects
         */
        echo "Customer Saving Bank Account\n\n";
    }
    public function deleteAccount()
    {
        /**
         * before providing Aspects
         */
        echo "Customer Deleting Bank Account\n\n";
    }
    public function saveAccountWithAspects()
    {
         /**
         * providing security Aspects to SaveAccount method
         */
        $security = new SecurityAspects();
        echo $security->security() . " to customer\n";
        /**
         * before providing Aspects
         */
        echo "Customer Saving Bank Account\n\n";
    }
    public function deleteAccountWithAspects()
    {
         /**
         * providing Authentication Aspects to deleteAccount method
         */
        $authenticate = new AuthenticationAspects();
        echo $authenticate->authentication() . " to customer\n";
        /**
         * before providing Aspects
         */
        echo "Customer Deleting Bank Account\n\n";
    }
}
/**
 *security Aspect class
 */
class SecurityAspects
{
    /**
     * @method security() has logic for security
     * @return string implimentation
     */
    public function security()
    {
        return "providing security aspects";
    }
}
/**
 *Authentication Aspect class
 */
class AuthenticationAspects
{
     /**
     * @method authentication() has logic for authentication
     * @return string implimentation
     */
    public function authentication()
    {
        return "providing Authentication Aspects";
    }
}
/**
 * test class
 * @var string holds the interface reference
 */
class Test
{
    private $obj;
    /**
     * @method reference() to store object in interface reference
     */
    public function reference(Bank $obj)
    {
        $this->obj = $obj;
        echo "**********before Provding Aspects***********\n";
        Test::bank();
        echo "**********After providing Aspects***********\n";
        Test::bankWithAspects();
    }
    /**
     * @method bank() calling implimented methods using interface reference
     */
    public function bank()
    {
        $this->obj->saveAccount();
        $this->obj->deleteAccount();
    }
     /**
     * @method bankWithAspects() calling implimented methods using interface reference
     */
    public function bankWithAspects()
    {
        $this->obj->saveAccountWithAspects();
        $this->obj->deleteAccountWithAspects();
    }

}
/**
 * user interface
 */
$ref = new Test();
$ref->reference(new Banker());
$ref->reference(new Customer());
