7.0.6
=====

Abandoned Framework. Educational purpose only

Fixes
-----
 - Documentation in markedown format
 - unit tests in x64 version

7.0.5
=====

Clean package distribution for OpenSource

Fixes
-----
  - Travis CI will now build by excluding PHPMD from build
  - add CONTRIBUTING.md + add CHANGELOG.md
  - allow use of phpunit ^5.0 along with ^4.0

7.0.4
=====

Fix error serialization context - merged 6.8.7

Fixes
-----
 - error serialization context

7.0.3
=====

Add code climate dev dependency + fix PMD - merged 6.8.6

Fixes
-----
 - PMD error in FMUP\Framework

Compatible
----------
 - add codeclimate dev dependency

7.0.2
=====

CLI Framework semantic error code - merged 6.8.5

Fixes
-----
 - error code is now an integer representing the blocking error instead of 1 when error occurs. Will return 0 if a non-blocking error occurs

7.0.1
=====

Fix error code returned by CLI Framework when error occurs - merged 6.8.4

Fixes
-----
 - error code is now 1 instead of 0 when error occurs

7.0.0
=====

Compatibility with PHP 7 + rework unit test

Fixes
-----
 - Unit test are now compatible with phpunit 5.4
 - Cache\Driver\Memcached unit test is now testable without memcached
 - Cache\Driver\Apc unit test is now testable without apc
 - Cache\Driver\Apc TTL settings can now apply

New
---
 - Compatible with PHP7

BC Break
--------
 - FMUP\String is renamed FMUP\StringHandling due to PHP7 string type

6.9.0
=====
 
add response headers for CORS
 
#New
- add Access-Control-Allow-Origin and Access-Control-Allow-Credentials headers for CORS response

6.8.8
======

fix dateSQL formatter to permit to return Date or DateTime

#fix
 - fix dateSQL formatter

6.8.7
=====

fix error serialization context

#Fix
 - error serialization context

6.8.6
=====

Add code climate dev dependency + fix PMD

Fixes
-----
 - PMD error in FMUP\Framework

Compatible
-----------
 - add codeclimate dev dependency

6.8.5
=====

CLI Framework semantic error code

Fixes
-----
 - error code is now an integer representing the blocking error instead of 1 when error occurs. Will return 0 if a non-blocking error occurs

6.8.4
=====

Fix error code returned by CLI Framework when error occurs

Fixes
-----
 - error code is now 1 instead of 0 when error occurs

6.8.3
=====

Fix .gitignore

Fixes
-----
 - .gitignore now acts correctly

6.8.2
=====

Regaining PHP 5.4 compatibility

Fixes
-----
 - Downgrade PHP dependencies

6.8.1
=====

Staticify url only when called in html tag

Fixes
-----
 - Staticify will only work on url in src HTML attribute
 - Staticify now allows all whitespaces instead of space only

6.8.0
=====

Staticify + HtmlCompress post processor

New
---
 - Component Dispatcher\Plugin\HtmlCompress - compress html to one line
 - Component Dispatcher\Plugin\Staticify - use static domains names for cookie-free domain + parallel asset download
 - Component Request\Http can now return Request Scheme + Http host

6.7.1
=====

Fixes
-----
 - optional maxLength in ftp module (SFTP driver)

6.7.0
=====

FTP support

New
---
 - Component Import\Config\Field\Formatter\IdFromObject
 - Component Import\Config\Field\Formatter\Interfaces\ObjectWithId
 - Component Import\Config\Field\Formatter\ValueFromArray
 - Component Ftp
    -  Driver FTP
    -  Driver SFTP

Fixes
-----
 - warning on Db\Driver\Pdo\Sqlite

Compatible
----------
 - add technical documentation
 - continuous integration do not build phpdoc by default

6.6.7
=====

All mess counters to zero

Compatible 
----------
 - Db\FetchIterator is not seekable anymore
 - removes Session constants SESSION_STARTED && SESSION_NOT_STARTED. use true and false instead
 - Import\Config\ConfigObjet now returns an empty array instead of null when no mandatory id
 - Optimize Import\Config field calls
 - Removed system from analysis - This folder is deprecated and MUST be deleted in FMUP 7.0.0
 - ErrorHandler\Plugin\Mail now uses external view to render errors
 - Db\Driver\Pdo now uses its configuration from new configuration component Db\Driver\PdoConfiguration

6.6.6
=====

100% Code Coverage + Import\Iterators first/last line handling fixes

