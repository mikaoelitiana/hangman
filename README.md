# Hangman
A Drupal module that adds a hangman game to your website.

![screenshot](./images/screenshot.png)

## Usage

- Download [latest release](https://github.com/mikaoelitiana/hangman/releases/latest)
- Unextract the compressed file and copy `hangman` forlder to `sites/all/modules` __OR__ upload the `.tar.gz` file directly in _Administration > Modules > Install new module_
- Enable module `Hangman Game` in _Administration > Modules_
- Go to URL `/hangman`


## Run with Docker

- Run `docker-compose up` in command-line from the module directory
- Go to [localhost](http://localhost:8080)
- Follow the installation process and use the following options:
  - __Database type:__ `PostgreSQL`
  - __Database name:__ `postgres`
  - __Database username:__ `postgres`
  - __Database password:__ `example`
  - __Database host:__ `postgres`
- Enable module `Hangman Game` in _Administration > Modules_
- Go to URL `/hangman`
