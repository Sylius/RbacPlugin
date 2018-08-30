@managing_administration_roles
Feature: Adding a new Administration role
    In order to describe Administrators permission sets with the system
    As an Administrator
    I want to be able to add new Administration role

    @ui
    Scenario: Add a new Administration role to the system
        When I want to add a new Administration role
        And I name it "Root"
        And I add it
        Then I should be notified that Administration role has been successfully created
        And there should be 1 Administration role with name "Root" within the system

    @ui
    Scenario: Administration role name uniqueness validation
        Given there is already an Administration role "Root" in the system
        When I want to add a new Administration role
        And I name it "Root"
        And I add it
        Then I should be notified that this name is already taken
        And there should still be 1 Administration role with name "Root" within the system
