<?php

namespace App\Services;

use App\Models\ProjectService;

class DockerGenerator
{
    public function generateComposeFile(ProjectService $service): string
    {
        $rawYaml = $service->stack->raw_compose_template;

        $userVariables = $service->input_variables ?? [];

        $finalYaml = $rawYaml;

        foreach ($userVariables as $key => $value) {
            $placeholder = '${' . $key . '}';

            $finalYaml = str_replace($placeholder, $value, $finalYaml);
        }

        return $finalYaml;
    }
}
