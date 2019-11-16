<?php

interface NetworkHandler
{
    /**
     * @return string
     */
    public function getNetworkId();

    /**
     * @return object
     */
    public function getNetworkInfo();

    /**
     * @return bool
     */
    public function saveChanges();

}