Fixes
-----
 - Import\Iterator\FileIterator handle last line
 - Import\Iterator\CsvToConfigIterator config filler
 - Import\Iterator\DuplicateIterator handle first line
 - Import\Iterator\ValidatorIterator handle first line

Compatible
----------
 - add Queue\Channel\Settings 100% code coverage
 - add Queue\Channel\Settings\Native 100% code coverage
 - add Queue\Driver\Amqp 100% code coverage
 - add Queue\Driver\Native 100% code coverage
 - add Import\Launch 100% code coverage
 - add Import\Display 100% code coverage
 - add Import\Config 100% code coverage
 - add Import\Iterator\FileIterator 100% code coverage
 - add Import\Iterator\CsvIterator 100% code coverage
 - add Import\Iterator\LineFilterIterator 100% code coverage
 - add Import\Iterator\CsvToConfigIterator 100% code coverage
 - add Import\Iterator\DuplicateIterator 100% code coverage
 - add Import\Iterator\LineToConfigIterator 100% code coverage
 - add Import\Iterator\ValidatorIterator 100% code coverage
 - add Import\Config\Field 100% code coverage
 - add Import\Config\ConfigObjet 100% code coverage
 - add Import\Config\Field\Formatter\DateSQL 100% code coverage
 - add Import\Config\Field\Formatter\IdFromField 100% code coverage
 - add Import\Config\Field\Formatter\TextToBool 100% code coverage
 - add Import\Config\Field\Validator\Alphanum 100% code coverage
 - add Import\Config\Field\Validator\Boolean 100% code coverage
 - add Import\Config\Field\Validator\Date 100% code coverage
 - add Import\Config\Field\Validator\Email 100% code coverage
 - add Import\Config\Field\Validator\Enum 100% code coverage
 - add Import\Config\Field\Validator\Id 100% code coverage
 - add Import\Config\Field\Validator\Integer 100% code coverage
 - add Import\Config\Field\Validator\MaxLength 100% code coverage
 - add Import\Config\Field\Validator\RegExp 100% code coverage
 - add Import\Config\Field\Validator\Required 100% code coverage
 - add Import\Config\Field\Validator\Telephone 100% code coverage
 - improve Import\Iterator\CsvToConfigIterator optimization
 - renamed Import\Iterator\DoublonIterator to Import\Iterator\DuplicateIterator

6.6.5
=====

Fix dispatcher to avoid multiple default plugins instantiations if externally called

Fixes
-----
 - Dispatcher avoid multiple default plugins instantiations if externally called

6.6.4
=====

Code Coverage 64.8% overall + Url encoding bugfix + String referencies bugfix

Fixes
-----
 - Component Request\Url now produces correct parameters on url
 - Fix string referencies. Will be available on PHP >= 5.5

Compatible
----------
 - add Authentication\Driver\Session 100% code coverage
 - add Config\RequiredTrait 100% code coverage
 - add Config\OptionalTrait 100% code coverage
 - add Config\Ini 100% code coverage
 - add Config\Ini\Extended 100% code coverage
 - add Controller\Error 100% code coverage
 - add Controller\Helper\Download 100% code coverage
 - add Exception\Status\Unauthorized 100% code coverage
 - add Exception\Status\Forbidden 100% code coverage
 - add Exception\Status\NotFound 100% code coverage
 - add Response\Header\CacheControl 100% code coverage
 - add Response\Header\ContentDisposition 100% code coverage
 - add Response\Header\ContentLength 100% code coverage
 - add Response\Header\ContentTransferEncoding 100% code coverage
 - add Response\Header\ContentType 100% code coverage
 - add Response\Header\Expires 100% code coverage
 - add Response\Header\LastModified 100% code coverage
 - add Response\Header\Location 100% code coverage
 - add Response\Header\Pragma 100% code coverage
 - add Response\Header\Status 100% code coverage
 - add Response\Header 100% code coverage
 - add FlashMessenger\Message 100% code coverage
 - add FlashMessenger\View 100% code coverage
 - add FlashMessenger\Driver\Session 100% code coverage
 - add ErrorHandler\Base 100% code coverage
 - add ErrorHandler\Plugin\Abstraction 100% code coverage
 - add ErrorHandler\Plugin\HttpHeader 100% code coverage
 - add ErrorHandler\Plugin\Log 100% code coverage
 - add ErrorHandler\Plugin\Mail 100% code coverage
 - add ErrorHandler\Plugin\ErrorController 100% code coverage
 - add Routing\Route 100% code coverage
 - add Routing\ByMask 100% code coverage
 - add Routing\Route\Cli 100% code coverage
 - add Request\Cli 100% code coverage
 - add Request\Http 100% code coverage
 - add Request\Url 100% code coverage
 - add Dispatcher\Post 100% code coverage
 - add Dispatcher\Plugin 100% code coverage
 - add Dispatcher\Plugin\Version 100% code coverage
 - add Dispatcher\Plugin\Render 100% code coverage
 - add Logger\LoggerTrait 100% code coverage
 - add Logger\Factory 100% code coverage
 - add Logger\Channel 100% code coverage
 - add Logger\Channel\System 100% code coverage
 - add Logger\Channel\Error 100% code coverage
 - add Logger\Channel\Standard 100% code coverage
 - add Logger\Channel\Syslog 100% code coverage

