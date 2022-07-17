<?php
    namespace App\Twig\Extension;
    use Twig\Extension\AbstractExtension;
    use Twig\TwigFunction;


    class UniqueIdExtension extends AbstractExtension{
        public function getFunctions()
        {
            new TwigFunction('uniqueid',function (string $prefix, bool $advanced=false){
                    return uniqid($prefix,$advanced);
            });
        }
    }
