<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Google\Cloud\Samples\Vision;

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

$application = new Application('Product Search');

// detect audio intent command
$application->add((new Command('product-set-import'))
    ->addArgument('project-id', InputArgument::REQUIRED,
        'Project/agent id. Required.')
    ->addOption('session-id', 's', InputOption::VALUE_REQUIRED,
        'Identifier of the DetectIntent session. Defaults to random.')
    ->addOption('language-code', 'l', InputOption::VALUE_REQUIRED,
        'Language code of the query. Defaults to "en-US".', 'en-US')
    ->addArgument('path', InputArgument::REQUIRED, 'Path to audio file.')
    ->setDescription('Detect intent of audio file using Dialogflow.')
    ->setHelp(<<<EOF
The <info>%command.name%</info> command detects the intent of provided audio 
using Dialogflow.
    <info>php %command.full_name% PROJECT_ID [-s SESSION_ID] 
    [-l LANGUAGE-CODE] AUDIO_FILE_PATH</info>
EOF
    )
    ->setCode(function ($input, $output) {
        $projectId = $input->getArgument('project-id');
        $sessionId = $input->getOption('session-id');
        $languageCode = $input->getOption('language-code');
        $path = $input->getArgument('path');
        detect_intent_audio($projectId, $path, $sessionId, $languageCode);
    })
);


// for testing
if (getenv('PHPUNIT_TESTS') === '1') {
    return $application;
}

$application->run();