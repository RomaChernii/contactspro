# M2 ContactsPro

Magento 2 module to improve the standard contact us form

### Installation

Run the following commands:

```bash
cd <magento_root>
composer config repositories.peterchmeruk/contacts-pro vcs git@github.com:peterchmeruk/contactspro.git
composer require peterchmeruk/contacts-pro:dev-master --prefer-source
bin/magento module:enable Smile_ContactsPro
bin/magento setup:upgrade
```

#### Recommended Magento Version 2.1.x