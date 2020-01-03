<?php


namespace monktan\libraries;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use monktan\framework\App;
use Ramsey\Uuid\Uuid;

class Captcha
{
    public static function generate()
    {
        $phraseBuilder = new PhraseBuilder(4);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build();
        $phrase = $builder->getPhrase();
        $phraseUuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, bin2hex(random_bytes(18)))->toString();
        $phraseUuid = str_replace('-', '', $phraseUuid);
        //保存到redis中
        App::cache()->setex($phraseUuid, 300, $phrase);
        header("Captcha-Uuid: {$phraseUuid}");

        return $builder->inline();
    }

    public static function check($captcha, $uuid)
    {
        $cache = App::cache();
        if (! $cache->exists($uuid)) {
            return false;
        }

        $result = ($cache->get($uuid) == $captcha);
        $cache->delete($uuid);

        return $result;
    }
}
