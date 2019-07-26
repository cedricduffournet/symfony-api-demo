# Symfony 4 rest demo

Demo rest api with symfony 4

[![Build Status](https://travis-ci.com/cedricduffournet/symfony-api-demo.svg?branch=master)](https://travis-ci.com/cedricduffournet/symfony-api-demo)
[![StyleCI](https://github.styleci.io/repos/198994053/shield?branch=master)](https://github.styleci.io/repos/198994053)
[![SymfonyInsight](https://insight.symfony.com/projects/607becbe-200a-4952-96ba-deb1d20e3856/mini.svg)](https://insight.symfony.com/projects/607becbe-200a-4952-96ba-deb1d20e3856)

## Installation

1: Clone repository

```bash
git clone https://github.com/cedricduffournet/symfony-api-demo.git
```

2: Build dev docker image

```bash
make dev
```

3: Create database

```bash
make database-create
```

4: Load fixtures

```bash
make fixtures
```

5: Create oauth api key

```bash
make oauth2-key
```

## API documentation

Navigate to

```bash
http://127.0.0.1:81
```

use login : `superadmin@dev.com` / pwd : `superadminpwd` to get access token

## Testing (behat)

1: Build test docker image

```bash
make test
```

2: Execute behat scenarios

```bash
make behat
```