6.6.3
=====

Code Coverage 40.5% overall

Compatible 
----------
 - add Sapi\OptionalInterface component
 - add getRoutes method on Routing Component
 - code clean unit test
 - add Queue 100% code coverage
 - add Cookie 100% code coverage
 - add Environment\OptionalTrait 100% code coverage
 - add Crypt\Factory 100% code coverage
 - add Crypt\Driver\MCrypt 100% code coverage
 - add Crypt\Driver\Md5 100% code coverage
 - add Cache\Driver\File 100% code coverage
 - add Cache\Memcached 100% code coverage
 - add Cache\Driver\Shm 100% code coverage
 - add Cache\Driver\Apc 100% code coverage
 - add String 100% code coverage
 - add Session 100% code coverage
 - add Sapi 100% code coverage
 - add Sapi\OptionalTrait 100% code coverage
 - add Version 100% code coverage
 - add Routing 100% code coverage
 - add Response 100% code coverage
 - add ProjectVersion 100% code coverage
 - add Mail 100% code coverage
 - add Logger 100% code coverage
 - add Import 100% code coverage
 - add Framework class 100% code coverage
 - add ErrorHandler 100% code coverage
 - add Dispatcher 100% code coverage
 - add Db 100% code coverage
 - add Bootstrap 100% code coverage
 - add Authentication 100% code coverage

6.6.2
=====

Code Coverage + unit test

Compatible 
----------
 - Fix Cache\File unit test compilation
 - String code clean to have 11.8% code coverage + better checkstyle trend

6.6.1
=====

Fix Session

Fixes
-----
 - Session id can now be changed

6.6.0
=====

Auth module and sanitize

New
---
 - Component Authentication - allows to have a user in session
 - String::sanitize

6.5.2
=====

Phpunit centralization

Compatible 
----------
  - Phpunit centralized to use configuration file on build (need to be refactored when phing can do that)

6.5.1
=====

Version plugin with multiple version

Fixes
-----
  - Dispatch Plugin Version can now handle url with parameter to avoid multiple project version tagging

6.5.0
=====

Cookies in bootstrap + Queue message acknowledgement

New
---
  - Component Bootstrap can now return Cookie object
  - Component Queue allows to ack a message
    - Settings allows to define auto-ack but set to false by default
  - Logger Standard extends from System which extends from Syslog

6.4.2
=====

Smart start Session + fix notice dispatcher

Fixes
-----
  - Session start on set/get
  - Dispatcher warning on array_flip()

6.4.1
=====

Fix Session in CLI

Fixes
-----
  - Session start only if available / Now uses Sapi to avoid CLI session_start

6.4.0
=====

Dispatcher plugin Version + Dispatcher plugins can be manually removed

New
---
  - Component Dispatcher\Plugin\Version - add project version behind script + link url to allow version browser cache
  - Dispatcher can now remove a plugin

Compatible
----------
  - Code clean
  - Renamed Import\Config\Field\Validator\LongueurMax to Import\Config\Field\Validator\MaxLength

Fixes
-----
  - Session start only if available

6.3.1
=====

Fix Controller unit test for Jenkins compilation

Fixes
-----
 - Controller unit test don't compile class referencies

6.3.0
=====

Syslog Logger channel by default + phpunit native HTML report

New
---
  - View component now throws \FMUP\Exception\UnexpectedValue instead of OutOfBoundsException and InvalidArgumentException with a specific code
  - Component Logger\Channel\Syslog - This channel is now base for Standard (default) channel
  - add phpunit configuration to generate neat native code coverage HTML report + color in CLI

Fixes
-----
  - View::getParam, View::setParam and View::setViewPath throw \FMUP\Exception\UnexpectedValue in case of non string parameter

Compatible
----------
  - New Unit test
    - Cookie
    - View
  - Controller unit test 100% code coverage
  - Add PHP documentation on Logger\Interface
  - Add PHP documentation on Controller

6.2.3
=====

