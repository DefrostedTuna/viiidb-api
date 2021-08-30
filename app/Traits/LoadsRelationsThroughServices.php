<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait LoadsRelationsThroughServices
{
    /**
     * Get the relations that are available to include with the resource.
     *
     * @return array
     */
    public function getAvailableIncludes(): array
    {
        return isset($this->availableIncludes) ? $this->availableIncludes : [];
    }

    /**
     * Get the default relations to include with the resource.
     *
     * @return array
     */
    public function getDefaultIncludes(): array
    {
        return isset($this->defaultIncludes) ? $this->defaultIncludes : [];
    }

    /**
     * Parse the requested includes and pluck only those that are valid.
     *
     * Note that this will only include relations that are two levels deep.
     * Anything requested greater than two levels deep will be truncated.
     *
     * @param string $includes The requested includes in csv format
     *
     * @return array
     */
    public function parseIncludes(string $includes): array
    {
        $defaultIncludes = $this->getDefaultIncludes();
        $validIncludes = [];

        foreach (explode(',', $includes) as $rawInclude) {
            $include = Str::camel($rawInclude);

            /*
             * If the relations are nested more than two levels deep from the resource,
             * extract only the first two relations to limit the strain on the system.
             * If a user is attempting to pull more than the second distant relation,
             * they should look into restructuring their requests for optimizations.
             */
            if (substr_count($include, '.') > 2) {
                $pieces = explode('.', $include);

                $include = implode('.', array_slice($pieces, 0, 3));
            }

            if ($this->validateInclude($include)) {
                $validIncludes[] = $include;
            }
        }

        return array_unique(array_merge(
            $defaultIncludes,
            $validIncludes
        ));
    }

    /**
     * Validate the includes against what is explicitly defined on the model.
     *
     * @param string     $include The requested include
     * @param Model|null $model   The model to validate the include against
     *
     * @return bool
     */
    public function validateInclude(string $include, ?Model $model = null): bool
    {
        $model = $model ?: $this;

        $availableIncludes = $model->getAvailableIncludes();

        if (strpos($include, '.') !== false) {
            $includeArray = explode('.', $include, 2);

            if (! in_array($includeArray[0], $availableIncludes)) {
                return false;
            }

            return $this->validateInclude(
                $includeArray[1],
                $model->{$includeArray[0]}()->getRelated()
            );
        }

        return in_array($include, $availableIncludes);
    }
}