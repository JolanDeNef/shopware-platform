<?php declare(strict_types=1);

namespace SwagCustomRule\Core\Rule;

use Shopware\Core\Content\Rule\Exception\UnsupportedOperatorException;
use Shopware\Core\Framework\Rule\Match;
use Shopware\Core\Framework\Rule\Rule;
use Shopware\Core\Framework\Rule\RuleScope;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class Count42Rule extends Rule
{
    /**
     * @var string
     */
    protected $operator;

    /**
     * @var int
     */
    protected $count;

    public function __construct()
    {
        $this->operator = self::OPERATOR_EQ;
    }

    public function match(RuleScope $scope): Match
    {
        switch ($this->operator) {
            case self::OPERATOR_EQ:
                return new Match($this->count === 42, ['The count not equals 42']);
            case self::OPERATOR_NEQ:
                return new Match($this->count !== 42, ['The count equals 42']);
            default:
                throw new UnsupportedOperatorException($this->operator, __CLASS__);
        }
    }

    public function getConstraints(): array
    {
        return [
            'operator' => [new Choice([self::OPERATOR_EQ, self::OPERATOR_NEQ])],
            'count' => [new NotBlank(), new Type('int')],
        ];
    }

    public function getName(): string
    {
        return 'swagCount42';
    }
}
