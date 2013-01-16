<?php


class IndexControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \Bisna\Application\Container\DoctrineContainer
     */
    protected $doctrineContainer;

    private function _createUser(){
        $u = new \Champs\Entity\User();
        $u->username = 'ming';
        $u->password = 'aoa';
        $u->password_salt = '123';

        $em  = $this->doctrineContainer->getEntityManager();
        $em->persist($u);
        $em->flush();

        $profiles = array(
            'email' => array(
                'key' => 'email',
                'value' => 'kimchan1314@gmail.com'
            ),
            'phone' => array(
                'key' => 'phone',
                'value' => '92148924'
            )
        );

        foreach ($profiles as $profile){
            $userProfile = new Champs\Entity\UserProfile();
            $userProfile->user = $u;
            $userProfile->profile_key = $profile['key'];
            $userProfile->profile_value = $profile['value'];
            $u->setProfile($userProfile);
            $em->persist($userProfile);
        }

        $em->flush();

//        return $user;
    }

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->bootstrap->bootstrap();
        $this->doctrineContainer = Zend_Registry::get('doctrine');

        $em = $this->doctrineContainer->getEntityManager();

        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $tool->dropDatabase();

        $allMetadata = $em->getMetadataFactory()->getAllMetadata();
        $tool->createSchema($allMetadata);

        parent::setUp();
    }

    public function tearDown(){
        parent::tearDown();

        $this->doctrineContainer->getConnection()->close();
        $em = $this->doctrineContainer->getEntityManager();
        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $tool->dropDatabase();
    }

    public function testUserEntity(){
        $this->assertInstanceOf('Champs\Entity\User', new \Champs\Entity\User());
    }

    public function testUserRepository(){

        $this->_createUser();

        $email = "kimchan1314@gmail.com";
        $em = $this->doctrineContainer->getEntityManager();
        $user = $em->getRepository('\Champs\Entity\User')->getUserByEmail($email);

        $this->assertEquals($email, $user->getProfile('email'));
    }

    public function testSetRole(){
        $guess = new \Champs\Entity\Role();
        $guess->rolename = 'guess';

        $member = new \Champs\Entity\Role();
        $member->rolename = 'member';

        $em = $this->doctrineContainer->getEntityManager();

        $em->persist($guess);
        $em->persist($member);

        $em->flush();

        $this->_createUser();

        $user = $em->find('Champs\Entity\User', 1);
        $user->role = $guess;
//        $user->role->users->add($user);

        $em->flush();

        $em->getRepository('Champs\Entity\User')->setUserToRole(1, $member);

        $user = $em->find('Champs\Entity\User', 1);

        $this->assertEquals($member->rolename, $user->role->rolename);
    }

    public function testConfigImagePath(){
        echo Zend_Registry::get('config')->image->path;
    }

    public function testImageClass(){
        $image = new Champs\Utility\Image('kimchan', 'blog', 1);
        $image->uploadFile('/Users/RyanChan/Desktop/IMG_0354.JPG');



        $this->assertEquals(false, $image->process());
    }
}

