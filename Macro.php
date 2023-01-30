<?php
/**
.---------------------------------------------------------------------------.
|  trait Macro                                                              |
|   Version: 1.0 dev                                                        |
|      Date: 2023-01-30                                                     |
| ------------------------------------------------------------------------- |
| Copyright © 2023 jspit                                                    |
' ------------------------------------------------------------------------- '
|  PHP Macro - Dynamically extend PHP objects                               |
|  PHP >= 7.0  , 8.2                                                        |
' ------------------------------------------------------------------------- '
*/
trait Macro {

    protected static $macros = [];

    /**
     * Register a custom macro.
     *
     * @example
     * ```
     * Dt::macro('formatHi',function(){return $this->format('H:i');});
     * echo Dt::create()->formatHi();
     * ```
     *
     * @param string   $name
     * @param callable $macro
     *
     * @return void
     */
    public static function macro($macroArr, $fct = null)
    { 
        if(!is_array($macroArr)){
        $macroArr = [$macroArr => $fct];
        }
        foreach($macroArr as $macro){
        if(! $macro instanceof \Closure)
            throw new \InvalidArgumentException('A Parameter for '.__METHOD__.' is not a closure'); 
        }
        static::$macros = array_merge(static::$macros,$macroArr);
    }

    /**
	 * Checks if macro is registered
	 *
	 * @param  string    $name
	 * @return boolean
	 */
	public static function hasMacro($name)
	{
		return array_key_exists($name, static::$macros);
	}

	/**
	 * Dynamically handle calls to the class.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 *
	 * @throws \LogicException
	 */
    public function __call($method, $parameters)
    {
        if(array_key_exists($method,self::$macros)) {
            $fct = self::$macros[$method];
            $boundMacro = @$fct->bindTo($this, static::class);
            return ($boundMacro ?: $fct)(...$parameters);
        }
        throw new \LogicException("Method '$method' not exist");
    }

	/**
	 * handle static calls to the class.
	 *
	 * @param  string  $method
	 * @param  array   $parameters
	 * @return mixed
	 *
	 * @throws \LogicException
	 */
    public static function __callStatic($method, $parameters)
    {
        if(array_key_exists($method,self::$macros)) {
            $fct = self::$macros[$method];
            $boundMacro = @$fct->bindTo(null, static::class);
            return ($boundMacro ?: $fct)(...$parameters);
        }
        throw new \LogicException("Method '$method' not exist");
    }

}