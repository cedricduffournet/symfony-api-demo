<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Form\ProductCategoryType;
use App\ProductCategory\ProductCategoryRequest;
use App\ProductCategory\ProductCategoryRequestHandler;
use App\ProductCategory\ProductCategoryServiceInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
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
 * Controller used to managed ProductCategory resource.
 *
 * @author Cedric DUFFOURNET <contact@cedricduffournet.com>
 */
class ProductCategoryController extends AbstractFOSRestController
{
    private $productCategoryService;

    private $productCategoryRequestHandler;

    /**
     * ProductCategoryController constructor.
     */
    public function __construct(
        ProductCategoryServiceInterface $productCategoryService,
        ProductCategoryRequestHandler $productCategoryRequestHandler
    ) {
        $this->productCategoryService = $productCategoryService;
        $this->productCategoryRequestHandler = $productCategoryRequestHandler;
    }

    /**
     * Creates a new ProductCategory.
     *
     * @Rest\Post("/productcategories")
     * @Operation(
     *     tags={"ProductCategory"},
     *     @SWG\Parameter(
     *         name="Request body",
     *         in="body",
     *         description="ProductCategory that need to be added",
     *         required=true,
     *         @Model(type=App\Form\ProductCategoryType::class)
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when created",
     *         @Model(type=App\Entity\ProductCategory::class)
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_CATEGORY_CREATE')")
     */
    public function postProductCategory(Request $request): View
    {
        $productCategoryRequest = new ProductCategoryRequest();
        $form = $this->createForm(ProductCategoryType::class, $productCategoryRequest);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $productCategory = $this->productCategoryRequestHandler->addProductCategory($productCategoryRequest);

            return $this->view($productCategory, Response::HTTP_CREATED);
        }

        return $this->view($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Retrieves a collection of ProductCategory.
     *
     * @Rest\Get("/productcategories")
     *
     * @Operation(
     *      tags={"ProductCategory"},
     *      summary="Get the list of ProductCategory.",
     *      @SWG\Response(
     *          response="200",
     *          description="Returned when successful",
     *          @SWG\Schema(
     *              type="array",
     *              @SWG\Items(ref=@Model(type=App\Entity\ProductCategory::class))
     *          )
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_CATEGORY_VIEW')")
     */
    public function getProductCategories(): View
    {
        $productcategories = $this->productCategoryService->getAllProductCategories();

        return $this->view($productcategories, Response::HTTP_OK);
    }

    /**
     * Retrives a ProductCategory.
     *
     * @Rest\Get("productcategories/{productCategoryId}", requirements={"productCategoryId"="\d+"})
     * @ParamConverter("productCategory", options={"id" = "productCategoryId"})
     * @Operation(
     *     tags={"ProductCategory"},
     *     summary="Get a single ProductCategory.",
     *     @SWG\Parameter(
     *         name="productCategoryId",
     *         in="path",
     *         description="ProductCategory id",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful",
     *         @Model(type=App\Entity\ProductCategory::class)
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the ProductCategory is not found"
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_CATEGORY_VIEW')")
     */
    public function getProductCategory(ProductCategory $productCategory): View
    {
        return $this->view($productCategory, Response::HTTP_OK);
    }

    /**
     * Update an existing ProductCategory.
     *
     * @Rest\Put("/productcategories/{productCategoryId}", requirements={"productCategoryId"="\d+"})
     * @ParamConverter("productCategory", options={"id" = "productCategoryId"})
     * @Operation(
     *     tags={"ProductCategory"},
     *     @SWG\Parameter(
     *         name="productCategoryId",
     *         in="path",
     *         description="ProductCategory id",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="Request body",
     *         in="body",
     *         required=true,
     *         @Model(type=App\Form\ProductCategoryType::class)
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when updated",
     *         @Model(type=App\Entity\ProductCategory::class)
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_CATEGORY_EDIT')")
     */
    public function putProductCategory(Request $request, ProductCategory $productCategory): View
    {
        $productCategoryRequest = ProductCategoryRequest::createFromProductCategory($productCategory);
        $form = $this->createForm(ProductCategoryType::class, $productCategoryRequest);

        $form->submit($request->request->all());
        if ($form->isValid()) {
            $this->productCategoryRequestHandler->updateProductCategory($productCategoryRequest, $productCategory);

            return $this->view($productCategory, Response::HTTP_OK);
        }
        $view = $this->view($form, Response::HTTP_BAD_REQUEST);

        return $view;
    }

    /**
     * Deletes a ProductCategory.
     *
     * @Rest\Delete("/productcategories/{productCategoryId}", requirements={"productCategoryId"="\d+"})
     * @ParamConverter("productCategory", options={"id" = "productCategoryId"})
     * @Security("is_granted('ROLE_PRODUCT_CATEGORY_DELETE')")
     * @Operation(
     *     tags={"ProductCategory"},
     *     @SWG\Response(
     *         response="204",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when the ProductCategory is not found"
     *     )
     * )
     */
    public function deleteProductCategory(Request $request, ProductCategory $productCategory): View
    {
        try {
            $this->productCategoryService->deleteProductCategory($productCategory);
        } catch (ForeignKeyConstraintViolationException $e) {
            return $this->view(['message' => 'You can not delete this entity !'], Response::HTTP_BAD_REQUEST);
        }

        return $this->view([], Response::HTTP_NO_CONTENT);
    }
}
