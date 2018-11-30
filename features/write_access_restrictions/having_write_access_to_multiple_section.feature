@access_restrictions
Feature: Having a write access to multiple sections
    In order to be able to provide changes only in specific areas of the system
    As an Administrator
    I want to be able to access specific sections in Admin panel

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Configurator" in the system
        And this administration role has write permissions for "Configuration", "Catalog management" and "Marketing management"
        And this administration role has read permission for "Customers management"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Having write access to specific sections in Admin panel
        When I view the administrator panel
        Then I should be able to introduce modifications in configuration section
        And I should be able to introduce modifications in catalog management section
        And I should be able to introduce modifications in marketing management section
        But I should not be able to introduce modifications in customers management section
