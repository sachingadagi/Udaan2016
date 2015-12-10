<?php
/**
 * User: tuxer
 * Author : Sachin Gadagi
 * Date: 12/6/2015
 * Time: 5:07 PM
 */

#simple implementation of abstract class to emulate enumerator
abstract class ErrorsAndExceptions {
      const  TYPE_PDOException = 1;
      const  TYPE_MYSQL_EXCEPTION = 2;
};


/**
 * Class JSONifyErrors
 * A utility/helper class that will jsonify the errors/Exception messages
 *
 */
class JSONifyErrors{

    /**
     * @var int Can belong to one of types listed in @ErrorsAndExceptions
     */
    public $error_type;


    /**
     * @var  mixedVariable mixVariable that will hold ExceptionObjects
     */
    public $mixedVariable;


    /**
     * @var jsonified_error holds actual json
     */
    public $jsonified_error;


    /**
     * @param $mixedVariable
     */
    function __construct( $mixedVariable )
    {
        if( $mixedVariable instanceof \PDOException)
        {
            $this->error_type = ErrorsAndExceptions::TYPE_PDOException;
            $this->mixedVariable = $mixedVariable;

        }
    }

    /**
     * @return string returns stringified json from the exception object
     */
    public function prepareJSON()
    {
                $error = array();

                #depending the type,nature of exception handle them
                if( $this->error_type == ErrorsAndExceptions::TYPE_PDOException )
                {

                #using inbuilt functions
                $error["line"] = $this->mixedVariable->getLine();
                $error["code"] = $this->mixedVariable->getCode();
                $error["trace"] = $this->mixedVariable->getTraceAsString();

                # custom error , will return only the phrase that carries the actual error messages e.g  "DevError": " Integrity constraint violation"
                $error["DevError"] = explode(":",$this->mixedVariable->getMessage())[1];

                $this->jsonified_error = json_encode($error);

                }
                return json_encode($this->jsonified_error);
    }


}