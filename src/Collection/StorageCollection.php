<?php

declare(strict_types=1);

namespace Ifrost\StorageApiBundle\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Ifrost\EntityStorage\Storage\EntityStorageInterface;

/**
 * @extends ArrayCollection<string,string>
 */
class StorageCollection extends ArrayCollection
{
    /**
     * @param array<string, mixed> $data
     */
    public function getStorage(
        string $storageClassName,
        array $data = []
    ): EntityStorageInterface {
        if (!$this->containsKey($storageClassName)) {
            throw new \RuntimeException(sprintf('Storage %s not exists.', $storageClassName));
        }

        return $storageClassName::createFromArray($data);
    }
}
