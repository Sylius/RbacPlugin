@access_restrictions
Feature: Having an access to multiple sections
    In order to be able to provide changes only in specific areas of the system
    As an Administrator
    I want to be able to access specific sections in Admin panel

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Configurator" in the system
        And this administration role has read permissions for "Configuration", "Catalog management", "Marketing management" and "RBAC"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Seeing only configuration section in Admin panel main menu
        When I open administration dashboard
        Then "Configuration", "Catalog", "Marketing" and "RBAC" sections should be available in the main menu

    @ui
    Scenario: Having access to specific sections in Admin panel
        When I view the administrator panel
        Then I should have access to configuration
        And I should have access to catalog management
        And I should have no access to customers management
        And I should have access to marketing management
        And I should have no access to sales management
        And I should have access to RBAC
