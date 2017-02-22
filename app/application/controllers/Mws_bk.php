<?php

/**
 * Created by PhpStorm.
 * User: vinit
 * Date: 12/22/2016
 * Time: 11:27 PM
 */
ob_start();
    set_time_limit(0);
class Mws extends CI_Controller
{

    public $objService;
    private $sellerId;
    private $marketplaceId;
    private $awsAuthToken;

    public function __construct()
    {
        parent::__construct();

        require_once APPPATH . 'libraries/.config.inc.php';
        $this->load->model('user_model', 'user');


        $this->config = array(
            'ServiceURL' => 'https://mws.amazonservices.com/Orders/2013-09-01',
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'ProxyUsername' => null,
            'ProxyPassword' => null,
            'MaxErrorRetry' => 3,
        );

        /*	 * **********************************************************************
         * Instantiate Implementation of MarketplaceWebService
         *
         * AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY constants
         * are defined in the .config.inc.php located in the same
         * directory as this sample
         * ********************************************************************* */
        $this->objService = new MarketplaceWebServiceOrders_Client(
            AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, APPLICATION_NAME, APPLICATION_VERSION, $this->config);
    }

    public function intialSync()
    {
    
        $request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
        // get MWS credential from Database...

        $arrMwsDetails = $this->user->getMwsData();
        if ($arrMwsDetails) {
            foreach ($arrMwsDetails as $key => $val) {
		$this->sellerId = $val['seller_id'];
		$this->marketplaceId = $val['marketplace_id'];
		$this->awsAuthToken = $val['aws_auth_token'];
                $request->setSellerId($this->sellerId);
                $request->setMarketplaceId($this->marketplaceId);
                $request->setMWSAuthToken($this->awsAuthToken);
                $this->invokeListOrders($request, $val['user_id'], $val['initial_sync']);
            }
        }
    }