Fix Mcrypt security - merged 5.3.2

Fixes
-----
 - Mcrypt IV security needs to be 16 char long
 - renamed documentation to index

New
---
 - add some documentation in Response

6.2.2
=====

FMUP\Mail configure auto tls

Fixes
-----
  - FMUP\Mail configure auto tls
  - use of php-amqplib/php-amqplib that is maintained

6.2.1
=====

Code Clean + fix date + iterator issues

Compatible
----------
 - Code Clean
 
Fixes
-----
  - Iterator ArrayToObjectIterator now returns indexes
  - Date conversion

6.2.0
=====

Add application/json header (Merge 5.3.0)

New
---
 - Response\Header\ContentType adds application/json header

6.1.7
=====

Fix FetchIterator rewind

Fixes
-----
 - FetchIterator now execute query on rewind instead of continuing iterations

6.1.6
=====

Fixes
-----
 - Import\Iterator\CsvToConfigIterator Bugfix import ligne vide

6.1.5
=====

Fixes
-----
 - LoggerTrait
 - Merged 5.2.3

6.1.4
=====

Fixes
-----
 - Import CsvToConfigIterator
 - Merge 5.2.2
 - Import\Iterator\CsvToConfigIterator now doesn't read the column not set and reinitialise the config if the line has less columns

6.1.3
=====

Fix Import CsvIterator (merge 5.2.1)

Fixes
-----
 - Import\Iterator\CsvIterator now reads the last line
 - Is::half() cannot have unexpected null return

6.1.2
=====

Encoding clean

Fixes
-----
 - Clean message in Framework to be utf8 encoded

6.1.1
=====

Code clean

Compatible 
----------
 - Code clean
 - Fix release note to added feature

6.1.0
=====

Add some Import validators (merge 5.2.0)

New
---
 - Component Import\Config\Field\Validator
    - Date can now check date without separator
    - Email can allow empty
    - Integer can allow empty
    - RegExp can allow empty
    - Telephone can allow empty
    - HalfOrInteger
  - Response can now return code for cli with method setReturnCode

6.0.0
=====

Code Quality + Performance on result sets

Incompatible 
------------
 - Deleted generateur
 - Deleted db_connection classes
 - Deleted db_helper
 - Deleted console
 - Deleted debug
 - Deleted view
 - Deleted helpers
 - Deleted unused code
 - Deleted javascript
 - Deleted historisation
 - Deleted config -- Some FMUP components need FMUP\Config now (to be defined in bootstrap)
 - Deleted BASE_PATH constant
 - Deleted use of global var ($sys_controller, $sys_directory, $sys_function)
 - Deleted use of REQUEST['sys']
 - Deleted usage of APP* constant
 - Deleted App* components
 - Deleted all use of flog
 - Deleted config is_logue -- replaced by Model::setIsLogue
 - Deleted Model::ISOtoUTF8 (this is a bad patch, fix in your page + file encoding)
 - Framework::getRouteError needs two parameters ($directory, $controller)
 - Deleted multi tab from framework
 - Deleted Framework::instantiateSession
 - Deleted methods in Sql
    - parseOrder
    - parseSelect
    - parseJoin
 - Renamed \String::toCamlCase to \FMUP\String::toCamelCase
 - Deleted Constantes
 - Deleted FMUP\Db\Driver\Mock
 - Renamed FMUP\Helper\Db to FMUP\Db\Manager
 - Deleted emailHelper. use FMUP\Mail decorator instead
 - Deleted date
 - Deleted Tool\Log
 - Deleted Import\LiaisonBase
 - Deleted methods in Model
    - getHistoriqueSurObjet
    - getHistoriqueSurObjetDiffLibelle

New
---
 - Session can now define all values at once by setting an array
 - Db\DbInterface allows 2 optional parameters to fetchRow. cursorOrientation + cursorOffset
 - Db\FetchIterator - This allows to handle result sets without loading all in PHP
 - array_to_object_iterator - this allows to migrate old Model::objectsFromMatrix with FetchIterator system
 - Model::objectsFromMatrix allows a third optional parameter to specify to return new iterator system or old array system (iterator by default)
 - Model::objectsFromArray is now public
 - Model::findAllFromTable allow a parameter iterator in options to set to false to disable iterator feature

Compatible
----------
 - Deleted config/is_debug by using display_errors instead
 - Deleted use of $_SESSION / use FMUP\Session instead
 - Model uses fetchRow instead of fetchAll when possible
 - clean up some code
 - clean up some checkstyle

Fixes
-----
 - ByMask routing to handle only request uri without query string
 - Db\Driver\Pdo do not warning when SQL exception occurs

