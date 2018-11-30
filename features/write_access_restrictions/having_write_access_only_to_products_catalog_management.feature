@access_restrictions
Feature: Having a write access only to products catalog management
    In order not to be able to provide changes in all areas of the system
    As an Administrator with Catalog Management permission
    I want to be able to access only products catalog section in Admin panel

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Product manager" in the system
        And this administration role has write permission for "Catalog management"
        And this administration role has read permissions for "Configuration", "Customers management" and "Marketing management"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Product manager"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Having write access only to catalog management section
        When I view the administrator panel
        Then I should be able to introduce modifications in catalog management section
        But I should not be able to introduce modifications in configuration section
        And I should not be able to introduce modifications in customers management section
        And I should not be able to introduce modifications in marketing management section
