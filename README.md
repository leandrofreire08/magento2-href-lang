# Magento 2 Module Freire_HrefLang

## Functionalities

* CMS Page component to add hreflang meta to handle different store languages for SEO enginee.
* If page belongs to only one store the meta hreflang will be ommited.
* "X-default" is a special value of the hreflang attribute that shows which page your online shoppers must be directed to if none of the languages in hreflang tags conform to their browser settings. In other words, if the customers’ location and the language don’t correspond the settings, they get redirected to your eCommerce store version set as default.

## Usage

### Installation

Install this module into Magento 2 via composer:

    composer require leandrofreire08/magento2-href-lang
    bin/magento module:enable Freire_HrefLang
    bin/magento setup:upgrade

### Uninstall

    bin/magento module:uninstall Freire_HrefLang

## Demo

![](https://github.com/leandrofreire08/magento2-href-lang/blob/master/screenshots/demo.gif)

## Author

Leandro Freire
