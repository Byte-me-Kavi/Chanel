<?php
// We don't need the Product model anymore for this approach
// require_once 'app/Models/Product.php'; 
// In app/Controllers/PageController.php

$products = [
    [
        'id' => 1,
        'name' => 'Bleu de Chanel',
        'price' => 165.00,
        'category' => 'Eau de Parfum',
        'image_url' => 'Website/img/Blue de chanel.webp'
    ],
    [
        'id' => 2,
        'name' => 'Chance Eau Tendre',
        'price' => 150.00,
        'category' => 'Eau de Toilette',
        'image_url' => '/Website/app/View/img/chance-eau-tendre.webp'
    ],
    [
        'id' => 3,
        'name' => 'Coco Mademoiselle', // Corrected typo from "manem"
        'price' => 175.00,
        'category' => 'Eau de Parfum',
        'image_url' => '/Website/app/View/img/coco-mademoiselle.webp'
    ],
    [
        'id' => 4,
        'name' => 'Coco Noir',
        'price' => 170.00,
        'category' => 'Eau de Parfum',
        'image_url' => '/Website/app/View/img/coco-noir.webp'
    ],
    [
        'id' => 5,
        'name' => 'Front Cover', // Placeholder name
        'price' => 155.00,
        'category' => 'Special Edition',
        'image_url' => '/Website/app/View/img/front-cover.webp'
    ],
    [
        'id' => 6,
        'name' => 'Gabrielle Chanel',
        'price' => 185.00,
        'category' => 'Essence',
        'image_url' => '/Website/app/View/img/gabrielle-chanel.webp'
    ],
    [
        'id' => 7,
        'name' => 'N°5',
        'price' => 180.00,
        'category' => 'Eau de Parfum',
        'image_url' => '/Website/app/View/img/n05.webp'
    ]
];

