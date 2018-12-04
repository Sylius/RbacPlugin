@managing_administrators
Feature: Revoking Administration role of the Administrator
    In order to manage Administrators' permissions
    As an Administrator
    I want to be able to revoke an Administration role of a given Administrator

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Configurator" in the system
        And this administration role has write permission for "Configuration"
        And there is already an Administration role "Sales manager" in the system
        And there is already an Administration role "Customers manager" in the system
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And there is an administrator "birdperson@eagle.com" identified by "iBelieveICanFly"
        And this administrator has administration role "Sales manager"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Changing Administrator's role
        When I want to edit administrator "birdperson@eagle.com"
        And I select "Customers manager" administration role
        And I save my changes
        Then administrator "birdperson@eagle.com" should have role "Customers manager"

    @ui
    Scenario: Being unable to remove role from Administrator
        When I want to edit administrator "birdperson@eagle.com"
        Then I should not be able to remove their role
