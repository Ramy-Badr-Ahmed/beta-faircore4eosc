<?php

namespace App\Rules;

use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;

class CodeMetaIdentifier implements ValidationRule, ValidatorAwareRule
{
    protected Validator $validator;
    protected const DOI = 'DOI';

    protected const SWHID = 'SWHID';
    public string $idType;


    /**
     * @throws Exception
     */
    public function __construct(string $idType)
    {
        if(!in_array($idType, [self::SWHID, self::DOI])){
            throw new Exception('Non-supported identifier!');
        }
        $this->idType = strtoupper($idType);
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isMatching = match ($this->idType){
            self::DOI => preg_match('/https?:\/\/(dx\.)?doi\.org\/[a-zA-Z0-9.\/-]+/i', $value),
            self::SWHID => preg_match('/(?<=https:\/\/archive\.softwareheritage\.org\/).*$/i', $value)
        };
        if(!$isMatching){
            $fail(':attribute is incompatible with the selected Identifier Type: '.$this->idType);
        }
    }

    /**
     * @param Validator $validator
     * @return $this
     */
    public function setValidator(Validator $validator): static
    {
        $this->validator = $validator;

        return $this;
    }
}
