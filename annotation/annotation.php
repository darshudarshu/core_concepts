<?php
namespace mindplay\demo;
use Doctrine\Common\Annotations\Annotation\Required;
use mindplay\annotations\demo\annotations\LengthAnnotation;
use Doctrine\Common\Annotations\Annotation\Attribute;
use mindplay\annotations\demo\annotations\TextAnnotation;
class Person
{
    /**
     * @var string
     * @required
     * @length(50)
     * @text('label' => 'Full Name')
     */
    public $name;
    /**
     * @var string
     * @length(50)
     * @text('label' => 'Street Address')
     */
    public $address;
    /**
    * @var int
    * @range(0, 100)
    */
    public $age;
      /**
     * @method void getPerseon
     */
    public function getPerseon()
    {
        echo "Name :".$this->name ."\n";
        echo "Adress :".$this->address ."\n";
        echo "Age :".$this->age ."\n";
    }
    /**
     * @method void setPerseon
     * @param string name
     * @param string address
     * @param int age
     */
    public function setPerseon($name,$address,$age)
    {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
    }
}
$ref = new Person();
echo "Enter Name :";
$name = readline();
echo "Enter Adress :";
$address = readline();
echo "Enter Age :";
fscanf(STDIN, '%d', $age);
$ref->setPerseon($name,$address,$age);
$ref->getPerseon();
