<?php
/**********************************************************************
 * @Discprition : IOC implimented using DI
 *********************************************************************/
/**
 * interface  to pop question
 * @method popQuestion() abstract
 */
interface QuizMaster
{
    public function popQuestion();
}
/**
 * Class to generate maths topic question
 */
class MathsQuizMaster implements QuizMaster
{
    /**
     * @method popQuestion()
     * @return string maths question
     */
    public function popQuestion()
    {
        echo "Maths Topic Qsuestion :\n";
        return "why we need math in our daily life? \n";
    }
}
/**
 * Class to generate Physics topic question
 */
class PhysicsQuizMaster implements QuizMaster
{
    /**
     * @method popQuestion()
     * @return string Physics question
     */
    public function popQuestion()
    {
        echo "Physics Topic Qsuestion :\n";
        return "what is the basic definition of physics?\n";
    }
}
/**
 * class to conduct quiz
 * @var quizMaster holds the object of respective master class
 */
class QuizMasterConductor
{
    public $quizMaster;
    /**
     * @method setQuizMaster() dependency injection
     * @param quizMaster injecting interface type reference variable
     */
    public function setQuizMaster(QuizMaster $quizMaster)
    {
        $this->quizMaster = $quizMaster;
    }
    /**
     * @method askQuestion to peint a question by calling popQueastion methos of respective object
     */
    public function askQuestion()
    {
        echo $this->quizMaster->popQuestion();
    }
}
/**
 * INVERSION OF CONTROLer class
 */
class Inversion
{
    /**
     * @method control() creates the object of masterimplimentation class
     */
    public function control()
    {
        $container = new QuizMasterConductor();
        $container->setQuizMaster(new MathsQuizMaster());
        //calling respective MathsQuizMaster method 
        $container->askQuestion();
        $container->setQuizMaster(new PhysicsQuizMaster());
        //calling respective PhysicsQuizMaster method 
        $container->askQuestion();
    }
}
/**
 * Quiz conductor class 
 */
class QuizProgram
{
    /**
     * @method main() calling the inversion class control method
     */
    public static function main()
    {
        $inversionOfControl = new Inversion();
        $inversionOfControl->control();
    }
}
/**
 * User
 */
QuizProgram::main();
