<?php

class JsonNetworkHandler implements NetworkHandler
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
    private $network = null;

    public function __construct($dirName, $fileName)
    {
        $this->dirName = $dirName;
        $this->fileName = $fileName;
        $this->network = $this->decodeNetwork();
        if ($this->network == null) throw new InvalidArgumentException("Network '" . $fileName . "' is invalid.");
    }

    /**
     * @return string
     */
    public function getNetworkId() {
        return $this->getNetworkInfo()->id;
    }

    /**
     * @return object
     */
    public function getNetworkInfo()
    {
        if ($this->network == null) {
            $this->network = $this->decodeNetwork();
        }
        return $this->network;
    }

    /**
     * @return bool
     */
    public function saveChanges()
    {
        if ($this->network == null) return false;
        file_put_contents($this->dirName . $this->fileName, json_encode($this->network));
        $this->network = null;
        return true;
    }

    /**
     * @return object|null
     */
    private function decodeNetwork()
    {
        $network = json_decode(file_get_contents($this->dirName . "/" . $this->fileName));
        return $this->validateNetwork($network) ? $network : null;
    }

    /**
     * @param $network object
     * @return bool
     */
    private function validateNetwork($network)
    {
        return true;//TODO: implement network validation
    }
}
