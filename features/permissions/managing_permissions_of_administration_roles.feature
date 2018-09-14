@managing_permissions
Feature: Managing permissions of Administration roles
    In order to specify Administrators permission within the system
    As an Administrator
    I want to be able to manage permissions on Administration roles

    Background:
        Given there is already an Administration role "Product manager" in the system
        And I am logged in as an administrator

    @ui
    Scenario: Seeing available permissions to choose on the list
        When I want to manage permissions of "Product manager" Administration role
        Then I should be able to select "Catalog management" permission
        And I should be able to select "Sales management" permission
        And I should be able to select "Customers management" permission
        And I should be able to select "Marketing management" permission
        And I should be able to select "Configuration" permission

    @ui
    Scenario: Adding permissions to existing Administration role
        When I want to manage permissions of "Product manager" Administration role
        And I add "Catalog management" permission
        And I save my changes
        Then I should be notified that Administration role has been successfully updated
        And this Administration role should have "Catalog management" permission

    @ui
    Scenario: Removing permissions from Administration role
        Given there is already an Administration role "Customer manager" in the system
        And this administration role has "Catalog management" and "Customers management" permissions
        When I want to manage permissions of "Customer manager" Administration role
        And I remove "Catalog management" permission
        And I save my changes
        Then I should be notified that Administration role has been successfully updated
        And this Administration role should have "Customers management" permission
        And this Administration role should not have "Catalog management" permission
