# Secure Book Store

### Functionals Requirements
- Users log in with username/password credentials (use HTTPS to protect them)
- Self-registration: users are asked to choose their username and password
- Password change: users can change their password
- Account recovery: users can recover their account in case they forget their password
- Shopping cart: users can collect a number of items for successive purchase, also before authentication
- Order placing: users follow a multi-step procedure by providing credit-card info, shipping info, and then clicking on «BUY BOOK!»
    - Payment is simulated and always succeeds
- After having placed the order, users can also download the electronic version of the book
- Log: security-critical events must be logged, to enable post-incident investigation
    - You can use any PHP library you want to keep logs

### Non Functionals Requirements
- For the development it is possible to use:
    - PHP (no frameworks, just basic PHP)
    - SQL
    - Javascript (no frameworks, just basic Javascript)