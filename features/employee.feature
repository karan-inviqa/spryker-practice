Feature: Employee list
  In order to edit employee
  As a admin user
  I need to be able view all added employees

#  @javascript
#  Scenario: Display "no found" message for  0 Employees
#    Given there are 0 employees added
#    When I visit employee page
#    Then I should get "No data available in table" message

  @javascript
  Scenario: Dispaly list of Employees if any
    Given there are 0 employees added
    When I visit employee page
    And Add a new employee
    Then I should get list of 1 employees