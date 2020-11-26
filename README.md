# PHPStan extension for bonami/collections
![Build Status](https://github.com/bonami/phpstan-collections/workflows/CI/badge.svg)
[![Latest Stable Version](https://poser.pugx.org/bonami/phpstan-collections/v/stable)](https://packagist.org/packages/bonami/phpstan-collections)
[![License](https://poser.pugx.org/bonami/phpstan-collections/license)](https://github.com/bonami/phpstan-collections/blob/master/LICENSE)

## Table of contents

- [Installation](#installation)
- [License](#features)
- [Contributing](#features)

## Installation

To use this extension, require it in Composer:

```bash
composer require --dev bonami/phpstan-collections
``` 

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include `extension.neon` in your project's PHPStan config:

```
includes:
    - vendor/bonami/phpstan-collections/extension.neon
```
</details>

## License

This package is released under the [MIT license](LICENSE).

## Contributing

If you wish to contribute to the project, please read the [CONTRIBUTING notes](CONTRIBUTING.md).
