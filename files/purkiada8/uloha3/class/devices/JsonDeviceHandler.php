<?php

class JsonDeviceHandler implements DeviceHandler
{
    /**
     * @var string
     */
    private $dirName;
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var object
     */
    private $device = null;

    /**
     * DeviceHandler constructor.
     * @param $dirName string
     * @param $fileName string
     */
    public function __construct($dirName, $fileName)
    {
        $this->dirName = $dirName;
        $this->fileName = $fileName;
        $this->device = $this->decodeDevice();
        if ($this->device == null) throw new InvalidArgumentException("Device '" . $fileName . "' is invalid.");
    }

    /**
     * @return string
     */
    public function getDeviceName() {
        return $this->getDeviceInfo()->name;
    }

    /**
     * @return object
     */
    public function getDeviceInfo()
    {
        if ($this->device == null) {
            $this->device = $this->decodeDevice();
        }
        return $this->device;
    }

    /**
     * @return bool
     */
    public function saveChanges()
    {
        if ($this->device == null) return false;
        file_put_contents($this->dirName . '/' . $this->fileName, json_encode($this->device));
        $this->device = null;
        return true;
    }

    /**
     * @return object|null
     */
    private function decodeDevice()
    {
        $device = json_decode(file_get_contents($this->dirName . '/' . $this->fileName));
        return $this->validateDevice($device) ? $device : null;
    }

    /**
     * @param $device array
     * @return bool
     */
    private function validateDevice($device)
    {
        //add_to_log("validatingDevice: " . $deviceFileName);

        //add_to_log("  validatingDevice->name");
        if (!isset($device->name) || !is_string($device->name)) return false;

        //add_to_log("  validatingDevice->groups");
        if (!isset($device->groups)) {
            $device->groups = [];
        } elseif (!is_array($device->groups)) return false;

        //add_to_log("  validatingDevice->accounts");
        if (isset($device->accounts) && is_object($device->accounts)) {
            if (!isset($device->accounts->names)
                || !is_array($device->accounts->names)
                || !isset($device->accounts->data)
                || !is_object($device->accounts->data)) return false;

            //add_to_log("  validatingDevice->accountsContent");
            foreach ($device->accounts->names as $accountName) {
                //add_to_log("  validatingDevice->accountName: " . $accountName);
                if (!is_string($accountName) || !isset($device->accounts->data->{$accountName})
                    || !is_object($device->accounts->data->{$accountName})) return false;
                $account = $device->accounts->data->{$accountName};

                //add_to_log("    validatingDevice->accountAdmin");
                if (!isset($account->admin) || !is_bool($account->admin)) return false;
                //add_to_log("    validatingDevice->accountPassword");
                if (!isset($account->password)) {
                    $account->password = null;
                } elseif (!(is_string($account->password) || $account->password == null)) return false;
                //add_to_log("    validatingDevice->accountGroups");
                if (!isset($account->groups)) {
                    $account->groups = [];
                } elseif (!is_array($account->groups)) return false;
                //add_to_log("    validatingDevice->accountCommands");
                if (!isset($account->commands)) {
                    $account->commands = [];
                } elseif (!is_array($account->commands)) return false;//TODO: validate commands objects
                //add_to_log("  validatingDevice->accountHomeDirectory");
                if (!isset($account->homeDirectory) || !is_string($account->homeDirectory)) return false;
                //add_to_log("    validatingDevice->accountCommandsHistory");
                if (!isset($account->commandsHistory)) {
                    $account->commandsHistory = [];
                } elseif (!is_array($account->commandsHistory)) return false;
                //add_to_log("    validatingDevice->accountWelcomeText");
                if (!isset($account->welcomeText)) {
                    $account->welcomeText = [];
                } elseif (!is_array($account->welcomeText)) return false;
                //add_to_log("  validatingDevice->accountExitText");
                if (!isset($account->exitText)) {
                    $account->exitText = [];
                } elseif (!is_array($account->exitText)) return false;
            }
        } else return false;

        //add_to_log("  validatingDevice->network");
        if (!isset($device->network)) {
            $device->network = [];
        } elseif (!is_array($device->network)) return false;//TODO: validate networks objects

        //add_to_log("  validatingDevice->hasFiles");
        if (!isset($device->hasFiles)) {
            $device->hasFiles = false;
        } elseif (!is_bool($device->hasFiles)) return false;

        //add_to_log("  validatingDevice->files");
        if (!isset($device->files)) {
            $device->files = [];
        } elseif (!is_array($device->files)) return false;

        return true;
    }
}
