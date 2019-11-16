<?php

interface InputProcessor
{
    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getWelcomeText($terminal);

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getExitText($terminal);

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getInputPrefix($terminal);

    /**
     * @param $terminal Terminal
     * @return string
     */
    public function getInputType($terminal);

    /**
     * @param $terminal Terminal
     * @param $input string
     * @return array
     */
    public function handleInput($terminal, $input);

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @return array
     */
    public function handleTab($terminal, $actualInputValue);

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @param $offset int
     * @return array
     */
    public function handleUpDown($terminal, $actualInputValue, $offset);
}
