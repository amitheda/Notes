<?php

namespace Notes\Mapper;

use Notes\Mapper\Session as SessionMapper;
use Notes\Model\Session as SessionModel;
use Notes\Config\Config as Configuration;
use Notes\Exception\ModelNotFoundException as ModelNotFoundException;


class SessionTest extends \PHPUnit_Extensions_Database_TestCase
{
    private $connection;
    
    public function getConnection()
    {
        $config     = new Configuration("app/Config/config.json");
        $configData = $config->get();
        $dbHost     = $configData['dbHost'];
        $dbName     = $configData['dbName'];
        $hostString = "mysql:host=$dbHost;dbname=$dbName";
        
        try {
            $this->connection = new \PDO($hostString, $configData['dbUser'], $configData['dbPassword']);
            $this->connection->exec("set foreign_key_checks=0");
            return $this->createDefaultDBConnection($this->connection, $dbName);
        }
        catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        
        }
    
     public function getDataSet()
    {
        return $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_seed.xml');
    }
    
    public function testCreateNewSession()
    {
            $input  = array(
            'userId' => 1,
            'createdOn' => '2015-01-01 10:00:01',
            'expiredOn' => '2015-01-01 10:00:01'
        );
        $sessionModel = new SessionModel();
        $sessionModel->setUserId($input['userId']);
        $sessionModel->setCreatedOn($input['createdOn']);
        $sessionModel->setExpiredOn($input['expiredOn']);
        $sessionMapper = new SessionMapper();
        $sessionModel = $sessionMapper->create($sessionModel);
         $query         = "select id, userId,createdOn, expiredOn,isExpired from Sessions";
        $queryTable    = $this->getConnection()->createQueryTable('Sessions', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_after_insert.xml')->getTable("Sessions");
        $this->assertTablesEqual($expectedTable, $queryTable);
        $this->assertEquals('3', $sessionModel->getId());
        $this->assertEquals('1', $sessionModel->getUserId());
        $this->assertEquals('2015-01-01 10:00:01', $sessionModel->getCreatedOn());
        $this->assertEquals('2015-01-01 10:00:01', $sessionModel->getExpiredOn());
    }
   

    public function testCanReadById()
    {   
        $input = array('id' => 2);

        $sessionModel  = new SessionModel();
        $sessionModel->setId($input['id']);
        $sessionMapper = new SessionMapper();
        
         $sessionModel   =  $sessionMapper->read($sessionModel);
        $expectedDataSet = $this->createXmlDataSet(dirname(__FILE__) . '/_files/session_seed.xml');
        $actualDataSet   = $this->getConnection()->createDataSet(array(
            'Sessions'
        ));
        $this->assertDataSetsEqual($expectedDataSet, $actualDataSet);
        $this->assertEquals('2', $sessionModel->getId());
        $this->assertEquals('2', $sessionModel->getUserId());
        $this->assertEquals('2015-01-01 11:00:01', $sessionModel->getCreatedOn());
        $this->assertEquals('2015-01-10 01:01:01', $sessionModel->getExpiredOn());
    }

   /**
     * @expectedException        Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage Can Not Found Given Model In Database
     */
    public function testSessionIdDoesNotExist()
    {
        $input        = array(
                  'id' => 5
        );
        $sessionModel = new SessionModel();
        $sessionModel->setId($input['id']);
        
        
        $sessionMapper = new Session();
        $sessionModel  = $sessionMapper->read($sessionModel);
        
    }
    
   public function testUpdateSession()
    {

        $input = array(
            
                    
                    'id' => '1',
                    'userId' => '1',
                    'expiredOn' => '2015-01-01 01:00:01',
                    'isExpired' => '1'
                );
        $sessionModel = new SessionModel();
        $sessionModel->setId($input['id']);
        $sessionModel->setUserId($input['userId']);
        $sessionModel->setExpiredOn($input['expiredOn']);
        $sessionModel->setIsExpired($input['isExpired']);
        $sessionMapper = new SessionMapper();
        $sessionMapper->update($sessionModel);
        $query         = "select id, userId,createdOn, expiredOn,isExpired from Sessions";
        $queryTable    = $this->getConnection()->createQueryTable('Sessions', $query);
        $expectedTable = $this->createXMLDataSet(dirname(__FILE__) . '/_files/session_after_update.xml')->getTable("Sessions");
        $this->assertTablesEqual($expectedTable, $queryTable);
        $this->assertEquals('1', $sessionModel->getId());
        $this->assertEquals('1', $sessionModel->getUserId());
        $this->assertEquals('2015-01-01 01:00:01', $sessionModel->getExpiredOn());
        $this->assertEquals('1', $sessionModel->getIsExpired());

    }

   
     /**
     * @expectedException        Notes\Exception\ModelNotFoundException
     * @expectedExceptionMessage Can Not Found Given Model In Database
     */
    public function testFailedForUpdate()
    {  
      $input = array(
                    'id' => '5',
                    'userId' => '2',
                    'expiredOn' => '2015-01-01 01:00:01',
                    'isExpired' => '1'
                );

        $sessionModel = new SessionModel();
         $sessionModel->setId($input['id']);
        $sessionModel->setUserId($input['userId']);
        $sessionModel->setExpiredOn($input['expiredOn']);
        $sessionModel->setisExpired($input['isExpired']);

        $sessionMapper = new SessionMapper();
        $sessionModel = $sessionMapper->update($sessionModel);
               
    }
     }
