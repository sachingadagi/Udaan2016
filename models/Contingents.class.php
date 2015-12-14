<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/2/2015
 * Time: 11:06 PM
 */




class Contingents {

    public $id;
    public $name;
    public $loginid;
    public $password;
    public $cl_name;
    public $cl_contact;
    public $acl_1_name;
    public $acl_2_name;
    public $acl_1_contact;
    public $acl_2_contact;
    public $cl_email;
    public $acl_1_email;
    public $acl_2_email;
    public $is_deleted;
    public $is_first_login;

    /**
     * @return mixed
     */
    public function getClEmail()
    {
        return $this->cl_email;
    }

    /**
     * @param mixed $cl_email
     */
    public function setClEmail($cl_email)
    {
        $this->cl_email = $cl_email;
    }

    /**
     * @return mixed
     */
    public function getAcl1Email()
    {
        return $this->acl_1_email;
    }

    /**
     * @param mixed $acl_1_email
     */
    public function setAcl1Email($acl_1_email)
    {
        $this->acl_1_email = $acl_1_email;
    }

    /**
     * @return mixed
     */
    public function getAcl2Email()
    {
        return $this->acl_2_email;
    }

    /**
     * @param mixed $acl_2_email
     */
    public function setAcl2Email($acl_2_email)
    {
        $this->acl_2_email = $acl_2_email;
    }




    function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }




    # Getters and setters

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLoginid()
    {
        return $this->loginid;
    }

    /**
     * @param mixed $loginid
     */
    public function setLoginid($loginid)
    {
        $this->loginid = $loginid;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getClName()
    {
        return $this->cl_name;
    }

    /**
     * @param mixed $cl_name
     */
    public function setClName($cl_name)
    {
        $this->cl_name = $cl_name;
    }

    /**
     * @return mixed
     */
    public function getClContact()
    {
        return $this->cl_contact;
    }

    /**
     * @param mixed $cl_contact
     */
    public function setClContact($cl_contact)
    {
        $this->cl_contact = $cl_contact;
    }

    /**
     * @return mixed
     */
    public function getAcl1Name()
    {
        return $this->acl_1_name;
    }

    /**
     * @param mixed $acl_1_name
     */
    public function setAcl1Name($acl_1_name)
    {
        $this->acl_1_name = $acl_1_name;
    }

    /**
     * @return mixed
     */
    public function getAcl1Contact()
    {
        return $this->acl_1_contact;
    }

    /**
     * @param mixed $acl_1_contact
     */
    public function setAcl1Contact($acl_1_contact)
    {
        $this->acl_1_contact = $acl_1_contact;
    }

    /**
     * @return mixed
     */
    public function getAcl2Name()
    {
        return $this->acl_2_name;
    }

    /**
     * @param mixed $acl_2_name
     */
    public function setAcl2Name($acl_2_name)
    {
        $this->acl_2_name = $acl_2_name;
    }

    /**
     * @return mixed
     */
    public function getAcl2Contact()
    {
        return $this->acl_2_contact;
    }

    /**
     * @param mixed $acl_2_contact
     */
    public function setAcl2Contact($acl_2_contact)
    {
        $this->acl_2_contact = $acl_2_contact;
    }

    public function getIsFirstLogin()
    {
        return $this->is_first_login;
    }
	
	
    public function setIsFirstLogin($is_first_login)
    {
        $this->is_first_login = $is_first_login;
    }


}