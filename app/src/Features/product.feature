Feature: Provide a consistent standard JSON API endpoint

  In order to offer Product resource for REST API
  As a software developer
  I need to allow Create, Read, Update, and Delete Product resources

  Background:
    And there are Groups with the following details:
      | id | name                 | roles                                                                       | superAdmin |
      | 1  | Super administrateur | ROLE_PRODUCT_VIEW,ROLE_PRODUCT_EDIT,ROLE_PRODUCT_CREATE,ROLE_PRODUCT_DELETE | 1          |
      | 2  | Reader               | ROLE_PRODUCT_VIEW                                                           | 0          |

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

    And there are Products with the following details:
      | id | name      | description           | priceAmount | priceCurrency | categories |
      | 1  | Product 1 | Description Product 1 | 1020        | EUR           | 1,2        |
      | 2  | Product 2 | Description Product 2 | 2030        | EUR           | 1          |
      | 3  | Product 3 | Description Product 3 | 3020        | EUR           | 1,2        |
      | 4  | Product 4 | Description Product 4 | 4030        | EUR           | 1          |
      | 5  | Product 5 | Description Product 5 | 5020        | EUR           | 1,2        |


    And the "content-type" request header is "application/json"

  Scenario: Can add a new Product
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When the request body is:
      """
      {
        "name": "New product",
        "description": "Description new product",
        "price": {
          "amount": "150,50"
        },
        "categories": [
          1,
          2
        ]
      }
      """
    And I request "/api/products" using HTTP POST
    Then the response code is 201
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "id": 6,
        "name": "New product",
        "description": "Description new product",
        "priceAmount": 15050,
        "priceCurrency": "EUR",
        "categories": [
          {
            "id": 1,
            "name": "Category 1"
          },
          {
            "id": 2,
            "name": "Category 2"
          }
        ]
      }
      """

  Scenario: Can get a collection of Products with default pagination
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/products" using HTTP GET
    Then the response code is 200
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "data": [
          {
            "id": 1,
            "name": "Product 1",
            "description": "Description Product 1",
            "priceAmount": 1020,
            "priceCurrency": "EUR",
            "categories": [
              {
                "id": 1,
                "name": "Category 1"
              },
              {
                "id": 2,
                "name": "Category 2"
              }
            ]
          },
          {
            "id": 2,
            "name": "Product 2",
            "description": "Description Product 2",
            "priceAmount": 2030,
            "priceCurrency": "EUR",
            "categories": [
              {
                "id": 1,
                "name": "Category 1"
              }
            ]
          },
          {
            "id": 3,
            "name": "Product 3",
            "description": "Description Product 3",
            "priceAmount": 3020,
            "priceCurrency": "EUR",
            "categories": [
              {
                "id": 1,
                "name": "Category 1"
              },
              {
                "id": 2,
                "name": "Category 2"
              }
            ]
          },
          {
            "id": 4,
            "name": "Product 4",
            "description": "Description Product 4",
            "priceAmount": 4030,
            "priceCurrency": "EUR",
            "categories": [
              {
                "id": 1,
                "name": "Category 1"
              }
            ]
          },
          {
            "id": 5,
            "name": "Product 5",
            "description": "Description Product 5",
            "priceAmount": 5020,
            "priceCurrency": "EUR",
            "categories": [
              {
                "id": 1,
                "name": "Category 1"
              },
              {
                "id": 2,
                "name": "Category 2"
              }
            ]
          }
        ],
        "meta": {
          "page": 1,
          "pageCount": 1,
          "itemsPerPage": 5,
          "totalItems": 5
        }
      }
      """

  Scenario: Can get a collection of Products with page = 2 and itemsPerPage=2
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/products?itemsPerPage=2&page=2" using HTTP GET
    Then the response code is 200
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "data": [
          {
            "id": 3,
            "name": "Product 3",
            "description": "Description Product 3",
            "priceAmount": 3020,
            "priceCurrency": "EUR",
            "categories": [
              {
                "id": 1,
                "name": "Category 1"
              },
              {
                "id": 2,
                "name": "Category 2"
              }
            ]
          },
          {
            "id": 4,
            "name": "Product 4",
            "description": "Description Product 4",
            "priceAmount": 4030,
            "priceCurrency": "EUR",
            "categories": [
              {
                "id": 1,
                "name": "Category 1"
              }
            ]
          }
        ],
        "meta": {
          "page": 2,
          "pageCount": 3,
          "itemsPerPage": 2,
          "totalItems": 5
        }
      }
      """

  Scenario: Can get a single Product
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/products/1" using HTTP GET
    Then the response code is 200
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "id": 1,
        "name": "Product 1",
        "description": "Description Product 1",
        "priceAmount": 1020,
        "priceCurrency": "EUR",
        "categories": [
          {
            "id": 1,
            "name": "Category 1"
          },
          {
            "id": 2,
            "name": "Category 2"
          }
        ]
      }
      """

  Scenario: Can update an existing Product
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When the request body is:
      """
      {
        "name": "Updated Product 1",
        "description": "Updated Description Product 1",
        "price": {
          "amount": "24,56"
        },
        "categories": [
          2
        ]
      }
      """
    And I request "/api/products/1" using HTTP PUT
    Then the response code is 200
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "id": 1,
        "name": "Updated Product 1",
        "description": "Updated Description Product 1",
        "priceAmount": 2456,
        "priceCurrency": "EUR",
        "categories": [
          {
            "id": 2,
            "name": "Category 2"
          }
        ]
      }
      """

  Scenario: Can delete a Product
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/products/2" using HTTP GET
    Then the response code is 200
    When I request "/api/products/2" using HTTP DELETE
    Then the response code is 204
    When I request "/api/products/2" using HTTP GET
    Then the response code is 404

  Scenario: Reader cannot add a new Product
    Given I am successfully logged in with username: "reader@test.com", password: "readerpwd" and grantType: "password"
    And I request "/api/products" using HTTP POST
    Then the response code is 403

  Scenario: Cannot create a Product if not logged in
    When I request "/api/products" using HTTP POST
    Then the response code is 401

  Scenario: Cannot get a single Product if not logged in
    When I request "/api/products/1" using HTTP GET
    Then the response code is 401

  Scenario: Cannot update a Product if not logged in
    When I request "/api/products/1" using HTTP PUT
    Then the response code is 401

  Scenario: Cannot delete a Product if not logged in
    When I request "/api/products/1" using HTTP DELETE
    Then the response code is 401

  Scenario: Reader cannot update an existing Product
    Given I am successfully logged in with username: "reader@test.com", password: "readerpwd" and grantType: "password"
    When I request "/api/products/1" using HTTP PUT
    Then the response code is 403

  Scenario: Reader cannot delete a Product
    Given I am successfully logged in with username: "reader@test.com", password: "readerpwd" and grantType: "password"
    When I request "/api/products/1" using HTTP DELETE
    Then the response code is 403

  Scenario: Cannot get a Product that doesn't exist
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/products/100" using HTTP GET
    Then the response code is 404

  Scenario: Cannot update a Product that doesn't exist
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/products/100" using HTTP PUT
    Then the response code is 404