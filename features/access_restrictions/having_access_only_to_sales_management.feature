@access_restrictions
Feature: Having an access only to sales management
    In order to not be able to provide changes in all areas of the system
    As a Administrator - Sales Manager
    I want to be able to access only sales section in Admin panel

    Background:
        Given there is already an Administration role "Sales manager" in the system
        And this administration role has "Sales management" permission
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Product manager"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Seeing only sales section in Admin panel main menu
        When I open administration dashboard
        Then only "Sales" section should be available in the main menu

    @ui
    Scenario: Having access only to sales management section
        When I view the administrator panel
        Then I should have access to sales management
        And I should have no access to catalog management
        And I should have no access to configuration
        And I should have no access to customers management
        And I should have no access to marketing management
