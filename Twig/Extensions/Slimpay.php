<?php

namespace SlimpayBundle\Twig\Extensions;

class Slimpay extends \Twig_Extension {

    protected $baseBrowserUri;

    public function __construct($baseBrowserUri) {
        $this->baseBrowserUri = $baseBrowserUri;
    }

    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('linkMandate', [$this, 'getMandateFromReference'],
                [
                    'needs_environment' => true,
                    'is_safe'           => ['html'  => true]
                ]
            )
        ];
    }

    public function getMandateFromReference(\Twig_Environment $environment, string $reference, $styleTab = ['width' => '70px']) {
        $toReturn = substr($reference, 4);
        $counter = 0;
        $referenceSplitted = str_split($reference);
        while ($referenceSplitted[$counter] == '0') {
            $counter++;
        }
        $toReturn = substr($toReturn, $counter);
        $link = $this->baseBrowserUri.'/client/manageMandate.html?mandateid='.$toReturn;
        $style = '';
        foreach ($styleTab as $rule => $value) {
            $style .= $rule.': '.$value.';';
        }
        return $environment->render('@Slimpay/link.html.twig', [
            'link'  => $link,
            'style' => $style
        ]);
    }

    public function getName() {
        return 'slimpay_twig_extension';
    }


}