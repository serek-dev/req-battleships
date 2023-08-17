<?php

declare(strict_types=1);


namespace App\UI;


use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Output\OutputInterface;

final class GridRenderer
{
    private const HIT_OBJECT = [
        'id' => 'H',
        'symbol' => '◼',
        'color' => 'green',
    ];

    private const MISSED_OBJECT = [
        'id' => 'M',
        'symbol' => 'x',
        'color' => 'red'
    ];

    private const REVEALED_SHIP = [
        'id' => 'R',
        'symbol' => '▢',
        'color' => 'gray'
    ];

    /** @var int[] */
    private array $shipIds;

    public function __construct(private readonly bool $show = false, int ...$shipIds)
    {
        $this->shipIds = $shipIds;
    }

    public function renderTable(OutputInterface $output, iterable $grid): void
    {
        $style = new TableStyle();
        $style->setBorderFormat('<fg=gray>%s</>');

        $table = new Table($output);
        $table
            ->setStyle($style)
            ->setHeaders(
                array_merge(['#'], range('A', 'J'))
            );

        $colors = [
            self::HIT_OBJECT['id'] => [
                'style' => new TableCellStyle([
                    'fg' => self::HIT_OBJECT['color'],
                    'align' => 'center'
                ])
            ],
            self::MISSED_OBJECT['id'] => [
                'style' => new TableCellStyle([
                    'fg' => self::MISSED_OBJECT['color'],
                    'align' => 'center'
                ])
            ],
            self::REVEALED_SHIP['id'] => [
                'style' => new TableCellStyle([
                    'fg' => self::REVEALED_SHIP['color'],
                    'align' => 'center'
                ])
            ],
        ];

        foreach ($grid as $row => $gridData) {
            $cells = [];
            $cells[] = new TableCell(
                value: (string)$row,
                options: [
                    'style' => new TableCellStyle([
                        'fg' => 'green',
                        'align' => 'left'
                    ])
                ]
            );

            foreach ($gridData as $objectId) {
                if ($this->isShip($objectId) && !$this->show) {
                    $cells[] = new TableCell(
                        value: ' ',
                    );
                    continue;
                }

                if (is_null($objectId)) {
                    $cells[] = new TableCell(
                        value: ' ',
                    );
                    continue;
                }

                if ($objectId === self::HIT_OBJECT['id']) {
                    $cells[] = new TableCell(
                        value: self::HIT_OBJECT['symbol'],
                        options: $colors[$objectId]
                    );
                    continue;
                }

                if ($objectId === self::MISSED_OBJECT['id']) {
                    $cells[] = new TableCell(
                        value: self::MISSED_OBJECT['symbol'],
                        options: $colors[$objectId]
                    );
                    continue;
                }

                $cells[] = new TableCell(
                    value: self::REVEALED_SHIP['symbol'],
                    options: $colors[self::REVEALED_SHIP['id']]
                );
            }
            $table->addRow($cells);
        }

        $table->render();
    }

    private function isShip(int|string|null $objectId): bool
    {
        return in_array($objectId, $this->shipIds);
    }
}
