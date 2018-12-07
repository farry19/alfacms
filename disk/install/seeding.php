<?php

seed('options', [
        'name' => 'My name',
        'value' => serialize([
            'id' => 1, 'name' => 'item-1', 'price' => 100.0
        ]),
    ]
);

redirect('/');