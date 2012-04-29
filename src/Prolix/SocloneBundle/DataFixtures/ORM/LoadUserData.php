<?php
namespace Prolix\SocloneBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Prolix\SocloneBundle\Entity\User;
use Prolix\SocloneBundle\Entity\Question;
use Prolix\SocloneBundle\Entity\Answer;

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

        $user_list = array();

        foreach ($user_xml->xpath("//users//row") as $row) {
          $username = (string)$row['DisplayName'];
          $id = (string)$row['Id'];
          $date = (string)$row['CreationDate'];
          $email = "$id@test.com";

          $user_list[$id] = $username;

          if ($id < 0)  continue;

          echo "Saving $id, $username, $date\n";

          $user = new User();

          $user->setId($id);
          $user->setUsername($email);
          $user->setDisplayName($username);
          $user->setPassword($encoder->encodePassword('123456', $user->getSalt()));
          $user->setUsernameCanonical($username);
          $user->setEmail($email);

          $manager->persist($user);
        }
        $manager->flush();

        $path = __DIR__.'/../posts.xml';
        if (file_exists($path))
          $posts = simplexml_load_file($path);
        else
          new \Exception\FileNotFoundException("No file found at path [$path]");

        $question_list = array();

        foreach ($posts->xpath("//posts//row") as $row) {
          $type_id = (string)$row['PostTypeId'];

          if ($type_id != 1) continue;


          $question = new Question();
          $id = (integer)$row['Id'];
          $question->setId($id);
          $created_at = new \DateTime((string)$row['CreationDate']);

          echo "Saving question with id $id,", $created_at->format('u'), "\n";

          $user_id = (integer)$row['OwnerUserId'];
          $last_editor_id = (integer)$row['LastEditorId'];
          if ($last_editor_id > 0 && isset($user_list[$last_editor_id])) {
            $question->setUserId($last_editor_id);
            $question->setUserDisplayName($user_list[$last_editor_id]);
          }
          elseif ($user_id > 0 && isset($user_list[$user_id])) {
            $question->setUserId($user_id);
            $question->setUserDisplayName($user_list[$user_id]);
          }

          $question->setTitle((string)$row['Title']);
          $question->setBody((string)$row['Body']);
          $question->setAcceptedAnswerId((integer)$row['AcceptedAnswerId']);
          $question->setAnswerCount((integer)$row['AnswerCount']);
          $question->setCreated($created_at);
          $manager->persist($question);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}
