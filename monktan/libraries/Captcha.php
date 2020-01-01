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
        $phraseUuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'monktan');

        //保存到redis中
        App::cache()->set($phraseUuid, $phrase, 300);
        header("Captcha-Uuid: {$phraseUuid}");

        return $builder->inline();
    }

    public static function check($captcha, $uuid)
    {
        $cache = App::cache();
        $result = false;
        if ($cache->exists($uuid) && $cache->get($uuid) == $captcha) {
            $result = true;
        }
        return $result;
    }
}