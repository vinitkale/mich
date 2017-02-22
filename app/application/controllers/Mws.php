<?php

/**
 * Created by PhpStorm.
 * User: vinit
 * Date: 12/22/2016
 * Time: 11:27 PM
 */
ob_start();
set_time_limit(0);
require_once(APPPATH . 'controllers/FbCtrl.php');

class Mws extends FbCtrl
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
        echo "Init" . "<br>";
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
                if (1 == $val['initial_sync'])
                    $this->user->updateUser(array('initial_sync' => 0), array('id' => $val['user_id']));
            }
        }

        $this->updateCustomer();

        $arrFacebookDetails = $this->user->getFacebookData();
        if ($arrFacebookDetails) {
            foreach ($arrFacebookDetails as $key => $val) {
                $this->token = $val['access_token'];
                $this->audience_id = $val['audience_id'];
                $this->customAudience($val['id']);
            }
        }

    }

    public function invokeListOrders($request, $intUserId, $boolIntialSync = true, $strCreatedBefore = NULL)
    {
        echo "invokeListOrders--" . $intUserId . '$boolIntialSync--' . $boolIntialSync . '$strCreatedBefore--' . $strCreatedBefore . "<br>";

        set_time_limit(0);
        $strCreatedBefore = (NULL == $strCreatedBefore) ? date('Y-m-d') : $strCreatedBefore;

        if (true == $boolIntialSync) {
            $request->setCreatedAfter(date("Y-m-d", strtotime('-1 year', strtotime($strCreatedBefore))));
        } else {
            $request->setCreatedAfter(date("Y-m-d", strtotime('-1 day', strtotime($strCreatedBefore))));
        }

        $request->setCreatedBefore($strCreatedBefore);

        try {
            $response = $this->objService->ListOrders($request);
            echo "ListOrders" . "<br>";
            if ($response->isSetListOrdersResult()) {
                echo "Result Found" . "<br>";
                $listOrdersResult = $response->getListOrdersResult();

                if ($listOrdersResult->isSetOrders()) {
                    $orders = $listOrdersResult->getOrders();
                    foreach ($orders as $order) {
                        $this->insertOrder($order, $intUserId);
                    }
                    if ($listOrdersResult->isSetNextToken()) {
                        echo "NextTokenCall" . "<br>";
                        $boolSuccess = $this->getNextResult(NULL, $listOrdersResult->getNextToken(), $intUserId);
                        if (true == $boolSuccess && true == $boolIntialSync) {
                            echo "NextToken Call Done" . "<br>";
                            return $this->invokeListOrders($request, $intUserId, $boolIntialSync, date("Y-m-d", strtotime('-1 year', strtotime($strCreatedBefore))));
                        } elseif (true == $boolSuccess && false == $boolIntialSync)
                            return true;
                    } else {
                        echo "No Next List" . "<br>";
                        return true;
                    }
                }
            } else {
                echo "No results" . "<br>";
                return true;
            }
//            if ($response->isSetResponseMetadata()) {
//                $responseMetadata = $response->getResponseMetadata();
//                if ($responseMetadata->isSetRequestId()) {
//                    echo(" " . $responseMetadata->getRequestId() . "\n");
//                }
//            }
        } catch (MarketplaceWebServiceOrders_Exception $ex) {
            echo "ErrorCode in main" . $ex->getErrorCode() . "<br>";
            if (503 == $ex->getCode() || 0 == $ex->getCode()) {
                echo "wait in main call for 6 min.." . "<br>";
                sleep(360);
                return $this->invokeListOrders($request, $intUserId, $boolIntialSync, $strCreatedBefore);
            }
        }
    }

    public function getNextResult($nextRequest = NULL, $strNextToken = NULL, $intUserId)
    {
        echo "NextResult" . $strNextToken . '-------' . $intUserId . "<br>";
        set_time_limit(0);
        try {
//            if (NULL == $nextRequest) {
            $nextRequest = new MarketplaceWebServiceOrders_Model_ListOrdersByNextTokenRequest();
            $nextRequest->setSellerId($this->sellerId);
            $nextRequest->setMWSAuthToken($this->awsAuthToken);
//            }

            $nextRequest->setNextToken($strNextToken);

            $response = $this->objService->ListOrdersByNextToken($nextRequest);
            $listOrdersResult = $response->getListOrdersByNextTokenResult();

            if ($listOrdersResult->isSetOrders()) {
                $orders = $listOrdersResult->getOrders();
                foreach ($orders as $order) {
                    $this->insertOrder($order, $intUserId);
                }
                if ($listOrdersResult->isSetNextToken()) {
                    echo "recursive call to next reuslt" . "<br>";
                    return $this->getNextResult($nextRequest, $listOrdersResult->getNextToken(), $intUserId);
                } else {
                    echo "recursive call end" . "<br>";
                    return true;
                }
            } else {
                echo "end next data" . "<br>";
                return true;
            }
        } catch (Exception $ex) {
            echo "Error Code " . $ex->getCode();
            if (503 == $ex->getCode() || 0 == $ex->getCode()) {
                echo "Sleep 6 min...";
                sleep(360);
                return $this->getNextResult($nextRequest, $strNextToken, $intUserId);
            }
        }
    }

    function insertOrder($order, $intUserId)
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
                $arrMwsData['address_line3'] = $shippingAddress->getAddressLine3();
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
            require_once(__DIR__ . '/../libraries/FullNameParser.php');
            $parser = new FullNameParser();
            $arrName = $parser->parse_name($order->getBuyerName());
            $arrMwsData['buyer_first_name'] = $arrName['fname'];
            $arrMwsData['buyer_last_name'] = $arrName['lname'];
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
        if ($this->db->where(array('user_id' => $intUserId, 'amazon_order_id' => $arrMwsData['amazon_order_id']))->get('mws_orders')->num_rows() > 0) {
            $this->db->where(array('user_id' => $intUserId, 'amazon_order_id' => $arrMwsData['amazon_order_id']))->update('mws_orders', $arrMwsData);
        } else {
            $this->db->insert('mws_orders', $arrMwsData);
        }
    }

    public function updateCustomer()
    {

        $strSql = 'INSERT INTO customers ( user_id,
                                            buyer_email,
                                            buyer_first_name,
                                            buyer_last_name,
                                            address_line1,
                                            address_line2,
                                            address_line3,
                                            city,
                                            county,
                                            district,
                                            state_or_region,
                                            postal_code,
                                            country_code,
                                            phone)
                            SELECT  st.user_id,
                                    st.buyer_email,
                                    st.buyer_first_name,
                                    st.buyer_last_name,
                                    st.address_line1,
                                    st.address_line2,
                                    st.address_line3,
                                    st.city,
                                    st.county,
                                    st.district,
                                    st.state_or_region,
                                    st.postal_code,
                                    st.country_code,
                                    st.phone 
                            FROM (
                                SELECT
                                    distinct buyer_email,
                                    user_id,
                                    buyer_first_name,
                                    buyer_last_name,
                                    address_line1,
                                    address_line2,
                                    address_line3,
                                    city,
                                    county,
                                    district,
                                    state_or_region,
                                    postal_code,
                                    country_code,
                                    phone 
                                 FROM mws_orders 
                            ) st
                            WHERE NOT EXISTS (SELECT 1 
                                            FROM customers t2
                                            WHERE t2.buyer_email = st.buyer_email AND t2.user_id = st.user_id)';

        $this->db->simple_query($strSql);
    }


}
