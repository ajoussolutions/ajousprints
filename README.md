# AjousPrints for Dolibarr ERP & CRM

## Description

AjousPrints is a Dolibarr module that enables PDF generation using Gotenberg. It allows rendering HTML templates to PDFs with full JavaScript support through Chrome/Chromium.

## Key Features

- Modern PDF generation with Gotenberg/Chrome
- Support for complex HTML/CSS/JavaScript layouts
- Flexible template system
- Simple API integration
- Error handling and logging
- Automatic temp file cleanup

## Installation

### Prerequisites

- Dolibarr ERP & CRM >= 16.0
- PHP >= 7.4
- Gotenberg server instance
- Web-accessible temp directory

### Installation Steps

1. Download module as ZIP
2. Install in Dolibarr under "Home > Setup > Module"
3. Configure Gotenberg URL and temp directory in module settings

### Configuration

1. Navigate to module setup in Dolibarr
2. Set Gotenberg server URL (e.g., https://gotenberg:3000)
3. Configure temp HTML base URL (must be accessible by Gotenberg)

## Usage

### Generate PDF
```php
require_once DOL_DOCUMENT_ROOT.'/custom/ajousprints/functions/utils.php';

// Prepare your data
$data = new stdClass();
$data->someProperty = 'value';

// Generate PDF
$result = savePdf($data, 'template_name', '/path/to/output.pdf');
```

### Create Template
1. Create HTML template in `/templates` directory
2. Use `{data}` placeholder to access your data object
3. Templates can include JavaScript for dynamic content

### Template Example
```html
<div id="content">
    <h1>{{data.title}}</h1>
    <p>{{data.description}}</p>
</div>
<script>
    // Access data through the injected data object
    const data = JSON.parse('{data}');
    // Manipulate DOM as needed
</script>
```

## Development

- Templates are located in `/templates`
- Base template parts in `/templates/base`
- Utility functions in `/functions`

## License

GPLv3 or later

## Support

- Issues on GitHub
- Forum: [Dolibarr Forum](https://www.dolibarr.org/forum)
- Email: support@example.com
