<?php

declare(strict_types=1);

namespace DocAxess\Apify\User\Data\Proxy;

readonly class Proxy
{
    /**
     * @param  Group[]  $groups
     */
    public function __construct(
        public string $password,
        public array $groups
    ) {
        // assert groups contains only Group instances
        foreach ($groups as $group) {
            assert($group instanceof Group, 'Group must be an instance of Group');
        }
    }

    /**
     * @param  array<string, mixed>  $state
     */
    public static function make(array $state): self
    {
        return new self(
            password: $state['password'],
            groups: array_map(fn (array $group) => Group::make($group), $state['groups'])
        );
    }

    public function url(?string $groupName = null): string
    {
        return sprintf('http://%s:%s@proxy.apify.com:8000', $this->getGroupName($groupName), $this->password);
    }

    private function getGroupName(?string $name = null): string
    {
        $group = array_values(array_filter($this->groups, fn (Group $g) => $g->name === $name));

        return ! empty($group) ? $group[0]->name : 'auto';
    }
}
