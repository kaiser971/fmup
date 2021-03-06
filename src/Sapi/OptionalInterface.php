<?php
namespace FMUP\Sapi;

use FMUP\Sapi;

interface OptionalInterface
{
    /**
     * Define Sapi
     * @param Sapi|null $sapi
     * @return $this
     */
    public function setSapi(Sapi $sapi = null);

    /**
     * @return Sapi
     */
    public function getSapi();

    /**
     * Checks whether sapi is defined
     * @return bool
     */
    public function hasSapi();
}
