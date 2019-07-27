Feature: Provide a consistent standard JSON API endpoint

  In order to offer ProductCategory resource for REST API
  As a software developer
  I need to allow Create, Read, Update, and Delete ProductCategory resources

  Background:
    And there are Groups with the following details:
      | id | name                 | roles                                                                                                           | superAdmin |
      | 1  | Super administrateur | ROLE_PRODUCT_CATEGORY_VIEW,ROLE_PRODUCT_CATEGORY_EDIT,ROLE_PRODUCT_CATEGORY_CREATE,ROLE_PRODUCT_CATEGORY_DELETE | 1          |
      | 2  | Reader               | ROLE_PRODUCT_CATEGORY_VIEW                                                                                              | 0          |

    And there are Civilities with the following details:
      | id | name     | code |
      | 1  | Monsieur | Mr   |

    And there are Users with the following details:
      | id | firstname | lastname  | username            | email               | password  | civilityId | groups               |
      | 1  | fn super  | ln admin  | superadmin@test.com | superadmin@test.com | adminpwd  | 1          | Super administrateur |
      | 2  | fn reader | ls reader | reader@test.com     | reader@test.com     | readerpwd | 1          | Reader               |

    And there are ProductCategories with the following details:
      | id | name       |
      | 1  | Category 1 |
      | 2  | Category 2 |

    And the "content-type" request header is "application/json"

  Scenario: Can add a new Category
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When the request body is:
      """
      {
        "name": "New category"
      }
      """
    And I request "/api/productcategories" using HTTP POST
    Then the response code is 201
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "id": 3,
        "name": "New category"
      }
      """

  Scenario: Can get a collection of ProductCategories
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/productcategories" using HTTP GET
    Then the response code is 200
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      [
        {
          "id": 1,
          "name": "Category 1"
        },
        {
          "id": 2,
          "name": "Category 2"
        }
      ]
      """

  Scenario: Can get a single Category
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/productcategories/1" using HTTP GET
    Then the response code is 200
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "id": 1,
        "name": "Category 1"
      }
      """

  Scenario: Can update an existing ProductCategory
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When the request body is:
      """
      {
        "name": "Rename a category"
      }
      """
    And I request "/api/productcategories/2" using HTTP PUT
    Then the response code is 200
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "id": 2,
        "name": "Rename a category"
      }
      """

  Scenario: Can delete a ProductCategory
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/productcategories/2" using HTTP GET
    Then the response code is 200
    When I request "/api/productcategories/2" using HTTP DELETE
    Then the response code is 204
    When I request "/api/productcategories/2" using HTTP GET
    Then the response code is 404

  Scenario: Reader cannot add a new ProductCategory
    Given I am successfully logged in with username: "reader@test.com", password: "readerpwd" and grantType: "password"
    And I request "/api/productcategories" using HTTP POST
    Then the response code is 403

  Scenario: Cannot create a ProductCategory if not logged in
    When I request "/api/productcategories" using HTTP POST
    Then the response code is 401

  Scenario: Cannot get a single ProductCategory if not logged in
    When I request "/api/productcategories/1" using HTTP GET
    Then the response code is 401

  Scenario: Cannot update a ProductCategory if not logged in
    When I request "/api/productcategories/1" using HTTP PUT
    Then the response code is 401

  Scenario: Cannot delete a ProductCategory if not logged in
    When I request "/api/productcategories/1" using HTTP DELETE
    Then the response code is 401

  Scenario: Reader cannot update an existing ProductCategory
    Given I am successfully logged in with username: "reader@test.com", password: "readerpwd" and grantType: "password"
    When I request "/api/productcategories/1" using HTTP PUT
    Then the response code is 403

  Scenario: Reader cannot delete a ProductCategory
    Given I am successfully logged in with username: "reader@test.com", password: "readerpwd" and grantType: "password"
    When I request "/api/productcategories/1" using HTTP DELETE
    Then the response code is 403

  Scenario: Cannot get a ProductCategory that doesn't exist
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/productcategories/100" using HTTP GET
    Then the response code is 404

  Scenario: Cannot update a ProductCategory that doesn't exist
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/productcategories/100" using HTTP PUT
    Then the response code is 404
