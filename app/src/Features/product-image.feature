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


    And there are Products with the following details:
      | id | name      | description           | priceAmount | priceCurrency | categories |
      | 1  | Product 1 | Description Product 1 | 1020        | EUR           |            |

  Scenario: Can add a new Image
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    Given I attach "src/Features/Assets/image.png" to the request as 'file'
    And I request "/api/products/1/images" using HTTP POST
    Then the response code is 201
    And the "Content-Type" response header is "application/json"
    And the response body contains JSON:
      """
      {
        "id": 1,
        "name": "image-0.png",
        "uri": "/uploads/products/images/image-0.png"
      }
      """

  Scenario: Reader cannot add a new Image
    Given I am successfully logged in with username: "reader@test.com", password: "readerpwd" and grantType: "password"
    And I request "/api/products/1/images" using HTTP POST
    Then the response code is 403

  Scenario: Cannot create a new Image if not logged in
    When I request "/api/products/1/images" using HTTP POST
    Then the response code is 401

  Scenario: Cannot add an Image to a product that doesn't exist
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    When I request "/api/products/2/images" using HTTP POST
    Then the response code is 404

  Scenario: Cannot add an Image with wrong mimeType
    Given I am successfully logged in with username: "superadmin@test.com", password: "adminpwd" and grantType: "password"
    Given I attach "src/Features/Assets/openoffice.odt" to the request as 'file'
    And I request "/api/products/1/images" using HTTP POST
    Then the response code is 400
