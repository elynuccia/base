<?php
namespace App\Utility;

use Symfony\Component\Translation\TranslatorInterface;

class EffectSizeChecker {

    private $translator;
    
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getResultMessage($analysesValue)
    {
        switch($analysesValue->outMonte) {
            case 'AvsB+trendB-trendA':
                $analysisValue = $analysesValue->TAU_U_Analysis[10]->AvsBTrendBTrendA;
                break;

            case 'AvsB+trendB':
                $analysisValue = $analysesValue->TAU_U_Analysis[10]->AvsBTrendB;
                break;

            case 'AvsB':
                $analysisValue = $analysesValue->PartitionsOfMatrix[10]->AvsB;
                break;

            case 'Allison & Gorman':
                $analysisValue = $analysesValue->R->value;
                break;
        }

        $sign = ($analysisValue > 0) ? 'increase' : 'decrease';

        if ($this->hasTauNotEffect($analysisValue)) {
            return 'The treatment doesn\'t have effect on the behaviour occurrence';
        }

        if ($this->hasTauSmallEffect($analysisValue)) {
            $small = 'small';
            $message = sprintf('The treatment has a %s effect on the %s of the behaviour occurrence', $small, $sign);

            return $message;
        }

        if ($this->hasTauMediumEffect($analysisValue)) {
            $small = 'medium';
            $message = sprintf('The treatment has a %s effect on the %s of the behaviour occurrence', $small, $sign);

            return $message;
        }

        if ($this->hasTauLargeEffect($analysisValue)) {
            $small = 'large';
            $message = sprintf('The treatment has a %s effect on the %s of the behaviour occurrence', $small, $sign);

            return $message;
        }
    }

    private function hasTauNotEffect($analysisValue)
    {
        return ($analysisValue <= 0.1 && $analysisValue >= -0.1) ? true : false;
    }

    private function hasTauSmallEffect($analysisValue)
    {
        $analysisValue = abs($analysisValue);

        return ($analysisValue >= 0.1 && $analysisValue <= 0.3) ? true : false;
    }

    private function hasTauMediumEffect($analysisValue)
    {
        $analysisValue = abs($analysisValue);

        return ($analysisValue >= 0.3 && $analysisValue <= 0.5) ? true : false;
    }

    private function hasTauLargeEffect($analysisValue)
    {
        $analysisValue = abs($analysisValue);

        return ($analysisValue >= 0.5) ? true : false;
    }

} 
