<?php

declare(strict_types=1);


namespace App\UI;


use App\Facade\FacadeInterface;
use App\Facade\Result;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand('app:play')]
final class PlayCommand extends Command
{
    public function __construct(private readonly FacadeInterface $facade, private readonly GridRenderer $gridRenderer)
    {
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $grid = $this->facade->start();

        /** @var ConsoleSectionOutput $gridSection */
        $gridSection = $output->section();
        /** @var ConsoleSectionOutput $gridSection */
        $promptSection = $output->section();
        /** @var ConsoleSectionOutput $gridSection */
        $lastResultSection = $output->section();

        $gridSection->writeln('Hello, lets play ...');
        sleep(1);

        $gridSection->clear();

        $style = new TableStyle();
        $style->setBorderFormat('<fg=gray>%s</>');

        for (; ;) {
            $gridSection->clear();
            $promptSection->clear();

            $this->gridRenderer->renderTable($gridSection, $grid);

            $helper = $this->getHelper('question');
            $question = new Question('Where to hit?: ');

            $pos = $helper->ask($input, $promptSection, $question);

            $result = $this->facade->hit($pos);

            $status = $result->status;
            $color = in_array($status, [Result::WON, Result::HIT]) ? 'fg=green' : 'error';
            $lastResultSection->writeln(sprintf('<%s>%s</%s>', $color, $status, $color));

            if (in_array($result->status, [Result::ERROR, Result::IGNORED])) {
                $lastResultSection->write('<error>' . $result->details . '</error>');
            }

            sleep(1);

            $lastResultSection->clear();

            $grid = $result->grid;

            if ($pos === 'q' || $result->status === Result::WON) {
                $lastResultSection->write('<success>YOU WON!</success>');
                break;
            }
        }

        return Command::SUCCESS;
    }
}