    public function invokeListOrders($request, $intUserId, $boolIntialSync = true, $strCreatedBefore = NULL)
    {
        set_time_limit(0);
        $strCreatedBefore = (NULL == $strCreatedBefore) ? date('Y-m-d') : $strCreatedBefore;

        if (true == $boolIntialSync){
            $request->setCreatedAfter(date("Y-m-d", strtotime('-3 months', strtotime($strCreatedBefore))));
        } else {
            $request->setCreatedAfter(date("Y-m-d", strtotime('-1 day', strtotime($strCreatedBefore))));
        }

        $request->setCreatedBefore($strCreatedBefore);

        try {
        $response = $this->objService->ListOrders($request);

            if ($response->isSetListOrdersResult()) {
                $listOrdersResult = $response->getListOrdersResult();

                if ($listOrdersResult->isSetOrders()) {
                    $orders = $listOrdersResult->getOrders();
                    foreach ($orders as $order) {
                        $this->insertOrder($order,$intUserId);
                    }
                    if ($listOrdersResult->isSetNextToken()) {
                        $boolSuccess = $this->getNextResult(NULL, $listOrdersResult->getNextToken(),$intUserId);
                        if( true == $boolSuccess && true == $boolIntialSync )
                            $this->invokeListOrders($request, $intUserId, $boolIntialSync, date("Y-m-d", strtotime('-3 months', strtotime($strCreatedBefore))));
                        elseif ( true == $boolSuccess && false == $boolIntialSync )
                            return true;
                    } else {
                        return true;
                    }
                }
            } else {
                return true;
            }
            if ($response->isSetResponseMetadata()) {
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId()) {
                    echo(" " . $responseMetadata->getRequestId() . "\n");
                }
            }
        } catch (MarketplaceWebServiceOrders_Exception $ex) {
            if (503 == $ex->getErrorCode()) {
                sleep(360);
                return $this->invokeListOrders($request, $intUserId, $boolIntialSync, $strCreatedBefore);
            }
        }
    }

    public function getNextResult($nextRequest = NULL, $strNextToken = NULL,$intUserId)
    {
        set_time_limit(0);
        try {
            if (NULL == $nextRequest) {
                $nextRequest = new MarketplaceWebServiceOrders_Model_ListOrdersByNextTokenRequest();
                $nextRequest->setSellerId($this->sellerId);
                $nextRequest->setMWSAuthToken($this->awsAuthToken);
            }

            $nextRequest->setNextToken($strNextToken);

            $response = $this->objService->ListOrdersByNextToken($nextRequest);
            $listOrdersResult = $response->getListOrdersByNextTokenResult();

            if ($listOrdersResult->isSetOrders()) {
                $orders = $listOrdersResult->getOrders();
                foreach ($orders as $order) {
                    $this->insertOrder($order,$intUserId);
                }
                if ($listOrdersResult->isSetNextToken()) {
                    return $this->getNextResult($nextRequest, $listOrdersResult->getNextToken(),$intUserId);
                } else {
                    return true;
                }
            }else{
                return true;
            }
        } catch (Exception $ex) {

            if (503 == $ex->getCode()) {
                sleep(360);
                return $this->getNextResult($nextRequest, $strNextToken);
            }
        }
    }

    function insertOrder($order,$intUserId)
    {
        $arrMwsData = array();
        if ($order->isSetAmazonOrderId()) {
            $arrMwsData['amazon_order_id'] = $order->getAmazonOrderId();
        }
        if ($order->isSetSellerOrderId()) {
            $arrMwsData['seller_order_id'] = $order->getSellerOrderId();
        }
        if ($order->isSetPurchaseDate()) {
            $arrMwsData['purchase_date'] = $order->getPurchaseDate();
        }
        if ($order->isSetLastUpdateDate()) {
            $arrMwsData['last_update_date'] = $order->getLastUpdateDate();
        }
        if ($order->isSetOrderStatus()) {
            $arrMwsData['order_status'] = $order->getOrderStatus();
        }
        if ($order->isSetFulfillmentChannel()) {
            $arrMwsData['fulfillment_channel'] = $order->getFulfillmentChannel();
        }
        if ($order->isSetSalesChannel()) {
            $arrMwsData['sales_channel'] = $order->getSalesChannel();
        }
        if ($order->isSetOrderChannel()) {
            $arrMwsData['order_channel'] = $order->getOrderChannel();
        }
        if ($order->isSetShipServiceLevel()) {
            $arrMwsData['ship_service_level'] = $order->getShipServiceLevel();
        }
        if ($order->isSetShippingAddress()) {
            $shippingAddress = $order->getShippingAddress();
            if ($shippingAddress->isSetName()) {
                $arrMwsData['shipper_name'] = $shippingAddress->getName();
            }
            if ($shippingAddress->isSetAddressLine1()) {
                $arrMwsData['address_line1'] = $shippingAddress->getAddressLine1();
            }
            if ($shippingAddress->isSetAddressLine2()) {
                $arrMwsData['address_line2'] = $shippingAddress->getAddressLine2();
            }
            if ($shippingAddress->isSetAddressLine3()) {
                $arrMwsData['address_line2'] = $shippingAddress->getAddressLine3();
            }
            if ($shippingAddress->isSetCity()) {
                $arrMwsData['city'] = $shippingAddress->getCity();
            }
            if ($shippingAddress->isSetCounty()) {
                $arrMwsData['county'] = $shippingAddress->getCounty();
            }
            if ($shippingAddress->isSetDistrict()) {
                $arrMwsData['district'] = $shippingAddress->getDistrict();
            }
            if ($shippingAddress->isSetStateOrRegion()) {
                $arrMwsData['state_or_region'] = $shippingAddress->getStateOrRegion();
            }
            if ($shippingAddress->isSetPostalCode()) {
                $arrMwsData['postal_code'] = $shippingAddress->getPostalCode();
            }
            if ($shippingAddress->isSetCountryCode()) {
                $arrMwsData['country_code'] = $shippingAddress->getCountryCode();
            }
            if ($shippingAddress->isSetPhone()) {
                $arrMwsData['phone'] = $shippingAddress->getPhone();
            }
        }
        if ($order->isSetOrderTotal()) {
            $orderTotal = $order->getOrderTotal();
            if ($orderTotal->isSetCurrencyCode()) {
                $arrMwsData['currency_code'] = $orderTotal->getCurrencyCode();
            }
            if ($orderTotal->isSetAmount()) {
                $arrMwsData['order_total_amount'] = $orderTotal->getAmount();
            }
        }
        if ($order->isSetNumberOfItemsShipped()) {
            $arrMwsData['number_of_items_shipped'] = $order->getNumberOfItemsShipped();
        }
        if ($order->isSetNumberOfItemsUnshipped()) {
            $arrMwsData['number_of_items_unshipped'] = $order->getNumberOfItemsUnshipped();
        }
        if ($order->isSetPaymentMethod()) {
            $arrMwsData['payment_method'] = $order->getPaymentMethod();
        }
        if ($order->isSetMarketplaceId()) {
            $arrMwsData['market_place_id'] = $order->getMarketplaceId();
        }
        if ($order->isSetBuyerEmail()) {
            $arrMwsData['buyer_email'] = $order->getBuyerEmail();
        }
        if ($order->isSetBuyerName()) {
            $arrMwsData['buyer_name'] = $order->getBuyerName();
        }
        if ($order->isSetShipmentServiceLevelCategory()) {
            $arrMwsData['shipment_service_level_category'] = $order->getShipmentServiceLevelCategory();
        }
        if ($order->isSetOrderType()) {
            $arrMwsData['order_type'] = $order->getOrderType();
        }
        if ($order->isSetEarliestShipDate()) {
            $arrMwsData['earliest_ship_date'] = $order->getEarliestShipDate();
        }

        if ($order->isSetLatestShipDate()) {
            $arrMwsData['latest_ship_date'] = $order->getLatestShipDate();
        }
	
        if ($order->isSetEarliestDeliveryDate()) {
            $arrMwsData['earliest_delivery_date'] = $order->getEarliestDeliveryDate();
        }
        if ($order->isSetLatestDeliveryDate()) {
            $arrMwsData['latest_delivery_date'] = $order->getLatestDeliveryDate();
        }
        if ($order->isSetIsBusinessOrder()) {
            $arrMwsData['is_business_order'] = $order->getIsBusinessOrder();
        }
        if ($order->isSetPurchaseOrderNumber()) {
            $arrMwsData['purchase_order_number'] = $order->getPurchaseOrderNumber();
        }
        if ($order->isSetIsPrime()) {
            $arrMwsData['is_prime'] = $order->getIsPrime();
        }
        if ($order->isSetIsPremiumOrder()) {
            $arrMwsData['is_premium_order'] = $order->getIsPremiumOrder();
        }
	$arrMwsData['user_id'] = $intUserId;
        $this->db->insert('mws_orders', $arrMwsData);
    }

}