5.3.2
=====

Fix Mcrypt security

Fixes
-----
 - Mcrypt IV security needs to be 16 char long
 - renamed documentation to index

5.3.1
=====

Fix auto tls configuration for PHPMailer

Fixes
-----
 - auto tls configuration for PHPMailer

5.3.0
=====

Add application/json header

New
---
 - Response\Header\ContentType adds application/json header

5.2.4
=====

Fixes
-----
 - Import\Iterator\CsvToConfigIterator Bugfix import ligne vide

5.2.3
=====

Fix LoggerTrait

Fixes
-----
 - LoggerTrait notice - uses real protected logger

5.2.2
=====

Fix Import CsvToConfigIterator

Fixes
-----
 - Import\Iterator\CsvToConfigIterator now doesn't read the column not set and reinitialise the config if the line has less columns

5.2.1
=====

Fix Import CsvIterator

Fixes
-----
 - Import\Iterator\CsvIterator now reads the last line
 - Is::half() cannot have unexpected null return

5.2.0
=====

Add some Import validators

New
---
 - Component Import\Config\Field\Validator
    - Date can now check date without separator
    - Email can allow empty
    - Integer can allow empty
    - RegExp can allow empty
    - Telephone can allow empty
    - HalfOrInteger
  - Response can now return code for cli with method setReturnCode

5.1.1
=====

Some Unit Test to make FMUP release stable again on Jenkins

Fixes
-----
 - Unit tests

5.1.0
=====

Performance on Dispatcher / ErrorHandler / Queue / Routing

Fixes
-----
 - Framework dependency with SAPI
 - Db can load if config is not defined

New
---
 - LazyLoad on Dispatcher / ErrorHandler / Queue / Routing
 - Component Routing/ByMask to load a specific route matching a path instead of loading multiple objects that might not be used

5.0.2
=====

FMUP Bootstrap Environment + Logger confusion

Fixes
-----
 - FMUP Bootstrap Environment + Logger confusion

5.0.1
=====

AMQP Queue system allows specific AMQPMessage

New
---
 - AMQP Queue system allows specific AMQPMessage

5.0.0
=====

Framework CLI

New
---
 - Component Sapi
 - Component Routing\Route\Cli
 - Component Request\Cli
 - Component Request\Http
 
Incompatible 
------------
 - Request\Http is now abstract - you have to use Request\Http if you want to create new request (compatible because no one wants to create a request)
 - Require now PHP >= 5.4 due to use of Traits

4.3.1
=====

AMQP Queue system allows specific AMQPMessage

New
---
 - AMQP Queue system allows specific AMQPMessage

4.3.0
=====

AMQP Queue system + fix mail error fatal

New
---
 - Component Queue\Driver\Amqp
 - Component Queue\Channel
 - Component Queue\Channel\Settings

Fixes
-----
 - Error mail sent on error

4.2.0
=====

Db force reconnect + Queue\Driver\Native Environment + Queue\Driver\Native retry

New
---
 - Component Environment\OptionalTrait
 - Queue\Driver\Native can now handle Environment
 - Queue\Driver\Native can now handle Retry setting
 - FMUP\Db can now forceReconnection
 - Crypt unit test

Fixes
-----
 - Do not load Headers handler in FMUP\Logger on cli SAPI
 - add suggest for memcached + sysvmsg extensions

4.1.0
=====

LoggerInterface + Db Logging + Queue System is non blocking

New
---
 - Component Logger\LoggerInterface
 - Component Logger\LoggerTrait
 - Component Db now uses a Logger
 - add documentation
 - UnitTest Controller
 - Queue\Driver\Native can now set blocking option on send and/or receive

Delete
------
  -FMUP\Db\Driver\Mock (was useless)
  
4.0.6
=====

Error Mail encoding + fix mail support separator char

Fixes
-----
  - Error Mail encoding
  - mail support separator char for Tools\Log (now handles ; and ,)

4.0.5
=====

Fix blocking messages in native queue system on send

Fixes
-----
  - blocking messages in native queue system on send

4.0.4
=====

Fix notice on PDO exception error code

Fixes
-----
  - notice on PDO exception error code

4.0.3
=====

Fix exception on session redirection

Fixes
-----
  - exception on session redirection

4.0.2
=====

Fix Blocking Exception

Fixes
-----
  - Exception is not thrown anymore on not important errors (but still logged)

4.0.1
=====

Fix Pdo Sqlite

Fixes
-----
  - Db\Driver\Pdo\Sqlite was doing exception due to inaccessibility of params
  
