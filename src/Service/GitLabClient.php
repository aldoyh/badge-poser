<?php

namespace App\Service;

use App\Badge\Exception\RepositoryDataNotValid;
use Gitlab\Client;

final class GitLabClient implements GitLabClientInterface
{
    public function __construct(private Client $gitlabClient, private string $gitLabToken)
    {
        $this->gitlabClient->authenticate($this->gitLabToken, Client::AUTH_HTTP_TOKEN);
    }

    public function show(string $project): array
    {
        $repositoryData = $this->gitlabClient->projects()->show($project);
        if (!\is_array($repositoryData)) {
            throw new RepositoryDataNotValid('Repository data not valid: '.\json_encode($repositoryData));
        }

        return $repositoryData;
    }
}
