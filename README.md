<h2>1. INSTALLATION</h2>

<h3>1.1. Clone project to empty site root folder:</h3>

`git clone https://github.com/cept73/kc-lms-test-site.git .`

<h3>1.2. Init project with init.sh script</h3>

This command will also clone config.php file to config-local.php and trying to open editor which you need to save with proper credentials:

`./init.sh`

<h3>1.3. Execute SQL in your MySQL Manager to create tables and seed test data:</h2>

```
CREATE TABLE `api_users` (
  `uuid` VARCHAR(32) NOT NULL,
  `user_name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE INDEX `user__user_name__UNIQUE` (`user_name`)
);

/** Username: user, password: 12345 */
INSERT INTO `api_users` VALUES ('TESTTESTTESTTESTTESTTESTTESTTEST', 'user', '$2y$10$jOzys0.q5fRQIlC4EADRwu0DXt9rz7iuSoMtZCO/.HlYONNJgtawu');
```

---

<h2>2. TROUBLESHOOTING</h2>

<h3>2.1. Check if the following libraries are allowed in PHP configuration:</h3>

You need to be allowed: `ext-json`, `ext-pdo` and `ext-openssl`

<h3>2.2. If errors start after code changes, run:</h2>

`composer.phar dump-autoload`
