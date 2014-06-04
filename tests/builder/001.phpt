--TEST--
Test builder object basic
--SKIPIF--
<?php if (!extension_loaded("jitfu")) die("skip JITFu not loaded"); ?>
--FILE--
<?php
use JITFu\Context;
use JITFu\Type;
use JITFu\Signature;
use JITFu\Func;
use JITFu\Builder;

$context = new Context();
$context->start();

$long      = new Type(JIT_TYPE_LONG);

/* long function(long n); */
$sig      = new Signature($long, [$long]);

$function = new Func($context, $sig);

$builder = new Builder($function);

/* return n; */
$builder->doReturn(
	$function->getParameter(0));

$function->compile();

var_dump(
	$function(10), 
	$function(20), 
	$function(30));
?>
--EXPECT--
int(10)
int(20)
int(30)