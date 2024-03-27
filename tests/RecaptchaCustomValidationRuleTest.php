<?php

namespace Biscolab\ReCaptcha\Tests;

use Biscolab\ReCaptcha\Facades\ReCaptcha;
use Biscolab\ReCaptcha\ReCaptchaBuilder;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class RecaptchaCustomValidationRuleTest extends TestCase
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @test
     */
    public function testValidationRuleValidatesResponse()
    {
        ReCaptcha::shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $this->assertTrue($this->validator->passes());
    }

    /**
     * @test
     */
    public function testValidationRuleUsesTheDefaultErrorKey()
    {
        try {
            $this->failValidation();
        } catch (ValidationException $exception) {
            $this->assertEquals(
                'validation.' . ReCaptchaBuilder::DEFAULT_RECAPTCHA_RULE_NAME,
                $exception->getMessage()
            );
        }
    }

    /**
     * @test
     */
    public function testValidationRuleTranslatesTheErrorMessage()
    {
        Lang::addLines([
            'validation.' . ReCaptchaBuilder::DEFAULT_RECAPTCHA_RULE_NAME => 'Translated recaptcha error'
        ], $this->app->getLocale());

        try {
            $this->failValidation();
        } catch (ValidationException $exception) {
            $this->assertEquals(
                'Translated recaptcha error',
                $exception->getMessage()
            );
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = ValidatorFacade::make(
            [ReCaptchaBuilder::DEFAULT_RECAPTCHA_FIELD_NAME => 'test'],
            [ReCaptchaBuilder::DEFAULT_RECAPTCHA_FIELD_NAME => ReCaptchaBuilder::DEFAULT_RECAPTCHA_RULE_NAME]
        );
    }

    /**
     * @throws ValidationException
     */
    private function failValidation(): void
    {
        ReCaptcha::shouldReceive('validate')
            ->once()
            ->andReturn(false);

        $this->validator->validate();

        $this->fail('Expecting validation to throw an exception.');
    }
}
