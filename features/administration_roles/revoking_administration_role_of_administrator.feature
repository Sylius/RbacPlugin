@managing_administrators
Feature: Revoking Administration role of the Administrator
    In order to manage Administrators' permissions
    As an Administrator
    I want to be able to revoke an Administration role of a given Administrator

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Configurator" in the system
        And this administration role has "Configuration" permission
        And there is already an Administration role "Root" in the system
        And there is already an Administration role "Customers manager" in the system
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And there is an administrator "root@example.com" identified by "rootPassword"
        And this administrator has administration role "Root"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Changing Administrator's role
        When I want to edit administrator "root@example.com"
        And I select "Customers manager" administration role
        And I save my changes
        Then administrator "root@example.com" should have role "Customers manager"

    @ui
    Scenario: Removing role from Administrator
        When I want to edit administrator "root@example.com"
        And I remove their role
        And I save my changes
        Then administrator "root@example.com" should have no role assigned
