<?php

$EM_CONF[$_EXTKEY] = [
  'title' => 'Plain PHP based Data Display (Data Consumer) - Tesseract project',
  'description' => 'Use Plain PHP templates to display any kind of data returned by a Data Provider. More info on http://www.typo3-tesseract.com',
  'category' => 'fe',
  'author' => 'Fabien Udriot',
  'author_email' => 'fabien.udriot@ecodev.ch',
  'shy' => '',
  'state' => 'stable',
  'version' => '1.4.0',
  'constraints' =>
  [
    'depends' =>
    [
      'typo3' => '4.5.0-6.2.99',
      'tesseract' => '1.7.0-0.0.0',
    ],
    'conflicts' =>
    [
    ],
    'suggests' =>
    [
    ],
  ],
];
