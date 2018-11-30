@access_restrictions
Feature: Having a write access only to marketing management
    In order not to be able to provide changes in all areas of the system
    As an Administrator with Marketing Management permission
    I want to be able to access only marketing section in Admin panel

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Marketing manager" in the system
        And this administration role has write permission for "Marketing management"
        And this administration role has read permissions for "Configuration", "Customers management" and "Catalog management"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Marketing manager"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Having write access only to marketing management section
        When I view the administrator panel
        Then I should be able to introduce modifications in marketing management section
        But I should not be able to introduce modifications in configuration section
        And I should not be able to introduce modifications in catalog management section
        And I should not be able to introduce modifications in customers management section
