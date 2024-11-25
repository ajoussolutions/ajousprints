# AjousPrints for Dolibarr ERP & CRM

## Description

AjousPrints is a Dolibarr module that enables PDF generation using Puppeteer. It allows rendering HTML templates to PDFs with full JavaScript support.

## Key Features

- Modern PDF generation with Chrome/Puppeteer
- Support for complex HTML/CSS/JavaScript layouts
- Flexible template system
- Asynchronous processing
- Error handling and logging
- Caching mechanism for optimized performance

## Installation

### Prerequisites

- Dolibarr ERP & CRM >= 16.0
- Node.js >= 14.0
- Puppeteer
- PHP >= 7.4

### Installation Steps

1. Download module as ZIP
2. Install in Dolibarr under "Home > Setup > Module"
3. Install Node.js dependencies:
```bash
cd custom/ajousprints
npm install
```

### Configuration

1. Navigate to module setup in Dolibarr
2. Configure Puppeteer path
3. Set template directory
4. Adjust cache settings (optional)

## Usage

### Generate PDF
```php
require_once DOL_DOCUMENT_ROOT.'/custom/ajousprints/class/puppeteerinterface.class.php';

$generator = new PuppeteerInterface();
$pdf = $generator->generatePDF($html, $options);
```

### Use Template
```php
$template = new AjousPrintsTemplate('invoice');
$pdf = $template->render([
    'company' => $company,
    'invoice' => $invoice
]);
```

## Development

- Templates are located in `/templates`
- Puppeteer scripts in `/scripts` 
- PHP classes in `/class`

## License

GPLv3 or later

## Support

- Issues on GitHub
- Forum: [Dolibarr Forum](https://www.dolibarr.org/forum)
- Email: support@example.com
