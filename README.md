# Very short description of the package

[comment]: <> ([![Latest Version on Packagist]&#40;https://img.shields.io/packagist/v/infinitypaul/cbs-php.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/infinitypaul/cbs-php&#41;)

[comment]: <> ([![Build Status]&#40;https://img.shields.io/travis/infinitypaul/cbs-php/master.svg?style=flat-square&#41;]&#40;https://travis-ci.org/infinitypaul/cbs-php&#41;)

[comment]: <> ([![Quality Score]&#40;https://img.shields.io/scrutinizer/g/infinitypaul/cbs-php.svg?style=flat-square&#41;]&#40;https://scrutinizer-ci.com/g/infinitypaul/cbs-php&#41;)

[comment]: <> ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/infinitypaul/cbs-php.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/infinitypaul/cbs-php&#41;)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require infinitypaul/cbs-php
```

## Usage

``` php
Infinitypaul\Cbs\Cbs::setup([
        'staging' => 'staging base url',
        'live' => 'live base url'],
        'Secrey Key',
        'Client ID', 'Mode =  staging or live');
        
     //To redirect to CBS Payment Gateway   
        \Infinitypaul\Cbs\CbsCall::addBody('RevenueHeadId', 1)
        ->addBody('TaxEntityInvoice', [
            'Amount' => 1000,
            "InvoiceDescription" => "talosopekope",
            "AdditionalDetails" => [],
            "CategoryId" => 1,
            "TaxEntity" => [
            'Recipient' => 'Tax Payer',
            'Email' => 'infinitypaul@live.com',
            'Address' => 'api Local',
            'PhoneNumber' => '0903636363',
            'TaxPayerIdentificationNumber' => '736363',
            'RCNumber' => null,
            'PayerId' => null
        ]])
        ->addBody('ExternalRefNumber', 373737373)
        ->addBody('RequestReference', 'jdjd783')
        ->addBody('CallBackURL', 'https://coeakwanga.edu.ng/controller/plugin/cbs/verify.php')
        ->getAuthorizationUrl()
        ->redirectNow();
        
        //Get Data
        \Infinitypaul\Cbs\CbsCall::addBody('RevenueHeadId', 1)
        ->addBody('TaxEntityInvoice', [
            'Amount' => 1000,
            "InvoiceDescription" => "talosopekope",
            "AdditionalDetails" => [],
            "CategoryId" => 1,
            "TaxEntity" => [
            'Recipient' => 'Tax Payer',
            'Email' => 'infinitypaul@live.com',
            'Address' => 'api Local',
            'PhoneNumber' => '0903636363',
            'TaxPayerIdentificationNumber' => '736363',
            'RCNumber' => null,
            'PayerId' => null
        ]])
        ->addBody('ExternalRefNumber', 373737373)
        ->addBody('RequestReference', 'jdjd783')
        ->addBody('CallBackURL', 'https://coeakwanga.edu.ng/controller/plugin/cbs/verify.php')
        ->getAuthorizationUrl()
        ->getData();
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email infinitypaul@live.com instead of using the issue tracker.

## Credits

- [Paul Edward](https://github.com/infinitypaul)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
