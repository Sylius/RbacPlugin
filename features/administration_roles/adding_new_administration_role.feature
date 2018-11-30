@managing_administration_roles
Feature: Adding a new Administration role
    In order to describe Administrators permission sets with the system
    As an Administrator
    I want to be able to add new Administration role

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Configurator" in the system
        And this administration role has write permissions for "Configuration" and "RBAC"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Add a new Administration role to the system
        When I want to add a new Administration role
        And I name it "Root"
        And I add it
        Then I should be notified that Administration role has been successfully created
        And there should be 2 Administration roles within the system
        And there should be Administration role with name "Root"

    @ui
    Scenario: Administration role name uniqueness validation
        Given there is already an Administration role "Root" in the system
        When I want to add a new Administration role
        And I name it "Root"
        And I add it
        Then I should be notified that this name is already taken
        And there should still be 2 Administration roles within the system
