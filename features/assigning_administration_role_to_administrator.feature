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
    And I save my changes
    And there should be administrator "jon.snow@the-wall.com" with role "Root"
