<?php

/**
 * Ticket model. Used to understand wether user is allowed to see access the image
 */
class Unsee_Ticket extends Unsee_Redis
{

    /**
     * Database id
     * @var int
     */
    protected $db = 2;

    /**
     * Titme to live
     * @var int
     */
    static public $ttl = 30;

    public function __construct()
    {
        parent::__construct(Unsee_Session::getCurrent());
    }

    /**
     * Create a ticket for the current session to access the image id
     * @param string $imageId
     * @return boolean
     */
    public function issue($imageId)
    {
        $this->$imageId = time();
        return true;
    }

    /**
     * Returns true if current session is allowed to access the image
     * @param Unsee_Image $imageDoc
     * @return true
     */
    public function isAllowed($imageDoc)
    {
        return isset($this->{$imageDoc->key}) && isset($_COOKIE[md5(Unsee_Session::getCurrent() . $imageDoc->hash)]);
    }

    /**
     * Deletes the ticket
     * @param Unsee_Image $imageDoc
     * @return boolean
     */
    public function invalidate($imageDoc)
    {
        unset($this->{$imageDoc->key});
        return true;
    }
}
