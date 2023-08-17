# Battleships

## Play

```bash
docker-compose run --rm lib play
# or
make play
```

![live-play.gif](docs%2Flive-play.gif)

## Reveal mode

If you want to reveal the board (show where the ships actually are), change the env variable `SHOW` value in
_docker-compose.yml_.

![live-show.gif](docs%2Flive-show.gif)

## Task
Task: https://medium.com/guestline-labs/hints-for-our-interview-process-and-code-test-ae647325f400

```text
The challenge is to program a simple version of the game Battleships (video). Create an application to allow a single human player to play a one-sided game of Battleships against ships placed by the computer.

The program should create a 10x10 grid, and place several ships on the grid at random with the following sizes:

1x Battleship (5 squares)

2x Destroyers (4 squares)

The player enters or selects coordinates of the form “A5”, where “A” is the column and “5” is the row, to specify a square to target. Shots result in hits, misses or sinks. The game ends when all ships are sunk.

You can write a console application or UI to complete the task.

Try to code the challenge as you would approach any typical work task; we are not looking for you to show knowledge of frameworks or unusual programming language features. Most importantly, keep it simple.

Please include a link to the source and instructions on how to build and run it.
```

## Assumptions

1. The game will render randomly 1x Battleship or 2x Destroyers in horizontal / vertical position.
2. Ships are represented just as simple square.
3. There is no special padding between ships, but ships can not overlap each other.
4. Once the game finishes, it will close the input.

## Building blocks / layers

1. `Command CLI` + Console Table renderer to make the code more readable.
2. `Facade` - an entry point, receives user input (primitive types), transforms to more sophisticated objects and passes
   to the service.
3. `Service` - app logic, mutates a dependent `Grid` with _HIT, MISS_ - instructions, returns attempt status.
4. `RandomGridFactory` - class helper, that generates `Grid` with required `Ships` on.
5. `Ship` - represents a ship, with it's _ID, length, count_.

## Usage

Use `Makefile` if you have or explore the commands in it, to use _docker-compose_ directly:

```text
bash                           Runs container in bash mode
start                          Start local env and tests
tests                          Runs all tests to prove it works :)
tests_acceptance               Runs acceptance test
tests_unit                     Runs unit tests
```

```bash
php -v
```

```text
PHP 8.1.8 (cli) (built: Jul 11 2022 08:29:57) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.1.8, Copyright (c) Zend Technologies
    with Zend OPcache v8.1.8, Copyright (c), by Zend Technologies
```
