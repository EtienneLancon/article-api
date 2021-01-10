<?php

namespace App\Entity;

use App\Repository\RootRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\XmlElement;
use JMS\Serializer\Annotation\Until;
use JMS\Serializer\Annotation\Since;
use JMS\Serializer\Annotation\Groups    ;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation\Relation;
use Hateoas\Configuration\Annotation\Embedded;
use Hateoas\Configuration\Annotation\Route;

/**
 * @ORM\Entity(repositoryClass=RootRepository::class)
 * 
 * @Relation(
 *      "articles",
 *      href = @Route(
 *          "article_list",
 *          absolute = true
 *      )
 * )
 * @Relation(
 *      "authors",
 *      href = @Route(
 *          "author_list",
 *          absolute = true
 *      )
 * )
 * 
 * @Serializer\ExclusionPolicy("ALL")
 * @Serializer\XmlRoot("root")
 */
class Root
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
