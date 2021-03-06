<?php
/**
 * PetApiTest
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Swagger Petstore
 *
 * This spec is mainly for testing Petstore server and contains fake endpoints, models. Please do not use this for any other purpose. Special characters: \" \\
 *
 * OpenAPI spec version: 1.0.0
 * Contact: apiteam@swagger.io
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Please update the test case below to test the endpoint.
 */

namespace Swagger\Client;

use \Swagger\Client\Configuration;
use \Swagger\Client\ApiClient;
use \Swagger\Client\ApiException;
use \Swagger\Client\ObjectSerializer;

/**
 * PetApiTest Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class PetApiTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
        // add a new pet (id 10005) to ensure the pet object is available for all the tests

        // increase memory limit to avoid fatal error due to findPetByStatus
        // returning a lot of data
        ini_set('memory_limit', '256M');

        // for error reporting (need to run with php5.3 to get no warning)
        //ini_set('display_errors', 1);
        //error_reporting(~0);
        // when running with php5.5, comment out below to skip the warning about
        // using @ to handle file upload
        //ini_set('display_startup_errors',1);
        //ini_set('display_errors',1);
        //error_reporting(-1);

        // enable debugging
        //Configuration::$debug = true;

        // skip initializing the API client as it should be automatic
        //$api_client = new ApiClient('http://petstore.swagger.io/v2');
        // new pet
        $new_pet_id = 10005;
        $new_pet = new Model\Pet;
        $new_pet->setId($new_pet_id);
        $new_pet->setName("PHP Unit Test");
        $new_pet->setPhotoUrls(array("http://test_php_unit_test.com"));
        // new tag
        $tag= new Model\Tag;
        $tag->setId($new_pet_id); // use the same id as pet
        $tag->setName("test php tag");
        // new category
        $category = new Model\Category;
        $category->setId($new_pet_id); // use the same id as pet
        $category->setName("test php category");

        $new_pet->setTags(array($tag));
        $new_pet->setCategory($category);

        $pet_api = new Api\PetApi();
        // add a new pet (model)
        $add_response = $pet_api->addPet($new_pet);
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
        $new_pet_id = 10005;
        $pet_api = new Api\PetApi();
        // delete the pet (model)
        $pet_api->deletePet($new_pet_id);
    }

    /**
     * Test case for addPet
     *
     * Add a new pet to the store.
     *
     */
    public function testAddPet()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $api_client = new ApiClient($config);
        $new_pet_id = 10005;
        $new_pet = new Model\Pet;
        $new_pet->setId($new_pet_id);
        $new_pet->setName("PHP Unit Test 2");
        $pet_api = new Api\PetApi($api_client);
        // add a new pet (model)
        $add_response = $pet_api->addPet($new_pet);
        // return nothing (void)
        $this->assertSame($add_response, null);
        // verify added Pet
        $response = $pet_api->getPetById($new_pet_id);
        $this->assertSame($response->getId(), $new_pet_id);
        $this->assertSame($response->getName(), 'PHP Unit Test 2');
    }

    /**
     * Test case for deletePet
     *
     * Deletes a pet.
     *
     */
    public function testDeletePet()
    {

    }

    /**
     * Test getPetByStatus and verify by the "id" of the response
     */
    public function testFindPetByStatus()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $api_client = new ApiClient($config);
        $pet_api = new Api\PetApi($api_client);
        // return Pet (model)
        $response = $pet_api->findPetsByStatus("available");
        $this->assertGreaterThan(0, count($response)); // at least one object returned
        $this->assertSame(get_class($response[0]), "Swagger\\Client\\Model\\Pet"); // verify the object is Pet
        // loop through result to ensure status is "available"
        foreach ($response as $_pet) {
            $this->assertSame($_pet['status'], "available");
        }
        // test invalid status
        $response = $pet_api->findPetsByStatus("unknown_and_incorrect_status");
        $this->assertSame(count($response), 0); // confirm no object returned
    }

    /**
     * Test case for findPetsByStatus
     *
     * Finds Pets by status with empty response.
     *
     * Make sure empty arrays from a producer is actually returned as
     * an empty array and not some other value. At some point it was
     * returned as null because the code stumbled on PHP loose type
     * checking (not on empty array is true, same thing could happen
     * with careless use of empty()).
     *
     */
    public function testFindPetsByStatusWithEmptyResponse()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $apiClient = new ApiClient($config);
        $storeApi = new Api\PetApi($apiClient);
        // this call returns and empty array
        $response = $storeApi->findPetsByStatus(array());

        // make sure this is an array as we want it to be
        $this->assertInternalType("array", $response);

        // make sure the array is empty just in case the petstore
        // server changes its output
        $this->assertEmpty($response);
    }

    /**
     * Test case for findPetsByTags
     *
     * Finds Pets by tags.
     *
     */
    public function testFindPetsByTags()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $api_client = new ApiClient($config);
        $pet_api = new Api\PetApi($api_client);
        // return Pet (model)
        $response = $pet_api->findPetsByTags("test php tag");
        $this->assertGreaterThan(0, count($response)); // at least one object returned
        $this->assertSame(get_class($response[0]), "Swagger\\Client\\Model\\Pet"); // verify the object is Pet
        // loop through result to ensure status is "available"
        foreach ($response as $_pet) {
            $this->assertSame($_pet['tags'][0]['name'], "test php tag");
        }
        // test invalid status
        $response = $pet_api->findPetsByTags("unknown_and_incorrect_tag");
        $this->assertSame(count($response), 0); // confirm no object returned
    }

    /**
     * Test case for getPetById
     *
     * Find pet by ID.
     *
     */
    public function testGetPetById()
    {
        // initialize the API client without host
        $pet_id = 10005;  // ID of pet that needs to be fetched
        $pet_api = new Api\PetApi();
        $pet_api->getApiClient()->getConfig()->setApiKey('api_key', '111222333444555');
        // return Pet (model)
        $response = $pet_api->getPetById($pet_id);
        $this->assertSame($response->getId(), $pet_id);
        $this->assertSame($response->getName(), 'PHP Unit Test');
        $this->assertSame($response->getPhotoUrls()[0], 'http://test_php_unit_test.com');
        $this->assertSame($response->getCategory()->getId(), $pet_id);
        $this->assertSame($response->getCategory()->getName(), 'test php category');
        $this->assertSame($response->getTags()[0]->getId(), $pet_id);
        $this->assertSame($response->getTags()[0]->getName(), 'test php tag');
    }

    /**
     * test getPetByIdWithHttpInfo with a Pet object (id 10005)
     */
    public function testGetPetByIdWithHttpInfo()
    {
        // initialize the API client without host
        $pet_id = 10005;  // ID of pet that needs to be fetched
        $pet_api = new Api\PetApi();
        $pet_api->getApiClient()->getConfig()->setApiKey('api_key', '111222333444555');
        // return Pet (model)
        list($response, $status_code, $response_headers) = $pet_api->getPetByIdWithHttpInfo($pet_id);
        $this->assertSame($response->getId(), $pet_id);
        $this->assertSame($response->getName(), 'PHP Unit Test');
        $this->assertSame($response->getCategory()->getId(), $pet_id);
        $this->assertSame($response->getCategory()->getName(), 'test php category');
        $this->assertSame($response->getTags()[0]->getId(), $pet_id);
        $this->assertSame($response->getTags()[0]->getName(), 'test php tag');
        $this->assertSame($status_code, 200);
        $this->assertSame($response_headers['Content-Type'], 'application/json');
    }

    /**
     * Test case for updatePet
     *
     * Update an existing pet.
     *
     */
    public function testUpdatePet()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $api_client = new ApiClient($config);
        $pet_id = 10001;  // ID of pet that needs to be fetched
        $pet_api = new Api\PetApi($api_client);
        // create updated pet object
        $updated_pet = new Model\Pet;
        $updated_pet->setId($pet_id);
        $updated_pet->setName('updatePet'); // new name
        $updated_pet->setStatus('pending'); // new status
        // update Pet (model/json)
        $update_response = $pet_api->updatePet($updated_pet);
        // return nothing (void)
        $this->assertSame($update_response, null);
        // verify updated Pet
        $response = $pet_api->getPetById($pet_id);
        $this->assertSame($response->getId(), $pet_id);
        $this->assertSame($response->getStatus(), 'pending');
        $this->assertSame($response->getName(), 'updatePet');
    }

    /**
     *  Test updatePetWithFormWithHttpInfo and verify by the "name" of the response
     */
    public function testUpdatePetWithFormWithHttpInfo()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $api_client = new ApiClient($config);
        $pet_id = 10001;  // ID of pet that needs to be fetched
        $pet_api = new Api\PetApi($api_client);
        // update Pet (form)
        list($update_response, $status_code, $http_headers) = $pet_api->updatePetWithFormWithHttpInfo(
            $pet_id,
            'update pet with form with http info'
        );
        // return nothing (void)
        $this->assertNull($update_response);
        $this->assertSame($status_code, 200);
        $this->assertSame($http_headers['Content-Type'], 'application/json');
        $response = $pet_api->getPetById($pet_id);
        $this->assertSame($response->getId(), $pet_id);
        $this->assertSame($response->getName(), 'update pet with form with http info');
    }

    /**
     * Test case for updatePetWithForm
     *
     * Updates a pet in the store with form data.
     *
     */
    public function testUpdatePetWithForm()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $api_client = new ApiClient($config);
        $pet_id = 10001;  // ID of pet that needs to be fetched
        $pet_api = new Api\PetApi($api_client);
        // update Pet (form)
        $update_response = $pet_api->updatePetWithForm($pet_id, 'update pet with form', 'sold');
        // return nothing (void)
        $this->assertSame($update_response, null);
        $response = $pet_api->getPetById($pet_id);
        $this->assertSame($response->getId(), $pet_id);
        $this->assertSame($response->getName(), 'update pet with form');
        $this->assertSame($response->getStatus(), 'sold');
    }

    /**
     * Test case for uploadFile
     *
     * uploads an image.
     *
     */
    public function testUploadFile()
    {
        // initialize the API client
        $config = (new Configuration())->setHost('http://petstore.swagger.io/v2');
        $api_client = new ApiClient($config);
        $pet_api = new Api\PetApi($api_client);
        // upload file
        $pet_id = 10001;
        $response = $pet_api->uploadFile($pet_id, "test meta", "./composer.json");
        // return ApiResponse
        $this->assertInstanceOf('Swagger\Client\Model\ApiResponse', $response);
    }
   
    /*
     * test static functions defined in ApiClient
     */
    public function testApiClient()
    {
        // test selectHeaderAccept
        $api_client = new ApiClient();
        $this->assertSame('application/json', $api_client->selectHeaderAccept(array(
            'application/xml',
            'application/json'
        )));
        $this->assertSame(null, $api_client->selectHeaderAccept(array()));
        $this->assertSame('application/yaml,application/xml', $api_client->selectHeaderAccept(array(
            'application/yaml',
            'application/xml'
        )));

        // test selectHeaderContentType
        $this->assertSame('application/json', $api_client->selectHeaderContentType(array(
            'application/xml',
            'application/json'
        )));
        $this->assertSame('application/json', $api_client->selectHeaderContentType(array()));
        $this->assertSame('application/yaml,application/xml', $api_client->selectHeaderContentType(array(
            'application/yaml',
            'application/xml'
        )));

        // test addDefaultHeader and getDefaultHeader
        $api_client->getConfig()->addDefaultHeader('test1', 'value1');
        $api_client->getConfig()->addDefaultHeader('test2', 200);
        $defaultHeader = $api_client->getConfig()->getDefaultHeaders();
        $this->assertSame('value1', $defaultHeader['test1']);
        $this->assertSame(200, $defaultHeader['test2']);

        // test deleteDefaultHeader
        $api_client->getConfig()->deleteDefaultHeader('test2');
        $defaultHeader = $api_client->getConfig()->getDefaultHeaders();
        $this->assertFalse(isset($defaultHeader['test2']));

        $pet_api2 = new Api\PetApi();
        $config3 = new Configuration();
        $apiClient3 = new ApiClient($config3);
        $apiClient3->getConfig()->setUserAgent('api client 3');
        $config4 = new Configuration();
        $apiClient4 = new ApiClient($config4);
        $apiClient4->getConfig()->setUserAgent('api client 4');
        $pet_api3 = new Api\PetApi($apiClient3);

        // 2 different api clients are not the same
        $this->assertNotEquals($apiClient3, $apiClient4);
        // customied pet api not using the old pet api's api client
        $this->assertNotEquals($pet_api2->getApiClient(), $pet_api3->getApiClient());

        // test access token
        $api_client->getConfig()->setAccessToken("testing_only");
        $this->assertSame('testing_only', $api_client->getConfig()->getAccessToken());
    }

}
