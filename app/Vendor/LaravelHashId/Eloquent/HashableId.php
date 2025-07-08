<?php

namespace App\Vendor\LaravelHashId\Eloquent;

use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * @property int $hash_id
 * @property string $hash
 */
trait HashableId
{
    use \Veelasky\LaravelHashId\Eloquent\HashableId {
        \Veelasky\LaravelHashId\Eloquent\HashableId::getHashAttribute as protected getHashAttributeOriginal;
    }

    /** @var string */
    protected string $hashColumnName = 'hash_id';

    /** @var bool */
    protected bool $shouldHashPersist = true;

    /**
     * Trait initialize
     *
     * @return void
     */
    public function initializeHashableId(): void
    {
        $this->append('hash');
        $this->mergeFillable([$this->hashColumnName]);
    }
}
