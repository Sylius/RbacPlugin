@access_restrictions
Feature: Having an access to custom RBAC management
    In order not to be able to provide changes in my application's custom section
    As an Administrator with RBAC permission
    I want to be able to access only RBAC section in Admin panel

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "RBAC Configurator" in the system
        And this administration role has write permission for "RBAC"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "RBAC Configurator"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Seeing only configuration section in Admin panel main menu
        When I open administration dashboard
        Then only "RBAC" section should be available in the main menu

    @ui
    Scenario: Having access only to configuration management section
        When I view the administrator panel
        Then I should have no access to configuration
        And I should have no access to catalog management
        And I should have no access to customers management
        And I should have no access to marketing management
        And I should have no access to sales management
        But I should have access to RBAC
