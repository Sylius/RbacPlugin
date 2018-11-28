@access_restrictions
Feature: Having an access only to customers management
    In order not to be able to provide changes in all areas of the system
    As an Administrator with Customers Management permission
    I want to be able to access only customers section in Admin panel

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Customer manager" in the system
        And this administration role has read permission for "Customers management"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Customer manager"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Seeing only customers section in Admin panel main menu
        When I open administration dashboard
        Then only "Customer" section should be available in the main menu

    @ui
    Scenario: Having access only to customers management section
        When I view the administrator panel
        Then I should have access to customers management
        And I should have no access to catalog management
        And I should have no access to configuration
        And I should have no access to marketing management
        And I should have no access to sales management
        And I should have no access to RBAC
