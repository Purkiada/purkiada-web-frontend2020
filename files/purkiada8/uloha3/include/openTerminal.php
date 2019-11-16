<?php
session_start();
//session_start_timeout(7200);//Permission denied

require(__DIR__ . '/../include/log.php');
require(__DIR__ . '/../class/Terminal.php');

define('TEST_MODE_ENABLED', true);
define('DATABASE_ACCOUNTS_ENABLED', false);

if (!TEST_MODE_ENABLED) overrideErrorHandler();

if (isset($_SESSION['controlPanelTerminal'])) {
    try {
        $terminal = unserialize($_SESSION['controlPanelTerminal']);
    } catch (Throwable $e) {
        if (TEST_MODE_ENABLED) throw $e;

        unset($_SESSION['controlPanelTerminal']);
        echo json_encode(array('result' => '<p>Nepodařilo se obnovit terminál. Restartuji Terminál, prosím <b>obnovte stránku</b>.</p>',
            'inputPrefix' => '', 'inputType' => 'none', 'backupContent' => false, 'hasResult' => true, 'changedInput' => ''));
        exit();
    }
} else {
    $terminal = new Terminal();
    $_SESSION['controlPanelTerminal'] = serialize($terminal);
}

/***
 * Starts a session with a specific timeout and a specific GC probability.
 * @param int $timeout The number of seconds until it should time out.
 * @param int $probability The probability, in int percentage, that the garbage
 *        collection routine will be triggered right now.
 * @param string $cookie_domain The domain path for the cookie.
 */
function session_start_timeout($timeout=5, $probability=100, $cookie_domain='/') {
    // Set the max lifetime
    ini_set("session.gc_maxlifetime", $timeout);

    // Set the session cookie to timeout
    ini_set("session.cookie_lifetime", $timeout);

    // Change the save path. Sessions stored in teh same path
    // all share the same lifetime; the lowest lifetime will be
    // used for all. Therefore, for this to work, the session
    // must be stored in a directory where only sessions sharing
    // it's lifetime are. Best to just dynamically create on.
    $separator = strstr(strtoupper(substr(PHP_OS, 0, 3)), "WIN") ? "\\" : "/";
    $path = ini_get("session.save_path") . $separator . "session_" . $timeout . "sec";
    if(!file_exists($path)) {
        if(!mkdir($path, 600)) {
            trigger_error("Failed to create session save path directory '$path'. Check permissions.", E_USER_ERROR);
        }
    }
    ini_set("session.save_path", $path);

    // Set the chance to trigger the garbage collection.
    ini_set("session.gc_probability", $probability);
    ini_set("session.gc_divisor", 100); // Should always be 100

    // Start the session!
    session_start();

    // Renew the time left until this session times out.
    // If you skip this, the session will time out based
    // on the time when it was created, rather than when
    // it was last used.
    if(isset($_COOKIE[session_name()])) {
        setcookie(session_name(), $_COOKIE[session_name()], time() + $timeout, $cookie_domain);
    }
}
