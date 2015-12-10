<?php
/**
 * Created by PhpStorm.
 * User: tuxer
 * Date: 12/2/2015
 * Time: 11:06 PM
 */

//namespace Udaan;
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/Udaan2016/fms/Config.php";

class Event {
    public $id;
    public $name;
    public $slogan;
    public $details;
    public $category;
    public $logo;
    public $rules;
    public $max_participants;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $group_size;
    public $fee_home;
    public $fee_remote;
    public $location;
    public $event_head_name;
    public $event_head_contact;
    public $equipment_provided;
    public $is_deleted;
    public $award;

    /**
     * @return mixed
     */
    public function getAward()
    {
        return $this->award;
    }

    /**
     * @param mixed $award
     */
    public function setAward($award)
    {
        $this->award = $award;
    }
    public function __construct()
    {
        settype($this->fee_home,"integer");
        settype($this->fee_remote,"integer");
        $this->is_deleted = 0;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param mixed $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return mixed
     */
    public function getGroupSize()
    {
        return $this->group_size;
    }

    /**
     * @param mixed $group_size
     */
    public function setGroupSize($group_size)
    {
        $this->group_size = $group_size;
    }

    /**
     * @return mixed
     */
    public function getFeeHome()
    {
        return $this->fee_home;
    }

    /**
     * @param mixed $fee_home
     */
    public function setFeeHome($fee_home)
    {
        $this->fee_home = $fee_home;
    }

    /**
     * @return mixed
     */
    public function getFeeRemote()
    {
        return $this->fee_remote;
    }

    /**
     * @param mixed $fee_remote
     */
    public function setFeeRemote($fee_remote)
    {
        $this->fee_remote = $fee_remote;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getEventHeadName()
    {
        return $this->event_head_name;
    }

    /**
     * @param mixed $event_head_name
     */
    public function setEventHeadName($event_head_name)
    {
        $this->event_head_name = $event_head_name;
    }

    /**
     * @return mixed
     */
    public function getEventHeadContact()
    {
        return $this->event_head_contact;
    }

    /**
     * @param mixed $event_head_contact
     */
    public function setEventHeadContact($event_head_contact)
    {
        $this->event_head_contact = $event_head_contact;
    }

    /**
     * @return mixed
     */
    public function getEquipmentProvided()
    {
        return $this->equipment_provided;
    }

    /**
     * @param mixed $equipment_provided
     */
    public function setEquipmentProvided($equipment_provided)
    {
        $this->equipment_provided = $equipment_provided;
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




    # all the getters and setters.
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
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * @param mixed $slogan
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $type
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = \Udaan\Config::getLogoDirectory().$logo;
    }

    /**
     * @return mixed
     */
    public function getMaxParticipants()
    {
        return $this->max_participants;
    }

    /**
     * @param mixed $max_participants
     */
    public function setMaxParticipants($max_participants)
    {
        $this->max_participants = $max_participants;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param string $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = date('Y-m-d',strtotime($start_date));
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param string $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = date('Y-m-d',strtotime($end_date));
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param mixed $start_time
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param mixed $end_time
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
    }



}