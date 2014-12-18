<?php
 
require_once './../simpletest/autorun.php';
 
// Il faut inclure le fichier à tester
require_once './../src/lib.php';
 
/**
 *
 * Classe de test de la classe lib
 * @author nvergnes
 *
 */
class libTest extends PHPUnit_Framework_TestCase {
 
    /**
     *
     * Test du constructeur. On s'assure de la bonne initialisation.
     */
	
	public function setUp() {
		$this->app = new Chat();
	}
    function testGetOnlineUsers() {
       $this->app->c['UserOnlineMapper'] = $this->getMockBuilder('\OCA\Chat\OCH\Db\UserOnlineMapper')
			->disableOriginalConstructor()
			->getMock();
		$this->app->c['UserOnlineMapper']->expects($this->any())
			->method('getOnlineUsers')
			->will($this->returnValue($onlineUsers));
		$this->app->c['BackendManager'] = $this->getMockBuilder('\OCA\Chat\BackendManager')
			->disableOriginalConstructor()
			->getMock();
		$this->app->c['BackendManager']->expects($this->any())
			->method('getBackendByProtocol')
			->will($this->returnValue($OCHBackend));
		$this->app->c['SyncOnlineCommand'] = $this->getMockBuilder('\OCA\Chat\OCH\Commands\SyncOnline')
			->disableOriginalConstructor()
			->getMock();
		$this->app->c['ContactsManager'] = $this->getMockBuilder('\OC\ContactsManager')
			->disableOriginalConstructor()
			->getMock();
		$this->app->c['ContactsManager']->expects($this->any())
			->method('search')
			->will($this->returnValue($rawContacts));
		$result = $this->app->getContacts();
		$this->assertEquals($parsedContacts, $result);
      
		
    }
    
    public function testGetContactsCache() {
		$this->app->c['ContactsManager'] = $this->getMockBuilder('\OC\ContactsManager')
			->disableOriginalConstructor()
			->getMock();
		$this->app->c['ContactsManager']->expects($this->never())
			->method('search');
		$result = $this->app->getContacts();
		$this->assertEquals($parsedContacts, $result);
	}
	
	public function testGetUserasContact(){
		$this->app->c['BackendManager'] = $this->getMockBuilder('\OCA\Chat\BackendManager')
			->disableOriginalConstructor()
			->getMock();
		$this->app->c['BackendManager']->expects($this->any())
			->method('getBackendByProtocol')
			->will($this->returnValue($OCHBackend));
		$this->app->c['ContactsManager'] = $this->getMockBuilder('\OC\ContactsManager')
			->disableOriginalConstructor()
			->getMock();
		$this->app->c['ContactsManager']->expects($this->any())
			->method('search')
			->will($this->returnValue($rawContacts));
		$result = $this->app->getUserasContact($UID);
		$this->assertEquals($expectedResult, $result);
	}
    
    
    
}
 
?>