New
---
  - Db\Driver\Pdo offers now a protected getSettings method
  - error to exception now sends file+line+context in its error message

4.0.0
=====

Cleanup release + Unit Testing + Environmental Configs + ErrorHandler + Logger\Channel

New
---
  - Overridable singleton
  - Bootstrap can tell if already warmed up
  - Component Exception\Status\Unauthorized
  - many status header added to Response\Header\Status - (VALUE_BAD_REQUEST / VALUE_UNAUTHORIZED / VALUE_PAYMENT_REQUIRED / VALUE_METHOD_NOT_ALLOWED / VALUE_NOT_ACCEPTABLE / VALUE_PROXY_AUTH_REQUIRED / VALUE_REQUEST_TIMEOUT / VALUE_CONFLICT / VALUE_GONE / VALUE_LENGTH_REQUIRED / VALUE_PRECONDITION_FAILED / VALUE_PAYLOAD_TOO_LARGE / VALUE_REQUEST_URI_TOO_LONG / VALUE_UNSUPPORTED_MEDIA_TYPE / VALUE_REQUESTED_RANGE_NOT_SATISFIABLE / VALUE_EXPECTATION_FAILED / VALUE_I_AM_TEAPOT)
  - ErrorHandler component - This component can be injected in Framework and act when uncaught exception occurs
  - Component ErrorHandler\Plugin\ErrorController
  - Component ErrorHandler\Plugin\HttpHeader
  - Component ErrorHandler\Plugin\Log
  - Component ErrorHandler\Plugin\Mail
  - Component Logger\Channel
  - Component Environment - can use ENVIRONMENT constant if defined
  - Component Config\Ini
  - Component Config\Ini\Extended - uses external dependencies with old Zend_Config_Ini component // this component had been migrated to be compatible with FMUP
  - Component Config\Exception
  - Component Config\ConfigInterface - You must use this interface instead of Config dependencies
  - Component Cache\Driver\Memcached now allows a prefix for keys (SETTINGS_CACHE_PREFIX)
  - Component Logger\LoggerTrait
  - Component Db\Driver\Pdo\Mysql - this might be more efficient than a Pdo with dsn driver set to mysql since it can be extended + uses cached queries
  - Tests\Cache
  - Tests\Cache\Factory
  - Tests\Cache\Driver\Ram
  - Tests\Cache\Driver\Apc
  - Tests\Cache\Driver\Memcached
  - Tests\Cache\Driver\Shm

Fixes
-----
  - Cache\Driver\Shm must use id for keys - internal transformation
  - Cache\Driver\Apc checks now if APC is enabled
  - Cache\Driver\Apc tries to insert two times with two different method on failure

Compatible 
----------
  - rearchitectured Db\PDO\Drivers to be more SOLID
  - Status Error 500 is now sent on error
  - Fix some Coding Style
  - Migrate FMUP to use Config\ConfigInterface dependencies instead of Config
  - Autoloader define its BASE_PATH wich is still required by the framework - allows you to forget to implement it or override it

Deprecated 
----------
  - App* are now deprecated and not used anymore by default - Use preDispatcher/postDispatchers instead or a master class to extends from
  - \Debug - use Logger instead
  - \Console - use Logger instead

Delete 
------
  - Component \FMUP\Error - use Exceptions instead
  - Component \Error - use Exceptions instead
  - Component \Controller - use \FMUP\Controller instead (override public function getActionMethod($action){ return $action} for backwards compatibility)
  - Component \NotFoundError - Use Exception\Status\NotFound instead
  - Framework do not uses ErrorController anymore - use ErrorHandler + ErrorController Plugin instead

BC Break 
--------
  - Db drivers now sends Db\Exceptions instead of \PDOExceptions (still available in exception chain)
  - Factory are now singletons
  - Overridable singleton - Use getInstance()->method for all other static than ::getInstance()
  - Singletons are now more SOLID by closing getInstance extendability
  - Logger now uses channels instead

3.3.3
=====

Fix some memory leak

Fixes
-----
 - deleted most of "create_function" call that causes memory leak on multiple calls
 
3.3.2
=====

ErrorController now calls its preFilter/postFilter

Fixes
-----
 - ErrorController now calls its preFilter/postFilter

3.3.1
=====

Deleted 
-------
  - Import\test.php - fails continuous integration
  
3.3.0
=====

