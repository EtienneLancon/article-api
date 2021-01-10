<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Since; //il existe aussi Until
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation\Relation;
use Hateoas\Configuration\Annotation\Route;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 * 
 * @Serializer\ExclusionPolicy("ALL")
 * 
 * @Relation(
 *      "self",
 *      href = @Route(
 *          "author_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * 
 * @Relation(
 *      "update",
 *      href = @Route(
 *          "author_update",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * 
 * @Relation(
 *      "articles",
 *      href = @Route(
 *          "author_articles",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 * 
 * @Serializer\XmlRoot("author")
 */
class Author extends Entity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Expose
     * @Since("1.0")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"Create"})
     * @Expose
     * @Since("1.0")
     */
    private $fullname;

    /**
     * @ORM\Column(type="text")
     * @Expose
     * @Since("1.0")
     */
    private $biography;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author")
     * @Since("1.0")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

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
}
