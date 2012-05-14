<?php

namespace UVd\DoctrineFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * UnixTimestamp
 * 
 * Allows Doctrine 2.0 Query Language to execute a MySQL UNIX_FORMAT function
 * You must boostrap this function in your ORM as a DQLFunction.
 * 
 * 
 * UNIX_TIMESTAMP(TIMESTAMP) : @link http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_unix-timestamp
 * 
 * 
 * PLEASE REMEMBER TO CHECK YOUR NAMESPACE
 * 
 * @link labs.ultravioletdesign.co.uk
 * @author Rob Squires <rob@ultravioletdesign.co.uk>
 * 
 * 
 */
class UnixTimestamp extends FunctionNode {

    /*
     * holds the timestamp of the UNIX_TIMESTAMP DQL statement
     * @var mixed
     */
    protected $dateExpression;
    


    /**
     * getSql - allows ORM  to inject a UNIX_TIMESTAMP() statement into an SQL string being constructed
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return void 
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'UNIX_TIMESTAMP(' .
                $sqlWalker->walkArithmeticExpression($this->dateExpression) .
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

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);


    }

}


