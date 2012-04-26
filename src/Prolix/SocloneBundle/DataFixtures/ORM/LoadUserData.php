<?php
namespace Prolix\SocloneBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Prolix\SocloneBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $path = __DIR__.'/../users.xml';

        if (file_exists($path))
          $user_xml = simplexml_load_file($path);
        else
          new \Exception\FileNotFoundException("No file found at path [$path]");

        $encoder = $this->container->get('security.encoder_factory')->getEncoder(new User());

        foreach ($user_xml->xpath("//users//row") as $row) {
          $username = (string)$row['DisplayName'];
          $id = (string)$row['Id'];
          $date = (string)$row['CreationDate'];
          $email = "$id@test.com";

          if ($id < 0)  continue;

          echo "Saving $id, $username, $date\n";

          $user = new User();

          $user->setId($id);
          $user->setUsername($email);
          $user->setPassword($encoder->encodePassword('123456', $user->getSalt()));
          $user->setUsernameCanonical($username);
          $user->setEmail($email);

          $manager->persist($user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
