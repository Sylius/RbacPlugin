@installing_rbac_plugin
Feature: Adding a new Administration role
    In order make RBAC plugin easily usable
    As a Store Developer
    I want to be able to install the plugin after adding it to my project

    Background:
        Given there is an administrator "scary.terry@nightmare.com"
        Given there is an administrator "rick.sanchez@gmail.com"

    @rbac_cli
    Scenario: Installing RBAC plugin
        When I install RBAC plugin by specifying root administrator's email as "scary.terry@nightmare.com"
        Then there should be "No sections access" administration role
        And the "No sections access" role shouldn't have access to any section
        And there should be "Configurator" administration role
        And the "Configurator" role should have access to every section
        And the administrator "rick.sanchez@gmail.com" should have "No sections access" role
        And the administrator "scary.terry@nightmare.com" should have "Configurator" role
