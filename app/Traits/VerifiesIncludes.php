<?php

namespace App\Traits;

use App\Models\Model;
use Illuminate\Support\Str;

trait VerifiesIncludes
{
    /**
     * The relations that are available to include with the resource.
     *
     * @var array<int, string>
     */
    protected $availableIncludes = [];

    /**
     * The default relations to include with the resource.
     *
     * @var array<int, string>
     */
    protected $defaultIncludes = [];

    /**
     * Get the relations that are available to include with the resource.
     *
     * @return array<int, string>
     */
    public function getAvailableIncludes(): array
    {
        return $this->availableIncludes;
    }

    /**
     * Get the default relations to include with the resource.
     *
     * @return array<int, string>
     */
    public function getDefaultIncludes(): array
    {
        return $this->defaultIncludes;
    }

    /**
     * Verifies the provided includes and returns a sanitized array of valid options.
     *
     * Note that this will only include relations that are two levels deep.
     * Anything requested greater than two levels deep will be truncated.
     *
     * @param array<int, string> $unverified The includes to be verified
     *
     * @return array<int, string>
     */
    public function verifyIncludes(array $unverified): array
    {
        $verified = [];

        foreach ($unverified as $include) {
            $include = Str::camel($include);

            /*
             * If the relations are nested more than two levels deep from the resource,
             * extract only the first two relations to limit the strain on the system.
             * If a user is attempting to pull more than the second nested relation,
             * they should look into restructuring their requests for optimizations.
             */
            if (substr_count($include, '.') > 2) {
                $pieces = explode('.', $include);

                $include = implode('.', array_slice($pieces, 0, 3));
            }

            if ($this->verifyInclude($include)) {
                $verified[] = $include;
            }
        }

        return array_unique(
            array_merge($this->getDefaultIncludes(), $verified)
        );
    }

    /**
     * Verifies and individual include to determine if it exists on the model.
     *
     * @param string     $unverified The include to be verified
     * @param Model|null $model      The model to validate the include against
     *
     * @return bool
     */
    public function verifyInclude(string $unverified, ?Model $model = null): bool
    {
        $model = $model ?: $this;

        $availableIncludes = $model->getAvailableIncludes();

        // If we have a `.` in the string, we're looking for a nested relation.
        if (strpos($unverified, '.') !== false) {
            // If we have a nested relation, extract the direct relation, along with the nested relation(s).
            // Note that we do not want to extract the nested relation further as that will be done recursively.
            $includes = explode('.', $unverified, 2);

            // If the direct relation is not present on *this* model, we can ignore the nested relation.
            if (! in_array($includes[0], $availableIncludes)) {
                return false;
            }

            // In the event the direct relation *does* exist, we want to verify any nested relations in the same way.
            return $this->verifyInclude(
                $includes[1],
                $model->{$includes[0]}()->getRelated()
            );
        }

        return in_array($unverified, $availableIncludes);
    }
}