New
---
  - component Cache\Apc
  - component Cache\Memcached
  - component Response\Header\ContentDisposition
  - component Response\Header\ContentLength
  - component Response\Header\Expires
  - component Response\Header\LastModified
  - component Response\Header\Pragma
  - component Import\Config\Field\Validator\Enum
  - component Import\Config\Field\Validator\RegExp
  - component Import\Iterator\CsvIterator
  - component Import\Iterator\CsvToConfigIterator
  - component Crypt\Driver\MCrypt
  - \FMUP\Controller can now change their action suffix
  - \Import\Config\Field can now add Validator with defined name
  - \Queue\Driver\Native can now be configured
  
Fixes
-----
  - \Import\Config\Field\Date allow now empty date setting
  - Model do not throw notice anymore when comparing objects on save
  - Queue\Driver\Native uses SystemV default size (probably 16ko) instead of 512o
  
Compatible 
----------
  - Rearchitectured FMUP\Db\Pdo\Drivers to be more SOLID
  - Singletons are now mostly overridable

3.2.0
=====

Add support of some SystemV features

Fixes
-----
  - Driver Cache\File

Compatible 
----------
  - Framework uses is_callable instead of method_exists (can not call private/protected methods)
  
New
---
  - Component Response\Header\CacheControl
  - Component Response\Header\ContentLength
  - Component Response\Header\Expires
  - Component Response\Header\LastModified
  - Component Response\Header\Pragma
  - Component Queue
  - Component Cache\Driver\Shm
  - New controllers allow to modify their action suffix  
  - Daily error message uses correct error_log system to have exception logs
  
3.1.2
=====

Fixes
-----
  - Fix DbConnectionMysql transaction methods
  
3.1.1
=====

Fixes
-----
  - Fix DbConnectionMysql transaction
  
3.1.0
=====

Fixes
-----
  - Can use \FMUP\Db in helpers

New
---
  - Crypt component
  - Crypt\Md5 component
  - Session can regenerate
  - Db::lastInsertId can now accept a param

3.0.0
=====

Continuous integration refactoring

New
---
  - Component \FMUP\Exception\Location
  - Component \FMUP\Response\Header\Location
  - Unit test for \FMUP\Config
  - added PHPdoc + strong typing
  - added code coverage

Fixes
-----
  - postDispatch is now called everytime even in case of error
  - session can change its name if not started
  - code coverage now set
  - continuous integration can now compute logs
  - system components can now be loaded
  - Validator Import\Config\Field\Validator\LongueurMax
  - deleted LogiCE reference
  - strong typing in view params
  - removed DbConnectionMysql hard referencies
  - Import will send Exception instead of crash in case of error
  - Import on update
  - cleanup some code style

Deprecated 
----------
 - Redirect method in controller - use \FMUP\Exception\Location instead
 - Framework - use \FMUP\Framework instead
 - CronHelper - use package cron/cron instead (do not need mysql database)
 - Error - use any exception + \FMUP\Controller\Error instead
 - DbConnectionMysql - use \FMUP\Db instead
 
BC Break 
--------
  - renamed preFiltre and postFiltre in preFilter and postFilter in controller
  - preFilter and postFilter in controller have optional parameter of called action
  - Session component do not take session name in session instance anymore
  - deleted deprecated method Controller::getDb()
  - deleted system/component/pdf/fpdf
  - renamed component php views in phtml views
  - component PDFHelper now throws LogicException if TCPDF is missing
  - Constantes do not extends ConstantesApplication anymore

2.1.4
=====

ErrorController now calls its preFiltre

Fixes
-----
 - ErrorController now calls its preFiltre

2.1.3
=====

Fix Some accent

Fixes
-----
 - MathHelper::getPourcentageEvolution now returns something without number_format
 - FiltreListe attribute now encodes in utf-8
 - \Date::getTableauLibelleMois() fix Août encoding
 
2.1.2
=====

Fix Import

Fixes
-----
 - Import will send Exception instead of crash in case of error
 - Import on update
 
2.1.1
=====

Fix EmailHelper

Fixes
-----
 - EmailHelper back to its previous behaviour. Fix should be applied in your project
 
2.1.0
=====

Add import component

Fixes
-----
 - Component DbConnectionMssql return id in update
 - EmailHelper is now based on template name instead of id
 
New
---
 - Component Import

2.0.1
=====

Compliance with old FMU 1.0.0.6 components

Fixes
-----
 - Component generateur to load correct PATH
 - Component console to load correct PATH
 - Component filtre_liste to load correct PATH
 - DbConnectionMssql to be usable in CLI
 - DbHelper can load DbConnectionMssql driver

2.0.0
=====

Industrialization + new FMU 1.0.0.6 compatibility

