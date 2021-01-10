<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\Until;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation\Relation;
use Hateoas\Configuration\Annotation\Embedded;
use Hateoas\Configuration\Annotation\Route;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * 
 * @Relation(
 *      "self",
 *      href = @Route(
 *          "article_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * @Relation(
 *      "update",
 *      href = @Route(
 *          "article_update",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * @Relation(
 *      "delete",
 *      href = @Route(
 *          "article_delete",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * @Relation(
 *      "author",
 *      href = @Route(
 *          "author_show",
 *          parameters = { "id" = "expr(object.getAuthor().getId())" },
 *          absolute = true
 *      )
 * )
 * @Relation(
 *      "author_fullname",
 *      embedded = @Embedded("expr(object.getAuthor().getFullname())")
 * )
 * @Relation(
 *     "weather",
 *     embedded = @Embedded("expr(service('app.weather').getCurrent())")
 * )
 * 
 * @Serializer\XmlRoot("article")
 */
class Article extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"list", "details"})
     * @Since("1.0")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(groups={"Create"})
     * @Assert\NotBlank(groups={"Update"}, allowNull=true)
     * @Groups({"list", "details"})
     * @Since("1.0")
     */
    private $title;

    /**
     * @ORM\Column(type="text")*
     * @Assert\NotBlank(groups={"Create"})
     * @Assert\NotBlank(groups={"Update"}, allowNull=true)
     * @Groups({"details"})
     * @Since("1.0")
     * @Until("2.0")
     */
    private $content;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"list"})
     * @Since("2.0")
     */
    private $shortDescription;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="articles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Since("1.0")
     * @Groups({"details"})
     */
    private $author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getOwnParams(): array
    {
        $params = array();
        foreach($this as $key => $value){
            if(!class_exists('App\Entity\\'.substr(ucfirst($key), 0, -1))){
                array_push($params, $key);
            }
        }

        return $params;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }
}
