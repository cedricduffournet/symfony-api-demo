<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\ProductServiceInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller used to managed Product resource.
 *
 * @author Cedric DUFFOURNET <contact@cedricduffournet.com>
 */
class ProductController extends AbstractFOSRestController
{
    /**
     * @var ProductServiceInterface
     */
    private $productService;

    /**
     * ProductController constructor.
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Creates a new Product.
     *
     * @Rest\Post("/products")
     * @Operation(
     *     tags={"Product"},
     *     @SWG\Parameter(
     *         name="Request body",
     *         in="body",
     *         description="Product that need to be added",
     *         required=true,
     *         @Model(type=App\Form\ProductType::class)
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when created",
     *         @Model(type=App\Entity\Product::class)
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_CREATE')")
     */
    public function postProduct(Request $request): View
    {
        $product = $this->productService->createProduct();
        $form = $this->createForm(ProductType::class, $product);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->productService->updateProduct($product);

            return $this->view($product, Response::HTTP_CREATED);
        }

        return $this->view($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Retrieves a collection of Company.
     *
     * @Rest\Get("/products")
     *
     * @Operation(
     *      tags={"Product"},
     *      summary="Get the list of Products.",
     *      @SWG\Response(
     *          response="200",
     *          description="Returned when successful",
     *          @Model(type=App\Model\ProductsPaginated::class)
     *      )
     * )
     *
     * @Rest\QueryParam(name="page", requirements="\d+", nullable=false, default="1", description="Offset from which to start listing products.")
     * @Rest\QueryParam(name="itemsPerPage", requirements="\d+", default="5", description="How many products to return.")
     * @Security("is_granted('ROLE_PRODUCT_VIEW')")
     */
    public function getProducts(ParamFetcherInterface $paramFetcher): View
    {
        $filters = $this->getFilters($paramFetcher);

        $products = $this->productService->searchProduct($filters);

        return $this->view($products, Response::HTTP_OK);
    }

    /**
     * Retrives a Product.
     *
     * @Rest\Get("/products/{productId}", requirements={"productId"="\d+"})
     * @ParamConverter("product", options={"id" = "productId"})
     * @Operation(
     *     tags={"Product"},
     *     summary="Get a single Product.",
     *     @SWG\Parameter(
     *         name="productId",
     *         in="path",
     *         description="Product id",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *         @Model(type=App\Entity\Product::class)
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the Product is not found"
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_VIEW')")
     */
    public function getProduct(Product $product): View
    {
        return $this->view($product, Response::HTTP_OK);
    }

    /**
     * Update an existing Product.
     *
     * @Rest\Put("/products/{productId}", requirements={"productId"="\d+"})
     * @ParamConverter("product", options={"id" = "productId"})
     * @Operation(
     *     tags={"Product"},
     *     @SWG\Parameter(
     *         name="productId",
     *         in="path",
     *         description="Product id",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="Request body",
     *         in="body",
     *         required=true,
     *         @Model(type=App\Form\ProductType::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when updated",
     *         @Model(type=App\Entity\Product::class)
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_EDIT')")
     */
    public function putProduct(Request $request, Product $product): View
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->submit($request->request->all());
        if ($form->isValid()) {
            $this->productService->updateProduct($product);

            return $this->view($product, Response::HTTP_OK);
        }
        $view = $this->view($form, Response::HTTP_BAD_REQUEST);

        return $view;
    }

    /**
     * Deletes a Product.
     *
     * @Rest\Delete("/products/{productId}", requirements={"productId"="\d+"})
     * @ParamConverter("product", options={"id" = "productId"})
     * @Security("is_granted('ROLE_PRODUCT_DELETE')")
     * @Operation(
     *     tags={"Product"},
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the Product is not found"
     *     )
     * )
     */
    public function deleteProduct(Request $request, Product $product): View
    {
        try {
            $this->productService->deleteProduct($product);
        } catch (ForeignKeyConstraintViolationException $e) {
            return $this->view(['message' => 'You can not delete this entity !'], Response::HTTP_BAD_REQUEST);
        }

        return $this->view([], Response::HTTP_NO_CONTENT);
    }

    private function getFilters(ParamFetcherInterface $paramFetcher)
    {
        return $paramFetcher->all();
    }
}
