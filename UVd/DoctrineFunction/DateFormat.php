<?php
/*
 */
namespace UVd\DoctrineFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * Description of Hour
 *
 * @author Rob
 */
class DateFormat extends FunctionNode {

    protected $dateExpression;
    protected $formatChar;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'DATE_FORMAT(' .
                $sqlWalker->walkArithmeticExpression($this->dateExpression) .
                ','.
                $sqlWalker->walkStringPrimary($this->formatChar) .
                ')';

    }


    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        
        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

 
        $this->formatChar = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);


    }

}


