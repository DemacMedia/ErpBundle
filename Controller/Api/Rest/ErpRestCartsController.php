<?php
namespace DemacMedia\Bundle\ErpBundle\Controller\Api\Rest;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
use Oro\Bundle\SoapBundle\Entity\Manager\ApiEntityManager;
use Oro\Bundle\SoapBundle\Form\Handler\ApiFormHandler;
use Oro\Bundle\CommentBundle\Entity\Manager\CommentApiManager;


use DemacMedia\Bundle\ErpBundle\Entity\OroErpCarts;
use DemacMedia\Bundle\ErpBundle\Entity\OroErpAccounts;

/**
 * @NamePrefix("demacmedia_api_")
 */
class ErpRestCartsController extends RestController implements ClassResourceInterface
{
    /**
     * REST GET list of Erp Carts
     *
    $response = $oroClient->get('api/rest/latest/erp/carts.json', [
        'query' => [
            'page'  => 1,
            'limit' => 5,
        ]
    ]);
     *
     * @QueryParam(
     *      name="page",
     *      requirements="\d+",
     *      nullable=true,
     *      description="Page number, starting from 1. Defaults to 1."
     * )
     * @QueryParam(
     *      name="limit",
     *      requirements="\d+", nullable=true,
     *      description="Number of items per page. defaults to 10."
     * )
     * @ApiDoc(
     *      resource=true,
     *      description="Get all Erp Carts",
     * )
     * @AclAncestor("demacmedia_erp_carts")
     * @return Response
     */
    public function cgetAction()
    {
        $page = (int) $this->getRequest()->get('page', 1);
        $limit = (int) $this->getRequest()->get('limit', self::ITEMS_PER_PAGE);

        return $this->handleGetListRequest($page, $limit);
    }


    /**
     * Get specific account data
     *
        // Get a specific account using a id. In this example id=1
        $physicalCartsResponse = $oroClient->get('api/rest/latest/erp/carts/1.json', []);
     * @param int $id Account id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @ApiDoc(
     * description="Get a specific Physical Store account info",
     * resource=true,
     * requirements={
     * {"name"="id", "dataType"="integer"},
     * }
     * )
     * @AclAncestor("demacmedia_erp_carts_view")
     */
    public function getAction($id)
    {
        return $this->handleGetRequest($id);
    }


    /**
     * Create new Erp Cart
     *
     *
        // Example creating a new Web Cart.
        $response = $oroClient->post('api/rest/latest/erp/carts.json', [
            'body' => [
                'cart_number'       => '1234',
                'original_email'    => 'example@example.org',
                'total_paid'        => '11.11',
                'website_id'        => 'httpwwwwebsitecom',
                'createdAt'         => 'YYYY-mm-dd HH:ii:ss',
                'updatedAt'         => 'YYYY-mm-dd HH:ii:ss',
                'bill_firstname'    => 'Example',
                'bill_lastname'     => 'Example',
                'bill_company'      => 'Acme',
                'bill_address1'     => '12 Example Street',
                'bill_address2'     => 'Unit 1',
                'bill_city'         => 'Toronto',
                'bill_state'        => 'ON',
                'bill_zip'          => 'A1A1A1',
                'bill_phone'        => '+1(111) 111-1111',
                'ship_firstname'    => 'Example',
                'ship_lastname'     => 'Example',
                'ship_company'      => 'Acme',
                'ship_address1'     => '11 Example Street',
                'ship_address2'     => 'Unit 11',
                'ship_city'         => 'Toronto',
                'ship_state'        => 'ON',
                'ship_zip'          => 'A1A1A1',
                'ship_phone'        => '+1(111) 111-1111',
                'completed_order_id'=> '123456',
                'cart_status'       => 'open',
                'owner'             => '1', // OroCRM User ID
            ]
        ]);
     *
     * @param string $originalEmail original_email
     *
     * @ApiDoc(
     * description="Create new Erp Web Store Account.",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_carts_create")
     *
     * @return Response
     */
    public function postAction()
    {
        $foo = 10;

        return $this->handleCreateRequest();
    }


    /**
     * Update Erp Web Store account
     *
        $request = $oroClient->put('api/rest/latest/erp/carts/6.json', [
            'body' => [
                'original_number'   => '1234',
                'original_email'    => 'example@example.org',
                'total_paid'        => '11.11',
                'website_id'        => 'httpwwwwebsitecom',
                'createdAt'         => 'YYYY-mm-dd HH:ii:ss',
                'updatedAt'         => 'YYYY-mm-dd HH:ii:ss',
                'bill_firstname'    => 'Example',
                'bill_lastname'     => 'Example',
                'bill_company'      => 'Acme',
                'bill_address1'     => '12 Example Street',
                'bill_address2'     => 'Unit 1',
                'bill_city'         => 'Toronto',
                'bill_state'        => 'ON',
                'bill_zip'          => 'A1A1A1',
                'bill_phone'        => '+1(111) 111-1111',
                'ship_firstname'    => 'Example',
                'ship_lastname'     => 'Example',
                'ship_company'      => 'Acme',
                'ship_address1'     => '11 Example Street',
                'ship_address2'     => 'Unit 11',
                'ship_city'         => 'Toronto',
                'ship_state'        => 'ON',
                'ship_zip'          => 'A1A1A1',
                'ship_phone'        => '+1(111) 111-1111',
                'completed_order_id'=> '123456',
                'cart_status'       => 'open',
                'owner'             => '1', // OroCRM User ID
            ]
        ]);
     *
     * @param int $id Comment item id
     *
     * @ApiDoc(
     * description="Update Physical Store account",
     * resource=true
     * )
     * @AclAncestor("demacmedia_erp_carts_update")
     *
     * @return Response
     */
    public function putAction($id)
    {
        return $this->handleUpdateRequest($id);
    }


    /**
     * Delete Physical Store account
     *
        // Example deleting Account with id: 1
        $response = $oroClient->delete('api/rest/latest/erp/carts/1.json');
     *
     * @param int $id comment id
     *
     * @ApiDoc(
     *      description="Delete Erp account",
     *      resource=true
     * )
     * @Acl(
     * id="demacmedia_erp_carts_delete",
     *      type="entity",
     *      permission="DELETE",
     *      class="DemacMediaErpBundle:OroErpCarts"
     * )
     * @return Response
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }



    /**
     * Get entity Manager
     *
     * @return ApiEntityManager
     */
    public function getManager()
    {
        return $this->get('demacmedia_erp_carts.manager.api');
    }


    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->get('demacmedia_erp_carts.form.carts.api');
    }


    /**
     * @return ApiFormHandler
     */
    public function getFormHandler()
    {
        return $this->get('demacmedia_erp_carts.form.handler.carts_api');
    }
}
