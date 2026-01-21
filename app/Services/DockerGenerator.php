<?php

namespace App\Services;

use App\Models\ProjectService;

class DockerGenerator
{
    public function generateComposeFile(ProjectService $service): string
    {
        $template = $service->stack->raw_compose_template;
        $networkName = "keystone-p{$service->project_id}-net";
        $safeServiceName = preg_replace('/[^a-z0-9_]/', '', strtolower($service->name));
        $replacements = [
            '${NETWORK_NAME}' => $networkName,
            '${SERVICE_NAME}' => $safeServiceName,
        ];

        $userVars = $service->input_variables ?? [];

        foreach ($service->stack->variables as $var) {
            $key = '${' . $var->env_key . '}';
            $value = $userVars[$var->env_key] ?? $var->default_value ?? '';
            $replacements[$key] = $value;
        }

        return strtr($template, $replacements);
    }
}
