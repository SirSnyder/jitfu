--TEST--
Test builder ge
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

$long = new Type(JIT_TYPE_LONG);

/* long function(long x, long y); */
$sig      = new Signature($long, [$long, $long]);

$function = new Func($context, $sig);

$x       = $function->getParameter(0);
$y       = $function->getParameter(1);

$builder = new Builder($function);

/* return $x >= $y; */
$builder->doReturn(
	$builder->doGe($x, $y));

$function->compile();

var_dump(
	(bool) $function(1, 1),
	(bool) $function(1, 2),
	(bool) $function(3, 1));
?>
--EXPECT--
bool(true)
bool(false)
bool(true)
