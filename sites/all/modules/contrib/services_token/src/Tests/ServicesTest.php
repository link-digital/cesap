<?php
/**
 * @file
 * Contains Drupal\services_token\Tests\ServicesTest.
 */

namespace Drupal\services_token\Tests;

/**
 * Tests integration with services.
 */
class ServicesTest extends \ServicesWebTestCase {

  protected $profile = 'testing';

  protected $realm;

  protected $endpoint;

  protected $plainUser;

  protected $privilegedUser;

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => 'Services',
      'description' => 'Tests integration with services',
      'group' => 'Services Token',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp(array('services_token', 'services_token_test'));

    $this->endpoint = $this->saveNewEndpoint();

    $this->realm = $this->randomString();

    // Add the token authentication and resource.
    $this->endpoint->resources['services_token'] = array(
      'actions' => array(
        'generate' => array(
          'enabled' => '1',
          'settings' => array(
            'services_token' => array(
              'password_fallback' => '1',
            ),
          ),
        ),
      ),
    );
    $this->endpoint->authentication['services_token'] = array(
      'realm' => $this->realm,
    );
    services_endpoint_save($this->endpoint);

    $this->plainUser = $this->drupalCreateUser();
    $this->privilegedUser = $this->drupalCreateUser(array('generate services token'));
  }

  protected function enableFastCgiFallbackParsing() {
    variable_set('services_token_test_sever_override', array(
      'PHP_AUTH_USER' => NULL,
      'PHP_AUTH_PW' => NULL,
    ));
  }

  protected function disableFastCgiFallbackParsing() {
    variable_del('services_token_test_sever_override');
  }

  /**
   * Tests generating tokens.
   */
  public function testTokenResource() {
    $this->drupalLogin($this->plainUser);
    $this->servicesPost($this->endpoint->path . '/services_token/generate', array());
    $this->assertResponse(403);

    $this->drupalLogin($this->privilegedUser);
    $response = $this->servicesPost($this->endpoint->path . '/services_token/generate', array());
    $this->assertResponse(200);

    $this->assertTrue(strtotime($response['body']->expires) > REQUEST_TIME, 'Generated token has an expiry time in the future');
    $valid = services_token_validate($response['body']->token, $this->realm);
    $this->assertIdentical($valid, TRUE, 'Generated token is valid');
  }

  /**
   * Tests token resource with default (unconfigured) realm.
   */
  public function testTokenResourceDefaultRealm() {
    // Delete services token authentication settings on this endpoint but leave
    // the token authentication active.
    $this->endpoint->authentication['services_token'] = 'services_token';
    services_endpoint_save($this->endpoint);

    $default_realm = services_token_realm_default();
    $endpoint_realm = services_token_endpoint_get_realm($this->endpoint);
    $this->assertEqual($default_realm, $endpoint_realm);

    $this->drupalLogin($this->privilegedUser);
    $response = $this->servicesPost($this->endpoint->path . '/services_token/generate', array());
    $this->assertResponse(200);

    $valid = services_token_validate($response['body']->token, $default_realm);
    $this->assertIdentical($valid, TRUE, 'Generated token with default realm is valid');
  }

  /**
   * Test token generation password fallback with native header parsing.
   */
  public function testPasswordFallbackNativeHeaderParsing() {
    $this->doTestPasswordFallback();
  }

  /**
   * Test token generation password fallback with FastCGI fallback.
   */
  public function testPasswordFallbackFastCgiFallbackParsing() {
    $this->enableFastCgiFallbackParsing();
    $this->doTestPasswordFallback();
    $this->disableFastCgiFallbackParsing();
  }

  /**
   * Test token authentication with native header parsing.
   */
  public function testTokenAuthenticationNativeHeaderParsing() {
    $this->doTestTokenAuthentication();
  }

  /**
   * Test token authentication with FastCGI fallback.
   */
  public function testTokenAuthenticationFastCgiFallbackParsing() {
    $this->enableFastCgiFallbackParsing();
    $this->doTestTokenAuthentication();
    $this->disableFastCgiFallbackParsing();
  }

  /**
   * Test invalid authentication with native header parsing.
   */
  public function testInvalidAuthorizationHeaderNativeHeaderParsing() {
    $this->doTestInvalidAuthorizationHeader();
  }

  /**
   * Test invalid authentication with FastCGI fallback.
   */
  public function testInvalidAuthorizationHeaderFastCgiFallbackParsing() {
    $this->enableFastCgiFallbackParsing();
    $this->doTestInvalidAuthorizationHeader();
    $this->disableFastCgiFallbackParsing();
  }

  /**
   * Test token generation password fallback.
   */
  protected function doTestPasswordFallback() {
    $headers = array(
      'Authorization: Basic ' . base64_encode($this->privilegedUser->name . ':' . $this->privilegedUser->pass_raw),
    );

    // Use username/password to authenticate and verify that accessing the token
    // generator succeeds.
    $response = $this->servicesPost($this->endpoint->path . '/services_token/generate', array(), $headers);
    $this->assertResponse(200);

    $this->assertTrue(strtotime($response['body']->expires) > REQUEST_TIME, 'Generated token has an expiry time in the future');
    $valid = services_token_validate($response['body']->token, $this->realm);
    $this->assertIdentical($valid, TRUE, 'Generated token is valid');

    // Use username/password to authenticate and verify that access to other
    // resources is denied.
    $response = $this->servicesGet($this->endpoint->path . '/user/' . $this->privilegedUser->uid, NULL, $headers);
    $this->assertResponse(401);
    $this->assertEqual($response['body'], 'Invalid credentials.');

    // Use username/password to authenticate and verify that accessing the token
    // generator fails if password fallback is disabled..
    $this->endpoint->resources['services_token']['actions']['generate']['settings']['services_token']['password_fallback'] = '0';
    services_endpoint_save($this->endpoint);

    $response = $this->servicesPost($this->endpoint->path . '/services_token/generate', array(), $headers);
    $this->assertResponse(401);
    $this->assertEqual($response['body'], 'Invalid credentials.');
  }

  /**
   * Test token authentication.
   */
  protected function doTestTokenAuthentication() {
    $uid = $this->plainUser->uid;

    // Try to get a protected resource without any authentication.
    $this->servicesGet($this->endpoint->path . '/user/' . $uid);
    $this->assertResponse(401);
    $challenge = $this->drupalGetHeader('WWW-Authenticate');
    $this->assertIdentical(substr($challenge, 0, 12), 'Basic realm=', 'Basic auth challenge header present');
    $this->assertIdentical(substr($challenge, 12), '"' . check_plain($this->realm) . '"', 'Basic auth realm present');

    // Try to get a protected resource with token auth.
    $token = services_token($this->realm, $uid, REQUEST_TIME + 3600);
    $headers = array(
      'Authorization: Basic ' . base64_encode($token . ':'),
    );
    $response = $this->servicesGet($this->endpoint->path . '/user/' . $uid, NULL, $headers);
    $this->assertResponse(200);
    $this->assertEqual($response['body']->uid, $uid, 'Fetched correct user object');

    // Change realm on specific resource and verify that basic auth challenge
    // is correct.
    $special_realm = $this->randomString(10);
    $this->endpoint->resources['user']['operations']['retrieve']['settings']['services_token']['realm'] = $special_realm;
    services_endpoint_save($this->endpoint);
    $this->servicesGet($this->endpoint->path . '/user/' . $uid);
    $this->assertResponse(401);
    $challenge = $this->drupalGetHeader('WWW-Authenticate');
    $this->assertIdentical(substr($challenge, 0, 12), 'Basic realm=', 'Basic auth challenge header present');
    $this->assertIdentical(substr($challenge, 12), '"' . check_plain($special_realm) . '"', 'Special basic auth realm present');

    // Disable realm on specific resource and verify that basic auth challenge
    // is not added to the response.
    $this->endpoint->resources['user']['operations']['retrieve']['settings']['services_token']['realm'] = FALSE;
    services_endpoint_save($this->endpoint);
    $this->servicesGet($this->endpoint->path . '/user/' . $uid);
    $this->assertResponse(403);
    $challenge = $this->drupalGetHeader('WWW-Authenticate');
    $this->assertFalse($challenge);

    unset($this->endpoint->resources['user']['operations']['retrieve']['settings']['services_token']);
    services_endpoint_save($this->endpoint);

    // Disable token authentication on whole endpoint and verify that the basic
    // auth challange is *not* added to the response.
    unset($this->endpoint->authentication['services_token']);
    services_endpoint_save($this->endpoint);

    // Try to get a protected resource without any authentication.
    $this->servicesGet($this->endpoint->path . '/user/' . $uid);
    $this->assertResponse(403);
    $challenge = $this->drupalGetHeader('WWW-Authenticate');
    $this->assertFalse($challenge);
  }

  /**
   * Test invalid authentication.
   */
  protected function doTestInvalidAuthorizationHeader() {
    $uid = $this->plainUser->uid;

    // Try to get a protected resource with token auth lacking the colon. In
    // this case it is expected that the Authorization header is ignored,
    // authentication not attempted (user remains anonymous) and thus the
    // response is a 401 for protected content and 200 for public.
    $token = services_token($this->realm, $uid, REQUEST_TIME + 3600);
    $headers = array(
      'Authorization: Basic ' . base64_encode($token),
    );
    $response = $this->servicesGet($this->endpoint->path . '/user/' . $uid, NULL, $headers);
    $this->assertResponse(401);
    $this->assertEqual($response['body'], 'Access denied for user anonymous');

    $response = $this->servicesGet($this->endpoint->path . '/node', NULL, $headers);
    $this->assertResponse(200);

    // Try to get a protected resource with an Authorization header with
    // misspelled authentication scheme (lowercase). In this case it is expected
    // that the Authorization header is ignored, authentication not attempted
    // (user remains anonymous) and thus the response is a 401 for protected
    // content and 200 public.
    $token = services_token($this->realm, $uid, REQUEST_TIME + 3600);
    $headers = array(
      'Authorization: basic ' . base64_encode($token . ':'),
    );
    $response = $this->servicesGet($this->endpoint->path . '/user/' . $uid, NULL, $headers);
    $this->assertResponse(401);
    $this->assertEqual($response['body'], 'Access denied for user anonymous');

    $response = $this->servicesGet($this->endpoint->path . '/node', NULL, $headers);
    $this->assertResponse(200);

    // Try to get a protected resource with an Authorization header with a
    // different authentication scheme starting with "Basic". In this case it is
    // expected that the Authorization header is ignored, authentication not
    // attempted (user remains anonymous) and thus the response is a 401 for
    // protected content and 200 for public.
    $token = services_token($this->realm, $uid, REQUEST_TIME + 3600);
    $headers = array(
      'Authorization: Basicstuff ' . base64_encode($token . ':'),
    );
    $response = $this->servicesGet($this->endpoint->path . '/user/' . $uid, NULL, $headers);
    $this->assertResponse(401);
    $this->assertEqual($response['body'], 'Access denied for user anonymous');

    $response = $this->servicesGet($this->endpoint->path . '/node', NULL, $headers);
    $this->assertResponse(200);
  }

}
