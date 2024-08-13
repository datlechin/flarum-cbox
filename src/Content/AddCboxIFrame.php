<?php

namespace Datlechin\FlarumCbox\Content;

use Datlechin\FlarumCbox\Util\Color;
use Flarum\Frontend\Document;
use Flarum\Http\RequestUtil;
use Flarum\Http\UrlGenerator;
use Flarum\Settings\SettingsRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class AddCboxIFrame
{
    public function __construct(
        protected SettingsRepositoryInterface $setting,
        protected UrlGenerator $url
    ) {
    }

    public function __invoke(Document $document, ServerRequestInterface $request): void
    {
        $actor = RequestUtil::getActor($request);

        if (
            ! $this->setting->get('datlechin-cbox.show_when_user_not_login')
            && ! $actor->exists
        ) {
            return;
        }

        $secret = $this->setting->get('datlechin-cbox.secret');
        $boxid = $this->setting->get('datlechin-cbox.box_id');
        $boxtag = $this->setting->get('datlechin-cbox.box_tag');

        if (! $secret || ! $boxid || ! $boxtag) {
            return;
        }

        $params = [
            'boxid' => $boxid,
            'boxtag' => $boxtag,
        ];

        if ($actor->exists) {
            $color = Color::stringToColor($actor->display_name);

            $slug = $this->setting->get('slug_driver_Flarum\User\User') === 'default' ? 'username' : 'id';

            $params = [
                ...$params,
                'nme' => $actor->display_name,
                'lnk' => $this->url->to('forum')->route('user', ['username' => $actor->$slug]),
                'pic' => $actor->avatar_url ?? "https://ui-avatars.com/api/?background=$color&color=fff&name=D",
            ];
        }

        $queryParams = [];

        foreach ($params as $key => $value) {
            if (! $value) {
                continue;
            }

            $queryParams[] = $key . '=' . urlencode($value);
        }

        $path = '/box/?' . implode('&', $queryParams);
        $sig = urlencode(base64_encode(hash_hmac('sha256', $path, $secret, true)));
        $url = sprintf('https://www5.cbox.ws%s&sig=%s', $path, $sig);

        $html = <<<HMTL
            <script>
                window['CboxReady'] = function (Cbox) {
                    Cbox('button', '5');

                    var iframe = document.querySelector('iframe[src*="cbox.ws"]');
                    if (iframe) {
                        iframe.src = "$url";
                    }
                }
            </script>
            <script src="https://static.cbox.ws/embed/2.js" async></script>
        HMTL;

        $document->head[] = $html;
    }
}
