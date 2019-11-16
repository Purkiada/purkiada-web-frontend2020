<?php

class JsonBash extends CommandsBash
{

    /**
     * @var EnvironmentInfo
     */
    private $environmentInfo;

    /**
     * @var string
     */
    protected $zeroHistoryCommand = '';
    /**
     * @var int
     */
    protected $inputHistoryOffset = 0;

    /**
     * JsonBash constructor.
     * @param $environmentInfo EnvironmentInfo
     */
    public function __construct($environmentInfo)
    {
        $this->environmentInfo = $environmentInfo;
    }

    /**
     * @return EnvironmentInfo
     */
    public function getEnvironmentInfo()
    {
        return $this->environmentInfo;
    }

    /**
     * @param $terminal Terminal
     * @param $input string
     * @return array
     */
    public function handleInput($terminal, $input)
    {
        if (trim($input) === '') {
            return array();
        }

        $this->saveCommandToHistory($input);

        return $this->getEnvironmentInfo()->executeCommand($terminal, $input);
    }

    /**
     * @param $inputValue string
     */
    protected function saveCommandToHistory($inputValue)
    {
        $commandsHistory = &$this->getEnvironmentInfo()->getActualUserInfo()->commandsHistory;
        if (empty($commandsHistory) || trim($inputValue) !== trim($commandsHistory[count($commandsHistory) - 1])) {
            $commandsHistory[] = $inputValue;
        }
        $this->inputHistoryOffset = 0;
        $this->zeroHistoryCommand = '';
    }

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @return array
     */
    public function handleTab($terminal, $actualInputValue)
    {
        if (empty($actualInputValue)) return array();

        $inputExplode = explode(' ', $actualInputValue);
        if (count($inputExplode) <= 1) {
            $actualInputValueLen = strlen($actualInputValue);
            $results = [];
            foreach ($this->getEnvironmentInfo()->getCommands() as $command) {
                $name = $command->getName();
                if (substr($name, 0, $actualInputValueLen) === $actualInputValue) {
                    $results[] = $name;
                }
            }

            $resultsCount = count($results);
            if ($resultsCount == 0) {
                return array('result' => "<p>Nebyly nalezeny žádné příkazy začínající na '$actualInputValue'</p>");
            } else if ($resultsCount == 1) {
                return array('changedInput' => $results[0] . ' ');
            } else {
                $maxNameLen = 10;
                foreach ($results as $result) {
                    $maxNameLen = max($maxNameLen, strlen($result));
                }

                $resultText = '<p>';
                foreach ($results as $result) {
                    $name = htmlspecialchars($result);

                    $resultText .= " <span>" . $name . '</span>';
                    while (strlen($name) < $maxNameLen) {
                        $name .= ' ';
                        $resultText .= '&nbsp;';
                    }
                }
                $resultText .= '</p>';

                return array('result' => $resultText);
            }
        }

        $args = explodeArgs(substr($actualInputValue, strlen($inputExplode[0])));
        if (empty($args)) return array();
        $lastArgument = array_values(array_slice($args, -1))[0];
        if (containsAny($lastArgument, [' '])) return array();
        $lastArgumentLen = strlen($lastArgument);
        if (empty($lastArgument) || $lastArgument[0] === '-') return array();

        if ($lastArgument[$lastArgumentLen - 1] !== '/') {
            $lastArgumentPathResult = resolvePath($lastArgument, $this->getEnvironmentInfo());
            if (!$lastArgumentPathResult['fail']) {
                if ($lastArgumentPathResult['file'] !== null && $lastArgumentPathResult['file']->permissions[0] !== '-') {
                    return array('changedInput' => $actualInputValue . '/');
                } else {
                    return array();
                }
            }
        }

        $lastArgumentFilename = array_values(array_slice(explode('/', $lastArgument), -1))[0];
        $lastArgumentDir = substr($lastArgument, 0, $lastArgumentLen - strlen($lastArgumentFilename));
        if (empty($lastArgumentDir)) $lastArgumentDir = '.';
        $lastArgumentDirPathResult = resolvePath($lastArgumentDir, $this->getEnvironmentInfo(), true, true, false, ['d']);
        if ($lastArgumentDirPathResult['fail']) return array();

        $lastArgumentFilenameLen = strlen($lastArgumentFilename);
        $results = [];
        foreach ($lastArgumentDirPathResult['content'] as $file) {
            $name = $file->name;
            if (substr($name, 0, $lastArgumentFilenameLen) === $lastArgumentFilename) {
                $results[] = ['name' => $name, 'fileType' => $file->permissions[0]];
            }
        }

        $resultsCount = count($results);
        if ($resultsCount == 0) {
            return array();
        } else if ($resultsCount == 1) {
            return array('changedInput' => $actualInputValue
                . substr($results[0]['name'], $lastArgumentFilenameLen)
                . ($results[0]['fileType'] !== '-' ? '/' : ''));
        } else {
            $relevancy = $results[0]['name'];
            $relevancyLen = strlen($relevancy);
            foreach ($results as $result) {
                for ($i = 0; $i < $relevancyLen; $i++) {
                    if ($relevancy[$i] === $result['name'][$i]) continue;

                    $relevancy = substr($relevancy, 0, $i);
                    $relevancyLen = $i;
                    break;
                }
            }

            if ($relevancyLen > $lastArgumentFilenameLen) {
                return array('changedInput' => $actualInputValue
                    . substr($relevancy, $lastArgumentFilenameLen));
            }

            $maxNameLen = 10;
            foreach ($results as $result) {
                $maxNameLen = max($maxNameLen, strlen($result['name']));
            }

            $resultText = '<p>';
            foreach ($results as $result) {
                $name = htmlspecialchars($result['name']);

                $resultText .= " <span>" . $name . '</span>';
                while (strlen($name) < $maxNameLen) {
                    $name .= ' ';
                    $resultText .= '&nbsp;';
                }
            }
            $resultText .= '</p>';

            return array('result' => $resultText);
        }
    }

    /**
     * @param $terminal Terminal
     * @param $actualInputValue string
     * @param $offset int
     * @return array
     */
    public function handleUpDown($terminal, $actualInputValue, $offset)
    {
        $commandsHistory = &$this->getEnvironmentInfo()->getActualUserInfo()->commandsHistory;

        $oldOffset = $this->inputHistoryOffset;
        $historyCount = count($commandsHistory);
        $this->inputHistoryOffset = $this->inputHistoryOffset + $offset;
        if ($this->inputHistoryOffset > 0) $this->inputHistoryOffset = 0;
        if ($this->inputHistoryOffset < -$historyCount) $this->inputHistoryOffset = -$historyCount;

        if ($oldOffset == $this->inputHistoryOffset) {
            return array('changedInput' => $actualInputValue);
        } else if ($this->inputHistoryOffset == 0) {
            return array('changedInput' => $this->zeroHistoryCommand);
        }

        if ($oldOffset == 0) {
            $this->zeroHistoryCommand = $actualInputValue;
        }

        return array('changedInput' => $commandsHistory[$historyCount + $this->inputHistoryOffset]);
    }
}
