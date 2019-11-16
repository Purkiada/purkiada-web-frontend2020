<?php

interface DeviceHandler
{
    /**
     * @return string
     */
    public function getDeviceName();

    /**
     * @return object
     */
    public function getDeviceInfo();

    /**
     * @return bool
     */
    public function saveChanges();
}
