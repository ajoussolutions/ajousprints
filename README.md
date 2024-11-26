# AjousPrints for Dolibarr

## Description

AjousPrints is a Dolibarr module that enables advanced PDF generation using Gotenberg and HTML templates. It specializes in creating dynamic PDFs with support for barcodes, custom layouts, and JavaScript-powered content. The module is particularly useful for generating product labels, custom documents, and reports that require complex formatting or dynamic elements.

## Features

- HTML-based template system with Handlebars.js support
- Barcode generation using JsBarcode
- Custom paper sizes and margins
- Dynamic content rendering
- Automatic temp file cleanup
- Built-in Dymo label generator for products
- Support for custom document templates

## Prerequisites

- Dolibarr >= 16.0
- PHP >= 7.4
- Gotenberg server instance
- Web-accessible temp directory for HTML files

## Installation

1. Download the module ZIP file
2. Extract to your Dolibarr's custom directory: `dolibarr/custom/ajousprints`
3. Go to Home > Setup > Modules
4. Find and enable "AjousPrints" module
5. Configure the required settings

## Configuration

1. Navigate to Home > Setup > Modules > AjousPrints setup
2. Configure these required settings:
   - Gotenberg URL (e.g., `https://gotenberg:3000`)
   - Temp HTML Base URL (must be accessible by Gotenberg)

## Usage

### Built-in Document Types

#### 1. Product Labels (Dymo)
- Go to any product card
- Click "Generate Document"
- Select "Dymo" format
- PDF will be generated with product info and barcode
- Default size: 80mm x 30mm

#### 2. Commercial Proposals
- Go to any proposal
- Click "Generate Document"
- Select "Propale1" format
- PDF will be generated with proposal data
- Default size: A4

### Creating Custom Templates

1. Create a new HTML template file in `/templates`:
```html
<body>
    <style>
        body {
            font-size: 10pt;
            font-family: Arial, sans-serif;
            width: 100%;
            text-align: center;
        }
    </style>
    
    <!-- Use Handlebars syntax for data -->
    {{myobject.field}}
    
    <!-- Barcode example -->
    <svg class="barcode" 
         jsbarcode-value="{{myobject.barcode}}"
         jsbarcode-format="auto"
         jsbarcode-textmargin="0"
         jsbarcode-height="40"
         jsbarcode-width="2"
         jsbarcode-fontsize="10">
    </svg>
</body>
```

2. Create a PDF generator class:
```php
require_once DOL_DOCUMENT_ROOT.'/custom/ajousprints/functions/utils.php';

class pdf_MyTemplate extends CommonDocGenerator
{
    public function write_file($object, $outputlangs)
    {
        $data = new stdClass();
        $data->myobject = $object;
        
        $path = $conf->mymodule->dir_output.'/'.$object->ref.'.pdf';
        return savePdf($data, 'mytemplate', $path, [
            'paperWidth' => "210mm",
            'paperHeight' => "297mm",
            'marginTop' => 0,
            'marginBottom' => 0,
            'marginLeft' => 0,
            'marginRight' => 0
        ]);
    }
}
```

### API Usage

For direct PDF generation from your code:
```php
require_once DOL_DOCUMENT_ROOT.'/custom/ajousprints/functions/utils.php';

$data = new stdClass();
$data->someProperty = 'value';

$result = savePdf(
    $data,                    // Data object
    'template_name',          // Template name
    '/path/to/output.pdf',    // Output path
    [                         // Optional parameters
        'paperWidth' => "210mm",
        'paperHeight' => "297mm",
        'marginTop' => 0,
        'marginBottom' => 0
    ]
);
```

## Template System

### Structure
Templates are composed of three parts:

1. **Header** (base/header.html)
   - Contains required JS libraries
   - Defines basic HTML structure
   - Includes Handlebars and JsBarcode

2. **Content** (your template)
   - Contains your HTML/CSS
   - Uses Handlebars syntax for data
   - Can include barcodes and styling

3. **Footer** (base/footer.html)
   - Handles rendering logic
   - Initializes barcodes
   - Manages page ready state

### Available JavaScript Libraries

#### Handlebars.js
- Template syntax: `{{variable}}`
- Supports expressions and helpers
- Used for dynamic content

#### JsBarcode
- Multiple barcode formats
- Customizable dimensions
- Auto-format detection

### Template Data
Data is passed to templates as a JavaScript object:
- Product templates: `{{product.field}}`
- Proposal templates: `{{propale.field}}`
- Custom templates: `{{your_object.field}}`

### Barcode Configuration
```html
<svg class="barcode"
    jsbarcode-format="auto"      <!-- or specific format -->
    jsbarcode-value="value"      <!-- barcode content -->
    jsbarcode-height="40"        <!-- height in px -->
    jsbarcode-width="2"          <!-- bar width -->
    jsbarcode-fontsize="10"      <!-- text size -->
    jsbarcode-textmargin="0">    <!-- margin below bars -->
</svg>
```

## File Structure

```
ajousprints/
├── admin/
│   ├── setup.php           # Module configuration
│   └── about.php           # Module information
├── core/
│   └── modules/
│       ├── product/
│       │   └── pdf_Dymo.modules.php
│       └── propale/
│           └── pdf_Propale1.modules.php
├── templates/
│   ├── base/
│   │   ├── header.html
│   │   └── footer.html
│   ├── dymo.html
│   └── propale.html
├── temp/
│   └── assets/
│       └── js/
├── functions/
│   └── utils.php
└── README.md
```

## Support

- GitHub Issues: [Repository URL]
- Email: support@example.com
- Documentation: [Wiki URL]

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

GPLv3 or later

## Changelog

### 1.0.0
- Initial release
- Dymo label support
- Commercial proposal template
- Basic template system

## Credits

- Dolibarr ERP & CRM
- Gotenberg
- JsBarcode
- Handlebars.js