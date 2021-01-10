<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use JMS\Serializer\Annotation\Groups;


use FOS\RestBundle\Controller\Annotations\QueryParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationList;

use App\Entity\Author;
use App\OutputHandler\MetaAdder;

class AuthorController extends MyAbstractController
{
    /**
     * @Get(path="/authors/{id}",
     *      name="author_show",
     *      requirements={"id"="\d+"})
     * @View(statusCode="200")
     */
    public function showAction(Author $author)
    {
        return $author;
    }

        /**
     * @Get(path="/authors",
     *      name="author_list")
     * @Groups({"author"})
     * @View(statusCode="200")
     * @QueryParam(
     *     name="keyword",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="15",
     *     description="Max number of movies per page."
     * )
     * @QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The current page"
     * )
     */
    public function listAction($limit, $offset, $order, $keyword)
    {
        return $this->list(Author::class, ['fullname' => ['strict' => false, 'string' => $keyword]], $limit, $offset, $order);
    }

    /**
     * @Put(path="/authors/{id}",
     *       name="author_update",
     *       requirements={"id"="\d+"})
     * @View(statusCode="200")
     * @ParamConverter("author",
     *                  converter="fos_rest.request_body",
     *                  options=
     *                          {"validator"=
     *                                      {"groups"="Create"}
     *                          }
     * )
     */
    public function updateAction(Author $author, ConstraintViolationList $violations, $id)
    {
        return $this->update($author, $id, $violations);
    }

    /**
     * @Get(path="/authors/{id}/getArticles",
     *      name="author_articles",
     *      requirements={"id"="\d+"})
     * @View(statusCode="200")
     * @QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="15",
     *     description="Max number of movies per page."
     * )
     * @QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The current page"
     * )
     */
    public function getArticles($limit, $page, $order, int $id)
    {
        return $this->list('App\\Entity\\Article', ['author' => $id], $limit, $page, $order);
    }
}
