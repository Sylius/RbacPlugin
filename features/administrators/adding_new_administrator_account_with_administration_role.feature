@managing_administration_roles
Feature: Adding a new Administrator account with administration role
    In order to manage permissions of new Administrators
    As an Administrator
    I want to be able to add a new Administrator account with administration role

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "No sections access" in the system

    @ui
    Scenario: Adding a new administrator account with administration role in the system
        When I add a new administrator "good.father@abc.com" named "Good" with "Father" last name and "No sections access" administration role
        Then administrator account "good.father@abc.com" should have first name "Good" and last name "Father"
        And this administrator should have administration role "No sections access"
