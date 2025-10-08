<?php

return [
    'secret' => env('NOCAPTCHA_SECRET','6LcfcRopAAAAAJanl6GHV6qhxDC2jnJjGXwPfjBm'),
    'sitekey' => env('NOCAPTCHA_SITEKEY','6LcfcRopAAAAAEKbTW7y_DDRf30SkltvrbQ5qpWp'),
    'options' => [
        'timeout' => 30,
    ],
];
