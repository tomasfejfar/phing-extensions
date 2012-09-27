<?php
require_once "phing/tasks/system/condition/Condition.php";

/**
 * Version compare condition for Phing deploy
 * @author Tomáš Fejfar (http://www.tomasfejfar.cz)
 *
 */
class VersionCompareCondition implements Condition {

    /**
     * Actual version
     * @var string
     */
    private $version;
    /**
     * Version to be compared to
     * @var string
     */
    private $desiredVersion;
    /**
     * Operator to use (default "greater or equal")
     * @var string operator for possible values @see http://php.net/version%20compare 
     */
    private $operator = '>=';
    
    private $debug = false;
    
    public function setVersion($version) {
        $this->version = $version;
    }

    public function setDesiredVersion($desiredVersion) {
        $this->desiredVersion = $desiredVersion;
    }

    public function setOperator($operator) {
        $allowed = array('<', 'lt', '<=', 'le', '>', 'gt', '>=', 'ge', '==', '=', 'eq', '!=', '<>', 'ne');
        if (!in_array($operator, $allowed)) { // allowed operators for php's version_comapare()
            require_once 'phing/BuildException.php';
            throw new BuildException(sprintf(
                'Operator "%s" is not supported. Supported operators: %s',
                $operator, 
                implode(', ', $allowed)
            ));
        }
        $this->operator = $operator;
    }
    
    public function setDebug($debug) {
        $this->debug = (bool) $debug;
    }

    public function evaluate() {
        if ($this->version === null || $this->desiredVersion === null) {
            require_once 'phing/BuildException.php';
            throw new BuildException("Missing one version parameter for version compare");
        }
        $isValid = version_compare($this->version, $this->desiredVersion, $this->operator);
        if ($this->debug) {
            echo sprintf(sprintf(
                'Assertion that %s %s %s %s' . PHP_EOL,
                $this->version,
                $this->operator,
                $this->desiredVersion,
                ($isValid ? 'passed' : 'failed')
            ));
        }
        return $isValid;
    }
}
