<?php

namespace App\Domain\Path;

class Path
{
    const FILE_TYPE = 'file';
    const DIRECTORY_TYPE = 'dir';

    private const ALLOWED_TYPES = [
        self::FILE_TYPE,
        self::DIRECTORY_TYPE
    ];

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var string */
    private $uri;

    /**
     * @throws PathTypeNotAllowedException
     */
    public function __construct(string $name, string $type, string $uri)
    {
        $this->name = $name;
        $this->setType($type);
        $this->uri = $uri;
    }

    /**
     * @throws PathTypeNotAllowedException
     */
    private function setType(string $type)
    {
        if(!in_array($type, self::ALLOWED_TYPES)) {
            throw new PathTypeNotAllowedException;
        }

        $this->type = $type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function nameWithoutExtension(): string
    {
        return pathinfo($this->name, PATHINFO_FILENAME);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function uri(): string
    {
        return $this->uri;
    }

}