New
---
 - PHPMailer no longer needed in lib folder - FMUP Dependency thanks to composer
 - FPDF no longer needed in lib folder - FMUP Dependency thanks to composer
 - Version system based on composer
 - Continuous integration
 - added component generateur
 - added component Filtre Liste
 - added Helper Bouton
 - added Helper CronHelper
 - added Helper LangueHelper
 - added Helper MathHelper
 - added Helper PaiementHelper
 - added Helper Pdf
 - added Helper Sage
 - Enhanced String
 - Add Db\Driver\Sqlite
 
Fixes
-----
 - Config can now be called in cli
 - UniteHelper for number format
 - PDF Componant can now work in standalone mode
 
BC Break 
--------
  - Method SetFlash in controller now handle only one parameter
  - Method preFiltre in controller now handle an optional parameter $calledAction (must be declared in controllers)
  - Langue is now a helper
  - DbConnection is renamed DbConnectionMssql
  - Deleted Droit
  - Deleted Helper\ArbreHelper
  - Deleted Helper\Boutons
  - Deleted Helper\FormatReferences
  - Deleted Helper\PagingHelper
  - Deleted Helper\PopinHelper
  - Deleted Helper\RequeteHelper
  - Config deleted all specific methods - use paramsVariables instead
  - Deleted deprecated methods in Date
  - Deleted deprecated methods in Debug
  - Deleted deprecated methods in Helper\Constant
  - Deleted Navigation::siteOuvert - now in config
  - Model do no longer extends FiltreListe
  - FormHelper delete deprecated methods
  - FormHelper now add a $editable param in almost all its method - this param is placed before $options
  - Models don't use flashmessenger anymore
  - config.ini no longer used - use config.php instead
  - layouts must no longer be in view\Layout folder but directly in a layout folder

Deprecated  
----------
  - Controller - use \FMUP\Controller
  - View - use \FMUP\View
  - Framework - use \FMUP\Framework

1.2.2
=====

PHPMailer dependency

Fixes
-----
 - Use phpmailer composer dependency instead of require_once

1.2.1
=====

ErrorController now calls its preFiltre

Fixes
-----
 - ErrorController now calls its preFiltre

1.2.0
=====

FlashMessenger accessible by bootstrap + Url creation

New
---
 - Add Referer in request
 - Add FlashMessenger in Bootstrap
 - Add Request\Url component to create url in object
 
Fixes
-----
 - Redirect method
 - modifier in model

1.1.3
=====

Fix memory leak on SQL

Fixes
-----

 - memory leak when using where clause in SQL

1.1.2
=====

Fix multiple notice when log table is not handled properly

Fixes
-----

 - Fix multiple notice when log table is not handled properly

1.1.1
=====

Login now redirect to requested page + add Session in bootstrap

New
---
 - Login now redirect to requested page
 - add Session in bootstrap

Fixes
-----
 - Tidy up some code
 
1.1.0
=====

Error controller will now need a specific render

New
---
 - Add Bootstrap system + add Monolog logger
 - Request can test uploded files

Deprecated 
----------
 - DbConnection - use \FMUP\Db instead
 - Controller::getDb
 - Debug - use logs instead

Fixes
-----
 - Tidy up some code
 
BC Break 
--------
 - ErrorController is now abstract

1.0.0
=====

First stable release

Compatibility 
-------------
 - Update compatibility with PHP >= 5.3

New
---
 - ErrorController can be override
 - Db can now be multiton
 - Component Session
 - Component Pre/Post Dispatcher system
 - Component Header/Status
 - Component Db/Driver/Pdo/Odbc
 - Component Db/Driver/Pdo/SqlSrv
 - Component Cookie
 - Autoloader

Deprecated 
----------
 - Component View - Use FMUP\View

Fixes
-----
 - Use Session component
 
BC Break
--------
 - FMUP\View don't define its view path by default

0.2.0
=====

Add cache + Exception for dispathing + FlashMessenger + view compliance with FMU

New
---
 - View can access params by $this or variable
 - Component Cache
 - Component Cache\Ram
 - Exception Forbidden
 - Component Db\Mock
 - Ability to redefine its own ErrorController
 - Component FlashMessenger

BC Break
--------
 - Controller add suffix Action to be called
 - Exception NotFound moved to Exception\Status\NotFound
 - preFiltre in controller need an $action parameter to know which action is called


0.1.0
=====

initial FMUP release

New
---
 - Component Db
 - Component Helper\Db
 - Component Response
 - Component Routing
 - Component Tools\Log
 - Component Controller
 - Component Error
 - Component Exception
 - Component Framework
 - Component Request
 - Component View