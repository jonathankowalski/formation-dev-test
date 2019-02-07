Feature: L'écheance est calculée automatiquement et affichée dans le champ

  Scenario: Paul veut renseigner son revenu
    Given Paul dispose d'un revenu de 3300 €
    When Paul le renseigne dans le champ "revenus"
    And que Paul attend 2 secondes
    Then Le champ "echeance" devrait contenir 1089 €