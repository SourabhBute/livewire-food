<?php

return [

    "environment" => "test",

    "endpoints"=> [
        'live' => [
            'paymentWidgets' => 'https://eu-prod.oppwa.com/v1/paymentWidgets.js?checkoutId=',
            'checkouts' => 'https://eu-prod.oppwa.com/v1/checkouts',
            'url' => 'https://eu-prod.oppwa.com/v1/'
        ],
        'test' => [
            'paymentWidgets' => 'https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId=',
            'checkouts' => 'https://eu-test.oppwa.com/v1/checkouts',
            'url' => 'https://eu-test.oppwa.com/v1/'
        ],
    ],

    "gatewayes" => [
        "card" => [
            "enabled" => true,
            'entity_id' => "8ac7a4ca827f7dfb01828109d77318d1",
            "access_token" => "OGFjN2E0Y2E4MjdmN2RmYjAxODI4MTA4ZDBhMDE4Y2R8czdlUWR0TjU5aA==",
            "currency" => "SAR",
            "transaction_type" => "DB",
            "brands" => "VISA MASTER AMEX",
            "label" => "Cridet Card",
        ],

        "mada" => [
            "enabled" => false,
            'entity_id' => "8ac7a4c7827f7bc10182810bcea318e8",
            "access_token" => "OGFjN2E0Y2E4MjdmN2RmYjAxODI4MTA4ZDBhMDE4Y2R8czdlUWR0TjU5aA==",
            "currency" => "SAR",
            "transaction_type" => "DB",
            "brands" => "MADA",
            "label" => "Mada Debit Card",
        ],
    ]
];
