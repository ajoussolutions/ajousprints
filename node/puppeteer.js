/**
 * Puppeteer script run puppeteer, open url passed by commandline, render pdf and send it back to commandline and close script
 */
const puppeteer = require('puppeteer');

// Get command line arguments
const args = process.argv.slice(2);
const url = args[0];

(async () => {
    try {
        // Launch browser
        const browser = await puppeteer.launch({
            headless: 'new',
            args: ['--no-sandbox', '--disable-setuid-sandbox']
        });

        // Create new page
        const page = await browser.newPage();
        
        // Set a shorter timeout
        page.setDefaultNavigationTimeout(10000); // 10 seconds

        // Navigate to URL
        const response = await page.goto(url, {
            waitUntil: 'domcontentloaded'
        });

        // Check if page load was successful
        if (!response.ok()) {
            throw new Error(`Failed to load page: ${response.status()} ${response.statusText()}`);
        }

        // Generate PDF immediately after content is loaded
        const pdf = await page.pdf({
            format: 'A4',
            printBackground: true,
            margin: {
                top: '1cm',
                right: '1cm', 
                bottom: '1cm',
                left: '1cm'
            }
        });

        // Output base64 encoded PDF
        console.log(pdf.toString('base64'));

        await browser.close();
    } catch (error) {
        console.error(error);
        process.exit(1);
    }
})();



