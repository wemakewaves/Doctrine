<?php

namespace UVd\DoctrineFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * DateFormat
 * 
 * Allows Doctrine 2.0 Query Language to execute a MySQL DATE_FORMAT function
 * You must boostrap this function in your ORM as a DQLFunction.
 * 
 * 
 * DATE_FORMAT(TIMESTAMP,'%format') : @link http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_date-format
 * 
 * 
 * PLEASE REMEMBER TO CHECK YOUR NAMESPACE
 * 
 * @link labs.ultravioletdesign.co.uk
 * @author Rob Squires <rob@ultravioletdesign.co.uk>
 * 
 * 
 */
class DateFormat extends FunctionNode {

    /*
     * holds the timestamp of the DATE_FORMAT DQL statement
     * @var mixed
     */
    protected $dateExpression;
    
    /**
     * holds the '%format' parameter of the DATE_FORMAT DQL statement
     * @var string
     */
    protected $formatChar;

    /**
     * getSql - allows ORM  to inject a DATE_FORMAT() statement into an SQL string being constructed
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return void 
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'DATE_FORMAT(' .
                $sqlWalker->walkArithmeticExpression($this->dateExpression) .
                ','.
                $sqlWalker->walkStringPrimary($this->formatChar) .
                ')';

    }

    /**
     * parse - allows DQL to breakdown the DQL string into a processable structure
     * @param \Doctrine\ORM\Query\Parser $parser 
     */
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


