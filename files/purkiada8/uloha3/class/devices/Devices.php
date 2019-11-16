<?php

require __DIR__ . '/DeviceHandler.php';
require __DIR__ . '/JsonDeviceHandler.php';

require __DIR__ . '/NetworkHandler.php';
require __DIR__ . '/JsonNetworkHandler.php';

require __DIR__ . '/../hooks/Hook.php';
require __DIR__ . '/../hooks/AIHook.php';
require __DIR__ . '/../hooks/ObjectivesHook.php';

class Devices
{

    /**
     * @var string
     */
    private $loginID = null;
    /**
     * @var array DeviceHandler
     */
    private $devices = [];
    /**
     * @var array NetworkHandler
     */
    private $networks = [];
    /**
     * @var array Hook
     */
    private $hooks = [];
    private $hooksSaveFilePath;

    function __construct()
    {
    }

    /**
     * @return string
     */
    public function getLoginID()
    {
        return $this->loginID;
    }

    /**
     * @param $name
     * @return DeviceHandler|null
     */
    public function getDeviceHandlerByName($name)
    {
        if (!isset($this->devices[$name])) return null;
        return $this->devices[$name];
    }

    /**
     * @param $id string
     * @return NetworkHandler
     */
    public function getNetworkHandlerById($id)
    {
        if (!isset($this->networks[$id])) return null;
        return $this->networks[$id];
    }

    /**
     * @return array Hook
     */
    public function getHooks()
    {
        return $this->hooks;
    }

    public function saveChanges()
    {
        if ($this->loginID == null) return;

        foreach ($this->devices as $device) $device->saveChanges();
        foreach ($this->networks as $network) $network->saveChanges();
        file_put_contents($this->hooksSaveFilePath, serialize($this->hooks));
    }

    /**
     * @return string
     */
    public function getActualUserSourcesPath()
    {
        if ($this->loginID == null) return null;
        return getUserFilesPath($this->loginID) . '/source';
    }

    /**
     * @return string
     */
    public function getActualUserLogFilePath()
    {
        return getUserLogFilePath($this->loginID);
    }

    /**
     * @param $deviceHandler DeviceHandler
     * @param $username string
     * @param $password string|null
     * @return bool
     */
    public function validateLoginRequest($deviceHandler, $username, $password = null)
    {
        $accounts = $deviceHandler->getDeviceInfo()->accounts;
        if (!in_array($username, $accounts->names)) return false;

        $requiredPassword = $accounts->data->{$username}->password;
        return $password === null
            || $requiredPassword === ''
            || $requiredPassword === $password;
    }

    /**
     * @param $loginID string
     * @return bool true if devices was restored, false if was created
     */
    public function prepareDevicesForUser($loginID)
    {
        $this->saveChanges();

        $result = true;

        $this->loginID = null;
        $this->devices = array();
        $this->networks = array();
        $this->hooks = array();
        if ($loginID != null) {
            $userDirPath = getUserFilesPath($loginID);
            if (!is_dir($userDirPath)) {
                mkdir($userDirPath);
            }

            $sourcesDirPath = $userDirPath . '/source';
            if (!is_dir($sourcesDirPath)) {
                mkdir($sourcesDirPath);
                copy_directory(DEFAULT_SOURCES_DIR_PATH, $sourcesDirPath);
                $result = false;
            }

            $systemDirPath = $sourcesDirPath . '/system';
            $devicesDirPath = $systemDirPath . '/devices';
            foreach (scandir($devicesDirPath) as $file) {
                if ($file == '.' || $file == '..') continue;

                try {
                    $device = new JsonDeviceHandler($devicesDirPath, $file);
                    $this->devices[$device->getDeviceName()] = $device;
                } catch (Exception $e) {
                    add_to_log('User ' . $loginID . ': ' . $e->getMessage());
                    add_to_log($e->getMessage(), getUserLogFilePath($loginID));
                }
            }

            $networkDevicesDirPath = $systemDirPath . '/network';
            foreach (scandir($networkDevicesDirPath) as $file) {
                if ($file == '.' || $file == '..') continue;

                try {
                    $network = new JsonNetworkHandler($networkDevicesDirPath, $file);
                    $this->networks[$network->getNetworkId()] = $network;
                } catch (Exception $e) {
                    add_to_log('User ' . $loginID . ': ' . $e->getMessage());
                    add_to_log($e->getMessage(), getUserLogFilePath($loginID));
                }
            }

            $this->hooksSaveFilePath = $systemDirPath . '/hooks.bin';
            $loadHooks = function() {
                if (file_exists($this->hooksSaveFilePath)) {
                    try {
                        $this->hooks = unserialize(file_get_contents($this->hooksSaveFilePath));
                        return true;
                    } catch (Exception $e) {
                        return false;
                    }
                }
                return false;
            };
            $hooksLoaded = $loadHooks();
            if (!$hooksLoaded) {
                $this->hooks[] = new AIHook();
                $this->hooks[] = new ObjectivesHook();
            }
        }

        $this->loginID = $loginID;
        return $result;
    }

    public function resetActualUserDevices()
    {
        if ($this->loginID == null) return;
        $loginID = $this->loginID;
        $this->prepareDevicesForUser(null);
        $this->resetUserDevices($loginID);
        //$this->prepareDevicesForUser($loginID);
    }

    /**
     * @param $loginID string
     */
    public function resetTargetUserDevices($loginID)
    {
        if ($this->loginID === $loginID) $this->resetActualUserDevices();
        else @$this->resetUserDevices($loginID);
    }

    /**
     * @param $loginID string
     */
    private function resetUserDevices($loginID)
    {
        $userFilesPath = getUserFilesPath($loginID);

        $index = 0;
        while (file_exists($userFilesPath . '/backup' . $index)) {
            $index++;
        }

        rename($userFilesPath . '/source', $userFilesPath . '/backup' . $index);
    }

}

/**
 * @var string
 */
define('DATA_DIR_PATH', realpath(__DIR__ . '/../../data'));
/**
 * @var string
 */
define('DEFAULT_SOURCES_DIR_PATH', DATA_DIR_PATH . '/source');

/**
 * @param $loginID string
 * @return string
 */
function getUserFilesPath($loginID)
{
    return DATA_DIR_PATH . '/accounts/' . $loginID;
}

/**
 * @param $loginID string
 * @return string
 */
function getUserSourcesPath($loginID)
{
    return getUserFilesPath($loginID) . '/source';
}

/**
 * @param $loginID string
 * @return string
 */
function getUserLogFilePath($loginID)
{
    return ($loginID == null ? __DIR__ . '/../../log'
            : getUserFilesPath($loginID) . '/source') . '/user.log';
}

/**
 * @param $terminal Terminal
 * @return string
 */
function getActualUserLogFilePath($terminal) {
    return $terminal->getDevices()->getActualUserLogFilePath();
}

function copy_directory($src,$dst)
{
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copy_directory($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
