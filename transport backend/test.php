<?php
require 'vendor/autoload.php'; // Load the Composer autoloader

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// Create a new PHPWord object
$phpWord = new PhpWord();

// Add a section to the Word document
$section = $phpWord->addSection();

// Add some text to the section
$section->addText('Hello, this is a sample Word document created with PHPWord!');

// Save the document to a .docx file
$filePath = 'sample_document.docx';
$phpWord->save($filePath, 'Word2007');

echo "Word document created successfully at: $filePath";
?>
