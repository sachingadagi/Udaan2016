<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/16/2015
 * Time: 1:08 PM
 */

namespace Udaan;


class Onspot {
    public $id;
    public $name;
    public $leader_email;
    public $leader_name;
    public $leader_contact;
    public $leader_2_email;
    public $leader_2_name;
    public $leader_2_contact;
    public $registration_id;
    public $TYPE;

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
    public function getLeaderEmail()
    {
        return $this->leader_email;
    }

    /**
     * @param mixed $leader_email
     */
    public function setLeaderEmail($leader_email)
    {
        $this->leader_email = $leader_email;
    }

    /**
     * @return mixed
     */
    public function getLeaderName()
    {
        return $this->leader_name;
    }

    /**
     * @param mixed $leader_name
     */
    public function setLeaderName($leader_name)
    {
        $this->leader_name = $leader_name;
    }

    /**
     * @return mixed
     */
    public function getLeaderContact()
    {
        return $this->leader_contact;
    }

    /**
     * @param mixed $leader_contact
     */
    public function setLeaderContact($leader_contact)
    {
        $this->leader_contact = $leader_contact;
    }

    /**
     * @return mixed
     */
    public function getLeader2Email()
    {
        return $this->leader_2_email;
    }

    /**
     * @param mixed $leader_2_email
     */
    public function setLeader2Email($leader_2_email)
    {
        $this->leader_2_email = $leader_2_email;
    }

    /**
     * @return mixed
     */
    public function getLeader2Name()
    {
        return $this->leader_2_name;
    }

    /**
     * @param mixed $leader_2_name
     */
    public function setLeader2Name($leader_2_name)
    {
        $this->leader_2_name = $leader_2_name;
    }

    /**
     * @return mixed
     */
    public function getLeader2Contact()
    {
        return $this->leader_2_contact;
    }

    /**
     * @param mixed $leader_2_contact
     */
    public function setLeader2Contact($leader_2_contact)
    {
        $this->leader_2_contact = $leader_2_contact;
    }

    /**
     * @return mixed
     */
    public function getRegistrationId()
    {
        return $this->registration_id;
    }

    /**
     * @param mixed $registration_id
     */
    public function setRegistrationId($registration_id)
    {
        $this->registration_id = $registration_id;
    }

    /**
     * @return mixed
     */
    public function getTYPE()
    {
        return $this->TYPE;
    }

    /**
     * @param mixed $TYPE
     */
    public function setTYPE($TYPE)
    {
        $this->TYPE = $TYPE;
    }



}