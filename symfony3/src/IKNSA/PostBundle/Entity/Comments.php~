<?php

namespace IKNSA\PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="IKNSA\PostBundle\Repository\CommentsRepository")
 */
class Comments
{   

    public function __construct()
    {
        $this->date = new \Datetime;
        $this->author = $this->getUser();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=255)
     */
    protected $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    // Blog\PostBundle\Entity
    /**
     * @ORM\ManyToOne(targetEntity="IKNSA\BlogBundle\Entity\User")
     */
    protected $user;

    // Blog\PostBundle\Entity
    /**
     * @ORM\ManyToOne(targetEntity="IKNSA\PostBundle\Entity\Post")
     */
    protected $post;

    /**
     * Set user
     *
     * @param \IKNSA\BlogBundle\Entity\User $user
     *
     * @return Post
     */
    public function setUser(\IKNSA\BlogBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \IKNSA\BlogBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comments
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Comments
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Comments
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set post
     *
     * @param \IKNSA\PostBundle\Entity\Post $post
     *
     * @return Comments
     */
    public function setPost(\IKNSA\PostBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \IKNSA\PostBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
