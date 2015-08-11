<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
$dbParams = array(
    'database'  => 'lakari',
    'username'  => 'root',
    'password'  => '',
    'hostname'  => '127.0.0.1',
    // buffer_results - only for mysqli buffered queries, skip for others
    'options' => array('buffer_results' => true)
);

return array(
   'db' => array(
         'driver'         => 'Pdo',
         'dsn'            => 'mysql:dbname=lakari;host=127.0.0.1',
         'username' => 'root',
         'password' => '',
         'driver_options' => array(
             PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
         ),
     ),
     'service_manager' => array(
         'factories' => array(
             'Zend\Db\Adapter\Adapter'
                     => 'Zend\Db\Adapter\AdapterServiceFactory',
         ),
     ),
    
//       'service_manager' => array(
//        'factories' => array(
//            'Zend\Db\Adapter\Adapter' => function ($sm) use ($dbParams) {
//                $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter(array(
//                    'driver'    => 'pdo',
//                    'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
//                    'database'  => $dbParams['database'],
//                    'username'  => $dbParams['username'],
//                    'password'  => $dbParams['password'],
//                    'hostname'  => $dbParams['hostname'],
//                     'driver_options' => array(
//                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
//                     ),
//                ));
//
//                if (php_sapi_name() == 'cli') {
//                    $logger = new Zend\Log\Logger();
//                    // write queries profiling info to stdout in CLI mode
//                    $writer = new Zend\Log\Writer\Stream('php://output');
//                    $logger->addWriter($writer, Zend\Log\Logger::DEBUG);
//                    $adapter->setProfiler(new BjyProfiler\Db\Profiler\LoggingProfiler($logger));
//                } else {
//                    $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler());
//                }
//                if (isset($dbParams['options']) && is_array($dbParams['options'])) {
//                    $options = $dbParams['options'];
//                } else {
//                    $options = array();
//                }
//                $adapter->injectProfilingStatementPrototype($options);
//                return $adapter;
//            },
//        ),
//    ),
);
