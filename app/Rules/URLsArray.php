<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Support\Arr;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;

class URLsArray implements ValidationRule, ValidatorAwareRule
{
    protected Validator $validator;
    protected array $failedURLs = [];
    protected array $failedMsgs = [];

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $array = explode(',', str_replace("\n", "," , $value));

        $array = Arr::where($array, fn($val)=>!empty($val));

        foreach ($array as $idx => $url){

            $url = trim($url);

            if(empty($url)) continue;

            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->failedURLs[] = $url;
                $this->failedMsgs [] = "Entry # ".($idx+1)." is a non-valid URL";
            }
        }
        if(!empty($this->failedMsgs)){
            $this->validator->errors()->add($attribute, implode('--', $this->failedMsgs ));
        }
    }

    /**
     * Set the current validator.
     */

    public function setValidator(Validator $validator): static
    {
        $this->validator = $validator;

        return $this;
    }

}
