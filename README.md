<h1>Тестовое задание</h1>

❔ Написать сайт с авторизацией, возможностью сохранять в сессии.
При входе показывает список студентов, с постраничным выводом. Должен брать их по апи. Регистрацию делать не нужно, есть логин-пароль для входа. 

🗜 Ограничения:
Дизайн по заданным картинкам. Использование фреймворков не допускается
Сторонние библиотеки не использовать, композер только для автозагрузки классов. 
Таблица для пользователей api_users, таблица студентов students.
Для входа использовать: user 12345

Развернуто на: https://kc.code73.ru/

Код для примера кода. API я в дальнейшем переделал бы, передавая токен с ограниченным действием, а пока программа ориентируется на сессии, вынес бы в отдельную папку



<h2>1. INSTALLATION</h2>

<h3>1.1. Clone project to empty site root folder:</h3>

`git clone https://github.com/cept73/kc-lms-test-site.git .`

<h3>1.2. Init project with init.sh script</h3>

This command also clones the config.php file to config-local.php and tries to open the editor to set correct settings:

`./init.sh`

<h3>1.3. Execute SQL in your MySQL Manager to create tables and add test data:</h2>

```
CREATE TABLE `api_users` (
  `uuid` VARCHAR(32) NOT NULL,
  `user_name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE INDEX `api_users__user_name__UNIQUE` (`user_name`)
);

/** Username: user, password: 12345 */
INSERT INTO `api_users` VALUES ('TESTTESTTESTTESTTESTTESTTESTTEST', 'user', '$2y$10$jOzys0.q5fRQIlC4EADRwu0DXt9rz7iuSoMtZCO/.HlYONNJgtawu');

CREATE TABLE `students` (
  `uuid` VARCHAR(32) NOT NULL,
  `user_name` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `title` VARCHAR(45) NULL,
  `group_name` VARCHAR(45) NULL,
  `active` TINYINT NULL,
  PRIMARY KEY (`uuid`)
);

INSERT INTO students VALUES ('ef6919c11760059c543ce778722c7597', 'Bernardo Santini', 'kctest00202', '...', 'Default group', true);
INSERT INTO students VALUES ('5489df6283eae6226a03539ea5f171e8', 'George Quebedo', 'kctest00213', '...', 'Default group', true);
INSERT INTO students VALUES ('493a50675ce639d59b0f3df1e60c56ba', 'Rob Shneider', 'kctest00208', '...', 'Default group', true);
INSERT INTO students VALUES ('c5ba3db1039a6638c723434e1de91544', 'Terry Cruz', 'kctest00220', '...', 'Default group', false);
INSERT INTO students VALUES ('24e3612b9885dc93b180b242444d29d4', 'David Smith', 'kctest00209', '...', 'Default group', true);
INSERT INTO students VALUES ('038f98be44628b5aec9a04c2ba885fe3', 'Bernardo Santini', 'kctest00202', '...', 'Default group', true);
INSERT INTO students VALUES ('8de7370d9fe799ea204497522989ac36', 'George Quebedo', 'kctest00213', '...', 'Default group', true);
INSERT INTO students VALUES ('6fe14c21dd22a23e71efb8f00150f0fb', 'Rob Shneider', 'kctest00208', '...', 'Default group', true);
INSERT INTO students VALUES ('3948ce479a8b58fc84168a4b0b1e977c', 'Terry Cruz', 'kctest00220', '...', 'Default group', false);
INSERT INTO students VALUES ('49e1492e48c9b387004eee5604ae90b3', 'David Smith', 'kctest00209', '...', 'Default group', true);


```

---

<h2>2. TROUBLESHOOTING</h2>

<h3>2.1. Check if the following libraries are allowed in PHP configuration:</h3>

You need to allow: `ext-json`, `ext-pdo` and `ext-openssl`

<h3>2.2. If an error occurs after a change to the code, try:</h2>

`php composer.phar dump-autoload`
