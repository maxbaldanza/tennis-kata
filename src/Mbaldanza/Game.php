<?php

namespace MBaldanza;

use Symfony\Component\Process\Exception\InvalidArgumentException;

class Game
{
    protected $player1;
    protected $player2;
    protected $player1Score = 0;
    protected $player2Score = 0;

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * Shows the current score or if someone has already won based on the score
     * @return string
     */
    public function getScore()
    {
        if (($winner = $this->haveWinner()) !== false) {
            return sprintf('%s wins the game', $winner->getName());
        }

        if ($this->isDeuce()) {
            return 'Deuce';
        }

        if (($advantage = $this->hasAdvantage()) !== false) {
            return sprintf('%s has advantage', $advantage->getName());
        }

        return $this->translateScore($this->player1)
                . ',' .
                $this->translateScore($this->player2);
    }

    /**
     * Checks to see if current scores equals deuce
     * @return bool
     */
    public function isDeuce()
    {
        return $this->player1Score >= 3 && $this->player2Score == $this->player1Score;
    }

    /**
     * Checks to see if a player has advantage after deuce
     * @return bool|Player
     */
    public function hasAdvantage()
    {
        if ($this->player1Score >= 4 && $this->player1Score == $this->player2Score + 1) {
            return $this->player1;
        }
        if ($this->player2Score >= 4 && $this->player2Score == $this->player1Score + 1) {
            return $this->player2;
        }
        return false;
    }

    /**
     * Checks to see if a player has won
     * @return bool|Player
     */
    public function haveWinner()
    {
        if ($this->player1Score >= 4 && $this->player1Score >= $this->player2Score + 2) {
            return $this->player1;
        }
        if ($this->player2Score >= 4 && $this->player2Score >= $this->player1Score + 2) {
            return $this->player2;
        }
        return false;
    }

    /**
     * Translates the score into readable human format
     * @param Player $player
     * @return string
     */
    public function translateScore(Player $player)
    {
        $score = null;
        if ($player == $this->player1) {
            $score = $this->player1Score;
        } elseif ($player == $this->player2) {
            $score = $this->player2Score;
        }

        if ($score === null){
            throw new \InvalidArgumentException(sprintf('Player %s is not valid', $player->getName()));
        }

        switch ($score) {
            case 1:
                return '15';
            case 2:
                return '30';
            case 3:
                return '40';
            case 0:
                return '0';
            default:
                throw new \InvalidArgumentException(sprintf('Player %s score is not valid', $player->getName()));
        }
    }

    /**
     * Player one scores a point
     */
    public function playerOneScore()
    {
        $this->player1Score++;
    }

    /**
     * Player two scores a point
     */
    public function playerTwoScore()
    {
        $this->player2Score++;
    }
}
