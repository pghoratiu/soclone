<?php
namespace Prolix\SocloneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Prolix\SocloneBundle\Repository\QuestionRepository")
 * @ORM\Table(name="question", indexes={
 *   @ORM\index(name="answer_count", columns={"answer_count"}),
 *   @ORM\index(name="created", columns={"created"}),
 *   @ORM\index(name="updated", columns={"updated"})});
 * @ORM\HasLifecycleCallbacks()
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $user_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $user_display_name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $answer_count;

    /**
     * @ORM\Column(type="integer")
     * @ORM\OneToOne(targetEntity="Answer")
     * @ORM\JoinColumn(name="accepted_answer_id", referencedColumnName="id")
     */
    protected $accepted_answer_id;

    /*
     * @ORM\OneToMany (targetEntity="Answer", mappedBy="question")
     */
    protected $answers;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public function __construct()
    {
        $this->answers = new ArrayCollection();

        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
    {
       $this->setUpdated(new \DateTime());
    }

    /**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set user_display_name
     *
     * @param string $userDisplayName
     */
    public function setUserDisplayName($userDisplayName)
    {
        $this->user_display_name = $userDisplayName;
    }

    /**
     * Get user_display_name
     *
     * @return string
     */
    public function getUserDisplayName()
    {
        return $this->user_display_name;
    }

    /**
     * Set answer_count
     *
     * @param integer $answerCount
     */
    public function setAnswerCount($answerCount)
    {
        $this->answer_count = $answerCount;
    }

    /**
     * Get answer_count
     *
     * @return integer
     */
    public function getAnswerCount()
    {
        return $this->answer_count;
    }

    /**
     * Set accepted_answer_id
     *
     * @param integer $acceptedAnswerId
     */
    public function setAcceptedAnswerId($acceptedAnswerId)
    {
        $this->accepted_answer_id = $acceptedAnswerId;
    }

    /**
     * Get accepted_answer_id
     *
     * @return integer
     */
    public function getAcceptedAnswerId()
    {
        return $this->accepted_answer_id;
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
