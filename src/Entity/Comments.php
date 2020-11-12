<?php

namespace App\Entity;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Posts;
use App\Entity\Users;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentsRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\CommentCreateController;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 * @ApiResource(
 *      attributes={ 
 *          "order"={"publishedAt":"DESC"}
 *      },
 *      paginationItemsPerPage=2,
 *      normalizationContext={"groups"={"read:comments"}},
 *      collectionOperations={
 *          "get",
 *          "post"={
 *              "security"="is_granted('IS_AUTHENTICATED_FULLY')",
 *              "controller"=App\Controller\Api\CommentCreateController::class,
 *              "denormalization_context"={"groups"={"create:comments"}}
 *              }
 *         },
 *      itemOperations={
 *         "get"={
 *              "normalization_context"={"groups"={"read:comments", "read:full:comments"}}
 *          },
 *         "put"={
 *              "security"="is_granted('EDIT_COMMENT', object)",
 *              "denormalization_context"={"groups"={"update:comments"}}
 *          },
 *         "delete"={
 *              "security"="is_granted('EDIT_COMMENT', object)",
 *          }
 * 
 * 
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"posts": "exact"})
 */
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @groups({"read:comments"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @groups({"read:comments", "create:comments"})

     */
    private $content;


    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @groups({"read:comments", "create:comments", "update:comments"})
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Posts::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @groups({"read:full:comments", "create:comments"})
     */
    private $posts;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     * @groups({"read:comments"})

     */    
    private $publishedAt;

    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getPosts(): ?Posts
    {
        return $this->posts;
    }

    public function setPosts(?Posts $posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
