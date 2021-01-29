# Magento 2 Module Freire_HrefLang

## Functionalities

* CMS Page component to add hreflang meta to handle different store languages for SEO enginee.
* If CMS page belongs to only one store the meta hreflang will be ommited.
* Enable/Disable module
* Logic to add href-tag on stores that belong ONLY to the same website    
* "X-default" href-lang is customizable under Store -> Configuration -> Freire.

## Usage

### Installation

Install this module into Magento 2 via composer:

    git clone https://github.com/leandrofreire08/magento2-href-lang.git app/code/Freire/HrefLang
    bin/magento module:enable Freire_HrefLang
    bin/magento setup:upgrade

### Uninstall

    bin/magento module:uninstall Freire_HrefLang

## Author

Leandro Freire
