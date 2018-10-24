<?php
header('Access-Control-Allow-Origin: *');
/*********************************************************************
 * @discription  Controller API
 *********************************************************************/
require 'phpmailer/index.php';
/**
 * @var string $query has query to update data into database (tbl_sample) table name
 */
/**
 * @var string $statement holds statement object
 */
/**
 * @var array $data to store result
 */
class FundoAPI
{
    /**
     * @var string $connect PDO object
     */
    private $connect       = '';
    public static $emailid = "";
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        $this->database_connection();
    }
    /**
     * @method database_connection() creates PDO object
     */
    public function database_connection()
    {
        $this->connect = new PDO("mysql:host=localhost;dbname=testing", "root", "root");
    }
/**
 * @var string $name
 * @var string $email
 * @var string $number
 * @var string $pass
 */

    /**
     * @method registration() Adds data into the database
     * @return void
     */
    public function registration()
    {

        $name   = $_POST["username"];
        $email  = $_POST["email"];
        $number = $_POST["mobilenumber"];
        $pass   = $_POST["password"];
        /**checking the entered first name present nor not */
        $flag = FundoAPI::isEmailNumberPresent($email, $number);
        if ($flag == 0) {
            $query = "
            INSERT INTO userinfo
            (username,email,mobilenumber,password) VALUES
            ('$name','$email',$number,'$pass')
            ";
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                $ref = new Mailing();
                // define("PROJECT_HOME", "http://localhost:4200/verify");
                $token = md5($email);
                $sub   = 'verify email id';
                $body  = "<div> hello <br>
            <p>click this link to verify your email<br>
            <a href='" . "http://localhost:4200/verify" . "?token=" . $token . "'>"
                    . "click here" .
                    "</a><br></p>Regards,<br> DARSHU.</div>";
                $ref->sendMail($email, $body, $sub);
                $query     = "UPDATE userinfo SET reset_key = '$token' where email = '$email'";
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    $data = array(
                        "message" => "200",
                    );
                    print json_encode($data);

                } else {
                    $data = array(
                        "message" => "204",
                    );
                    print json_encode($data);
                }
            } else {
                $data = array(
                    "message" => "304",
                );
                print json_encode($data);
            }
        } else if ($flag == 1) {
            $data = array(
                "message" => "201",
            );
            print json_encode($data);
        } else {
            $data = array(
                "message" => "203",
            );
            print json_encode($data);
        }
    }
/**
 * @method isEmailNumberPresent() check email number duplicate
 * @return void
 */
    public function isEmailNumberPresent($email, $number)
    {
        $query     = "SELECT * FROM userinfo ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if (($titleData['email'] == $email) || ($titleData['mobilenumber'] == $number)) {
                if ($titleData['email'] == $email) {
                    //user email found duplicate
                    return 1;
                } else if ($titleData['mobilenumber'] == $number) {
                    // user phone found duplicate
                    return 2;
                }
            }
        }
        //no duplicate not found
        return 0;
    }
/**
 * @method login() login in to fundo logic
 * @return void
 */
    public function login()
    {
        $email = $_POST["email"];
        $pass  = $_POST["password"];

        $flag = FundoAPI::isPresentRegistered($email, $pass);
        if ($flag == 1) {
            $data = array(
                "message" => "400",
            );
            print json_encode($data);
        } else if ($flag == 2) {
            $data = array(
                "message" => "401",
            );
            print json_encode($data);
        } else if ($flag == 3) {
            $data = array(
                "message" => "200",
            );
            print json_encode($data);
        } else {
            $data = array(
                "message" => "404",
            );
            print json_encode($data);
        }
    }
/**
 * @method isPresentRegistered() check email and pass match
 * @return void
 */
    public function isPresentRegistered($email, $pass)
    {
        $query     = "SELECT * FROM userinfo ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if (($titleData['email'] == $email) || ($titleData['password'] == $pass) || ($titleData['active'] == 'active')) {
                if (($titleData['email'] == $email) && ($titleData['password'] != $pass)) {
                    return 1;
                } else if (($titleData['email'] != $email) && ($titleData['password'] == $pass)) {
                    return 2;
                } else if (($titleData['email'] == $email) && ($titleData['password'] == $pass) && ($titleData['active'] == 'active')) {
                    return 3;
                } else {
                    return 0;
                }
            }
        }
        return 0;
    }
/**
 * @method forgotPassword() sending resetting password ink to registered mail
 * @return void
 */
    public function forgotPassword()
    {
        $email = $_POST["email"];
        // define("PROJECT_HOME", "http://localhost:4200/reset");

        if (FundoAPI::checkEmail($email)) {
            $ref       = new Mailing();
            $token     = md5($email);
            $query     = "UPDATE userinfo SET reset_key = '$token' where email = '$email'";
            $statement = $this->connect->prepare($query);
            $statement->execute();
            $sub  = 'password recovery mail';
            $body = "<div> hello <br>
            <p>Click this link to recover your password<br>
            <a href='" . "http://localhost:4200/reset" . "?token=" . $token . "'>"
                . "click here" .
                "</a><br></p>Regards,<br> DARSHU.</div>";

            $ref->sendMail($email, $body, $sub);
            $data = array(
                "message" => "200",
            );
            print json_encode($data);

        } else {
            $data = array(
                "message" => "404",
            );
            print json_encode($data);

        }
    }
/**
 * @method checkEmail() check email is present
 * @return void
 */
    public function checkEmail($email)
    {
        $query     = "SELECT * FROM userinfo ORDER BY id";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if ($titleData['email'] == $email && $titleData['active'] == 'active') {
                return true;
            }
        }
        return false;
    }
/**
 * @method resetPassword() resets the pass word of corresesponding email
 * @return void
 */
    public function resetPassword()
    {
        $token     = $_POST["token"];
        $pass      = $_POST["pass"];
        $query     = "UPDATE userinfo SET reset_key = '$token' where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $query     = "UPDATE userinfo SET password = '$pass' where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $query     = "SELECT reset_key FROM userinfo where  password = '$pass'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetch(PDO::FETCH_ASSOC);
        if ($arr['reset_key'] == null) {
            $data = array(
                "message" => "304",
            );
            print json_encode($data);
        } else {
            $data = array(
                "message" => "200",
            );
            print json_encode($data);
            $query     = "UPDATE userinfo SET reset_key = null where reset_key='$token'";
            $statement = $this->connect->prepare($query);
            $statement->execute();
        }
    }
/**
 * @method getEmailId() ge the forgoten email id
 * @return void
 */
    public function getEmailId()
    {
        $token     = $_POST["token"];
        $query     = "SELECT email FROM userinfo where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $arr = $statement->fetch(PDO::FETCH_ASSOC);
        if ($arr) {
            $data = array(
                'key'     => $arr['email'],
                'session' => 'active',
            );
            print json_encode($data);
        } else {
            $data = array(
                'key'     => "\n",
                'session' => 'reset link has been expired',
            );
            print json_encode($data);

        }

    }
/**
 * @method veryfyEmailId() verify the email and send verify link to user
 * @return void
 */
    public function veryfyEmailId()
    {
        $token     = $_POST["token"];
        $query     = " UPDATE userinfo SET active = 'active' where reset_key ='$token' ";
        $statement = $this->connect->prepare($query);
        $statement->execute();
        $query     = "UPDATE userinfo SET reset_key = null where reset_key='$token'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {
            $data = array(
                "message" => "200",
            );
            print json_encode($data);

        } else {
            $data = array(
                "message" => "401",
            );
            print json_encode($data);

        }
    }
}
