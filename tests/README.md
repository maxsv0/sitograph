<p align="center">
  <img src="http://ci.msvhost.com:8080/job/dev.sitograph.com/badge/icon">
</p>

# To execute PHPUnit test run:

```bash
/usr/bin/php /usr/local/bin/phpunit --configuration tests/phpunit.xml tests/phpunit 
``` 

## View tests results 
Results will be saved to tests/phpunit-report/

```xml
<log type="coverage-html" target="./phpunit-report" lowUpperBound="35" highLowerBound="70"/>
<log type="coverage-clover" target="./phpunit-report/coverage.xml"/>
<log type="coverage-text" target="php://stdout" showUncoveredFiles="false"/>
<log type="junit" target="./phpunit-report/logfile.xml"/>
``` 

## Current state 

Online reports from Jenkins
http://ci.msvhost.com/

