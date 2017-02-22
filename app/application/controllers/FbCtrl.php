<?php

/**
 * Created by PhpStorm.
 * User: vinit
 * Date: 1/4/2017
 * Time: 9:28 PM
 */
require_once APPPATH . 'libraries/Facebook/autoload.php';
require_once APPPATH . 'libraries/fbconfig.inc.php';

use FacebookAds\Object\CustomAudience;
use FacebookAds\Object\Fields\CustomAudienceFields;
use FacebookAds\Object\CustomAudienceMultiKey;
use FacebookAds\Object\Values\CustomAudienceTypes;
use FacebookAds\Object\Fields\CustomAudienceMultikeySchemaFields;
use FacebookAds\Object\Values\CustomAudienceSubtypes;
use FacebookAds\Api;

class FbCtrl extends CI_Controller
{

    protected $token;
    protected $audience_id;
    private $fb;

    function __construct()
    {
        parent::__construct();
        $this->fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_APP_ID, // Replace {app-id} with your app id
            'app_secret' => FACEBOOK_SECRET,
            'default_graph_version' => FACEBOOK_VERSION,
        ]);

        $this->load->model('user_model', 'user');
        $this->load->model('customer_model', 'customer');
    }

    public function index()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = ['email', 'ads_management', 'ads_read', 'manage_pages', 'read_insights', 'rsvp_event']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('https://azonsoftware.com/app/app/fbCtrl/fbcallback', $permissions);
        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

    }

    public function getFacebookAuthUrl()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = ['email', 'ads_management', 'ads_read', 'manage_pages', 'read_insights', 'rsvp_event']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(base_url('/fbCtrl/fbcallback'), $permissions);
        return $loginUrl;
    }

    public function fbcallback()
    {
        $helper = $this->fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            $this->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());
            redirect('dashboard');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            $this->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());
            redirect('dashboard');
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                $this->session->set_flashdata('error', $helper->getErrorDescription());
            } else {
                    $this->session->set_flashdata('error', 'Bad request');
            }
            redirect('dashboard');
        }

        // Logged in

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $this->fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(FACEBOOK_APP_ID); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        $tokenMetadata->validateExpiration();

        /* Get expiry date of token*/
        $date = $tokenMetadata->getExpiresAt();
        $expiry_date = $date->format('Y-m-d');

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                $this->session->set_flashdata('error', 'Something went wrong.');
            }
        }

        /* store facebook token to database with expire date */
        $this->token = (string)$accessToken->getValue();

        $arrUserData = $this->session->userdata('logged_in');
        $userDetails = $this->user->getUser(array('id' => $arrUserData['id']));
        $strAudienceId = null;

        if ($userDetails) {
            $strAudienceId = $userDetails['audience_id'];
            if (strlen($userDetails['audience_id']) == 0 || $userDetails['audience_id'] == '' || true == is_null($userDetails['audience_id'])) {
                $account_id = 'act_1557015334621079';
                Api::init(FACEBOOK_APP_ID, FACEBOOK_SECRET, $this->token);
                $audience = new CustomAudience(null, $account_id);
                $audience->setData(array(
                    CustomAudienceFields::NAME => 'MWS Audiece',
                    CustomAudienceFields::DESCRIPTION => 'Having MWS Audiece ',
                    CustomAudienceFields::SUBTYPE => CustomAudienceSubtypes::CUSTOM,
                ));
                // Create the audience
                $audience->create();
                $strAudienceId = $audience->id;
            }
            $this->user->updateUser(array('access_token' => $accessToken->getValue(), 'expiry_date' => $expiry_date, 'audience_id' => $strAudienceId), array('id' => $arrUserData['id']));
        }
        $this->session->set_flashdata('success', 'Access token stored successfully.');
        redirect('dashboard');
    }

    public function customAudience($intUserId)
    {
        Api::init(FACEBOOK_APP_ID, FACEBOOK_SECRET, $this->token);
        $api = Api::instance();

        $users = $this->customer->getCustomerByUserId($intUserId);

        $schema = array(
            CustomAudienceMultikeySchemaFields::FIRST_NAME,
            CustomAudienceMultikeySchemaFields::LAST_NAME,
            CustomAudienceMultikeySchemaFields::EMAIL,
            CustomAudienceMultikeySchemaFields::COUNTRY,
            CustomAudienceMultikeySchemaFields::CITY,
            CustomAudienceMultikeySchemaFields::ZIP,
            CustomAudienceMultikeySchemaFields::STATE
        );
        if ($users) {
            $audience = new CustomAudienceMultiKey($this->audience_id, null, $api);
            print_r($audience->addUsers($users, $schema));
            $this->customer->updateCustomerByUserId($intUserId, array('audience_id' => $this->audience_id));
        }
    }
}