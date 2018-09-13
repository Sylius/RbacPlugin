@managing_administration_roles
Feature: Assigning Administration role to Administrator
    In order to manage Administrators' permissions
    As an Administrator
    I want to be able to assign an Administration role to given Administrator

    Background:
        Given there is already an Administration role "Root" in the system
        And I am logged in as an administrator
        And I browse administrators

    @ui
    Scenario: Assigning new Administration role to a new Administrator
        Given I want to create a new administrator
        When I specify its email as "jon.snow@the-wall.com"
        And I specify its name as "sample_admin"
        And I specify its password as "super_secret"
        And I select "Root" administration role
        And I enable it
        And I add it
        Then there should be administrator "jon.snow@the-wall.com" with role "Root"

    @ui
    Scenario: Assigning new Administration role to existing Administrator
        Given there is an administrator "ted@example.com" identified by "bear"
        When I want to edit this administrator
        And I select "Root" administration role
        And I save my changes
        Then there should be administrator "ted@example.com" with role "Root"
