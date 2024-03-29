<?php
namespace Peast\test\Syntax;

class ScannerTest extends \Peast\test\TestBase
{
    public function testSourceEncodingConversion()
    {
        if (function_exists("mb_convert_encoding")) {
            $UTF8Char = chr(0xc2) . chr(0xb0);
            $encoding = "UTF-16BE";
            $source = mb_convert_encoding("'$UTF8Char'", $encoding, "UTF-8");
            $options = array("sourceEncoding" => $encoding);
            $tree = \Peast\Peast::latest($source, $options)->parse();
            $str = $tree->getBody()[0]->getExpression()->getValue();
            $this->assertEquals($UTF8Char, $str);
        }
    }
    
    /**
     * @expectedException \Peast\Syntax\EncodingException
     */
    public function testExceptionOnInvalidUTF8()
    {
        $UTF8Char = chr(0xc2) . chr(0xb0);
        $source = "'" . $UTF8Char . $UTF8Char[0] . "'";
        \Peast\Peast::latest($source)->parse();
    }
    
    public function testHandleInvalidUTF8UsingStrictEncodingOpt()
    {
        if (function_exists("mb_convert_encoding")) {
            $UTF8Char = chr(0xc2) . chr(0xb0);
            $source = "'" . $UTF8Char . $UTF8Char[0] . "'";
            $options = array("strictEncoding" => false);
            $tree = \Peast\Peast::latest($source, $options)->parse();
            $str = $tree->getBody()[0]->getExpression()->getValue();
            $this->assertTrue(strpos($str, $UTF8Char) !== false);
        }
    }
}