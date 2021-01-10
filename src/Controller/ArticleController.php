<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\Validator\ConstraintViolationList;
use JMS\Serializer\Annotation\Groups;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

use App\Entity\Article;

class ArticleController extends MyAbstractController
{
    /**
     * @Get(path="/articles/{id}",
     *      name="article_show",
     *      requirements={"id"="\d+"})
     * @Groups({"details"})
     * @View(statusCode="200")
     * @OA\Response(
     *     response=200,
     *     description="Show an article.",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Article::class))
     *     )
     * )
     * @OA\Tag(name="article")
     */
    public function showAction(Article $article)
    {
        return $article;
    }

    /**
     * @Post(path="/articles",
     *       name="article_create")
     * @View(statusCode="201")
     * @ParamConverter("article",
     *                  converter="fos_rest.request_body",
     *                  options=
     *                          {"validator"=
     *                                      {"groups"="Create"}
     *                          }
     * )
     * @OA\Response(
     *     response=201,
     *     description="Creates the article and returns it.",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Article::class))
     *     )
     * )
     * @OA\Tag(name="article")
     */
    public function createAction(Article $article, ConstraintViolationList $violations)
    {
        return $this->create($article, $violations);
    }

    /**
     * @Get(path="/articles",
     *      name="article_list")
     * @View(statusCode="200")
     * @Groups({"list"})
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
     *     default="10",
     *     description="Max number of movies per page."
     * )
     * @QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     * @OA\Response(
     *     response=200,
     *     description="List articles with links to other pages.",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Article::class))
     *     )
     * )
     * @OA\Tag(name="article")
     */
    public function listAction($limit, $page, $order, $keyword)
    {
        // $groups = $this->container->get('request_stack')
        //                         ->getCurrentRequest()->attributes->get('_template')->getSerializerGroups();
        // $groups[] = 'list';
        // $this->container->get('request_stack')
        //                         ->getCurrentRequest()->attributes->get('_template')->setSerializerGroups($groups);

        return $this->list(Article::class, ['title' => ['strict' => false, 'string' => $keyword]], $limit, $page, $order);
    }


    /**
     * @Put(path="/articles/{id}",
     *       name="article_update",
     *       requirements={"id"="\d+"})
     * @View(statusCode="200")
     * @ParamConverter("article",
     *                  converter="fos_rest.request_body",
     *                  options=
     *                          {"validator"=
     *                                      {"groups"="Update"}
     *                          }
     * )
     * @OA\Response(
     *     response=200,
     *     description="Update an article. The full object is needed",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Article::class))
     *     )
     * )
     * @OA\Tag(name="article")
     */
    public function updateAction(Article $article, ConstraintViolationList $violations, int $id)
    {
        return $this->update($article, $id, $violations);
    }

    /**
     * @Delete(path="/articles/{id}",
     *      name="article_delete",
     *      requirements={"id"="\d+"})
     * @View(statusCode="204")
     * @OA\Response(
     *     response=204,
     *     description="Deletes aticle and send empty response.",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Article::class))
     *     )
     * )
     * @OA\Tag(name="article")
     */
    public function deleteAction($id)
    {
        return $this->delete(Article::class, $id);
    }
}
