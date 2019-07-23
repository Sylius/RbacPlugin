@managing_administration_roles
Feature: Being unable to edit a non existent administration role
   In order to have access to consistent store data
   As an Administrator
   I want not to be able to edit a non existent administration role

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Configurator" in the system
        And this administration role has write permissions for "Configuration" and "RBAC"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Trying to edit a non existent administration role
        When I want to edit a non existent administration role
        Then I should be notified that this administration role does not exist
