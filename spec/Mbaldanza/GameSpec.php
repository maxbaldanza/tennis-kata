<?php

namespace spec\Mbaldanza;

use MBaldanza\Player;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GameSpec extends ObjectBehavior
{
    private $player1;
    private $player2;

    const PLAYER_ONE_NAME = 'Player 1';
    const PLAYER_TWO_NAME = 'Player 2';

    function let()
    {
        $player1 = new Player(self::PLAYER_ONE_NAME);
        $player2 = new Player(self::PLAYER_TWO_NAME);
        $this->beConstructedWith($player1, $player2);
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Mbaldanza\Game');
    }

    function it_should_return_zero_at_start()
    {
        $this->getScore()->shouldReturn("0,0");
    }

    function it_should_return_15_after_player_1_wins_first_point()
    {
        $this->createScore(1, 0);
        $this->getScore()->shouldReturn('15,0');
    }

    function it_should_return_15_after_player_2_wins_first_point()
    {
        $this->createScore(0, 1);
        $this->getScore()->shouldReturn('0,15');
    }

    function it_should_return_15_15_after_both_players_score()
    {
        $this->createScore(1, 1);

        $this->getScore()->shouldReturn('15,15');
    }

    function it_should_return_30_after_player_2_wins_first_two_points()
    {
        $this->createScore(0, 2);

        $this->getScore()->shouldReturn('0,30');
    }

    function it_should_return_40_after_player_1_wins_first_three_points()
    {
        $this->createScore(3, 0);

        $this->getScore()->shouldReturn('40,0');
    }

    function it_should_return_deuce_after_three_points_each()
    {
        $this->createScore(3, 3);
        $this->getScore()->shouldReturn('Deuce');
    }

    function it_tests_player_one_wins_game()
    {
        $this->createScore(4, 0);

        $this->getScore()->shouldReturn(self::PLAYER_ONE_NAME . ' wins the game');
    }

    function it_tests_player_two_wins_game()
    {
        $this->createScore(2,4);

        $this->getScore()->shouldReturn(self::PLAYER_TWO_NAME . ' wins the game');
    }

    function it_tests_player_1_has_advantage()
    {
        $this->createScore(4, 3);

        $this->getScore()->shouldReturn(self::PLAYER_ONE_NAME . ' has advantage');
    }

    function it_tests_player_2_has_advantage()
    {
        $this->createScore(5, 6);

        $this->getScore()->shouldReturn(self::PLAYER_TWO_NAME . ' has advantage');
    }

    function it_tests_deuce_after_advantage()
    {
        $this->createScore(4, 4);

        $this->getScore()->shouldReturn('Deuce');
    }

    function it_tests_win_after_advantage()
    {
        $this->createScore(4, 6);

        $this->getScore()->shouldReturn(self::PLAYER_TWO_NAME . ' wins the game');
    }

    function it_tests_exception_for_invalid_score()
    {
        $this->createScore(4, 4);
        $player1 = new Player(self::PLAYER_ONE_NAME);

        $this->shouldThrow('\InvalidArgumentException')->duringTranslateScore($player1);
    }

    function it_tests_exception_for_invalid_player()
    {
        $invalidPlayer = new Player('test');

        $this->shouldThrow('\InvalidArgumentException')->duringTranslateScore($invalidPlayer);
    }

    private function createScore($player1Score, $player2Score)
    {
        for ($i = 0; $i < $player1Score; $i++) {
            $this->wonPoint($this->player1);
        }

        for ($i = 0; $i < $player2Score; $i++) {
            $this->wonPoint($this->player2);
        }
    }

}
