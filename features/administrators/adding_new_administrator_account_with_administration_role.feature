@managing_administration_roles
Feature: Adding a new Administrator account with administration role
    In order to add new Administrator account to the system
    As an Administrator
    I want to be able to add new Administrator account

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "No sections access" in the system

    @ui
    Scenario: Add new administrator account with administration role in the system
        When I want to add a new administrator "good.father@abc.com" named "Good" last name "Father" and locale "en_US"
        And this administrator has administration role "No sections access"
        Then I should seeing administrator account "good.father@abc.com" named "Good" last name "Father" and locale "en_US"
        And I should seeing that this administrator has administration role "No sections access"
