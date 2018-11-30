@managing_permissions
Feature: Managing permissions of Administration roles
    In order to specify Administrators permission within the system
    As an Administrator
    I want to be able to manage permissions on Administration roles

    Background:
        Given the store operates on a single channel in "United States"
        And there is already an Administration role "Product manager" in the system
        And there is already an Administration role "Configurator" in the system
        And this administration role has write permissions for "Configuration" and "RBAC"
        And there is an administrator "scary.terry@nightmare.com" identified by "youCanRunButYouCannotHide"
        And this administrator has administration role "Configurator"
        And I am logged in as "scary.terry@nightmare.com" administrator

    @ui
    Scenario: Seeing available permissions to choose on the list
        When I want to manage permissions of "Product manager" Administration role
        Then I should be able to manage "Catalog management" permission
        And I should be able to manage "Sales management" permission
        And I should be able to manage "Customers management" permission
        And I should be able to manage "Marketing management" permission
        And I should be able to manage "Configuration" permission
        And I should be able to manage "RBAC" permission

    @ui
    Scenario: Adding permissions to existing Administration role
        When I want to manage permissions of "Product manager" Administration role
        And I add "Catalog management" permission with "Read" and "Write" access
        And I save my changes
        Then I should be notified that Administration role has been successfully updated
        And this administration role should have "Catalog management" permission with "Read" and "Write" access

    @ui
    Scenario: Adding permissions with read access
        When I want to manage permissions of "Product manager" Administration role
        And I add "Catalog management" permission with "Read" access
        And I save my changes
        Then I should be notified that Administration role has been successfully updated
        And this administration role should have "Catalog management" permission with "Read" access

    @ui
    Scenario: Adding permissions with write access
        When I want to manage permissions of "Product manager" Administration role
        And I add "Catalog management" permission with "Write" access
        And I save my changes
        Then I should be notified that Administration role has been successfully updated
        And this administration role should have "Catalog management" permission with "Read" and "Write" access

    @ui
    Scenario: Removing permissions from Administration role
        Given there is already an Administration role "Customer manager" in the system
        And this administration role has write permissions for "Catalog management" and "Customers management"
        When I want to manage permissions of "Customer manager" Administration role
        And I remove "Catalog management" permission
        And I save my changes
        Then I should be notified that Administration role has been successfully updated
        And this administration role should have "Customers management" permission with "Read" and "Write" access
        And this administration role should not have "Catalog management" permission

    @ui
    Scenario: Removing permissions' accesses
        Given there is already an Administration role "Customer manager" in the system
        And this administration role has write permissions for "Catalog management" and "Customers management"
        When I want to manage permissions of "Customer manager" Administration role
        And I remove all accesses from "Catalog management" permission
        And I save my changes
        Then I should be notified that Administration role has been successfully updated
        And this administration role should have "Customers management" permission with "Read" and "Write" access
        And this administration role should not have "Catalog management" permission
