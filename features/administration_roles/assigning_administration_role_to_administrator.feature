@managing_administrators
Feature: Assigning Administration role to Administrator
    In order to manage Administrators' permissions
    As an Administrator
    I want to be able to assign an Administration role to given Administrator

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Configurator" in the system
        And this administration role has write permission for "Configuration"
        And there is already an Administration role "Root" in the system
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Assigning new Administration role to a new Administrator
        Given I want to create a new administrator
        When I specify its email as "rick.sanchez@wubba-lubba-dub-dub.com"
        And I specify its name as "Rick Sanchez"
        And I specify its password as "wubba-lubba-dub-dub"
        And I select "Root" administration role
        And I add it
        Then administrator "rick.sanchez@wubba-lubba-dub-dub.com" should have role "Root"

    @ui
    Scenario: Assigning new Administration role to existing Administrator
        Given there is an administrator "morty.smith@nobody-exists-on-purpose.com" identified by "morty"
        When I want to edit this administrator
        And I select "Root" administration role
        And I save my changes
        Then administrator "morty.smith@nobody-exists-on-purpose.com" should have role "Root"
