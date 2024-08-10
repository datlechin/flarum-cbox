<?php

/*
 * This file is part of datlechin/flarum-cbox.
 *
 * Copyright (c) 2024 Ngo Quoc Dat.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Datlechin\FlarumCbox;

use Datlechin\FlarumCbox\Content\AddCboxIFrame;
use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->content(AddCboxIFrame::class),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),
];
