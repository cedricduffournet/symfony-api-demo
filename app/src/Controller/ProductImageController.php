<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Form\MediaType;
use App\Product\ProductImageRequestHandler;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller used to managed ProductImage resource.
 *
 * @author Cedric DUFFOURNET <contact@cedricduffournet.com>
 */
class ProductImageController extends AbstractFOSRestController
{
    private $productImageRequestHandler;

    /**
     * ProductImageController constructor.
     */
    public function __construct(ProductImageRequestHandler $productImageRequestHandler)
    {
        $this->productImageRequestHandler = $productImageRequestHandler;
    }

    /**
     * Add new image to product.
     *
     * @Rest\Post("/api/products/{productId}/images",requirements={"productId"="\d+"})
     * @ParamConverter("product", options={"id" = "productId"})
     * @Operation(
     *     consumes={"multipart/form-data"},
     *     tags={"ProductImage"},
     *     @SWG\Parameter(
     *         name="file",
     *         in="formData",
     *         description="File",
     *         required=true,
     *         type="file"
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when created",
     *         @Model(type=App\Entity\Media::class)
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when the form has errors"
     *     )
     * )
     *
     * @Security("is_granted('ROLE_PRODUCT_EDIT')")
     */
    public function postProductImage(Request $request, Product $product): View
    {
        $form = $this->createForm(MediaType::class);

        $form->submit($request->files->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $media = $this->productImageRequestHandler->add($product, $form['file']->getData());

            return $this->view($media, Response::HTTP_CREATED);
        }

        return $this->view($form, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Retrieves a product image.
     *
     * @Rest\Get("/public/products/images/{imageId}")
     * @ParamConverter("media", options={"id" = "imageId"})
     * @Operation(
     *      tags={"Public"},
     *      summary="Return product image.",
     *      @SWG\Response(
     *          response="200",
     *          description="Returned when successful"
     *     )
     * )
     *
     * @Rest\QueryParam(name="size", requirements="(thumbnail_name|main_image)", nullable=false, default="thumbnail_name", description="Image size.")
     */
    public function showProductImage(
        ParamFetcherInterface $paramFetcher,
        DataManager $dataManager,
        FilterManager $filterManager,
        Request $request,
        Media $media
    ): Response {
        if (null === $media) {
            throw $this->createNotFoundException('Unable to find Media entity.');
        }
        $params = $paramFetcher->all();
        $size = $params['size'];

        $image = $dataManager->find($size, $media->getName());
        $response = $filterManager->applyFilter($image, $size);
        $response = new Response($response->getContent());
        $response->headers->set('Content-Type', 'image/jpeg');

        return $response;
    }
}
