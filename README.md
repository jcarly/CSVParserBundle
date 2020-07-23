# CSVParserBundle

Installation

Place the directory in your src/
Add this line in the config/bundles.php
`App\CSVParserBundle\CSVParserBundle::class => ['all' => true],`

Install html2text
`composer require html2text/html2text`

To use the the command, do
`php bin/console CSVParser:parse <pathToTheCSVFile>`

You can add the `--json` option to render as JSON
