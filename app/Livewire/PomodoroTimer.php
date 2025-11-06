<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PomodoroSession;

class PomodoroTimer extends Component
{
    public $workDuration = 25;
    public $breakDuration = 5;
    public $completedSessions = 0;
    public $isRunning = false;
    public $isBreak = false;
    public $timeLeft = 1500; // 25 minutes in seconds
    
    public function mount()
    {
        $session = auth()->user()->pomodoroSessions()->latest()->first();
        if ($session) {
            $this->workDuration = $session->work_duration;
            $this->breakDuration = $session->break_duration;
            $this->completedSessions = $session->completed_sessions;
        }
        $this->timeLeft = $this->workDuration * 60;
    }

    public function setDuration($work, $break)
    {
        $this->workDuration = $work;
        $this->breakDuration = $break;
        $this->timeLeft = $this->workDuration * 60;
        $this->isRunning = false;
        $this->isBreak = false;
        $this->saveSession();
    }

    public function startTimer()
    {
        $this->isRunning = true;
    }

    public function pauseTimer()
    {
        $this->isRunning = false;
    }

    public function resetTimer()
    {
        $this->isRunning = false;
        $this->isBreak = false;
        $this->timeLeft = $this->workDuration * 60;
    }

    public function completeSession()
    {
        if (!$this->isBreak) {
            $this->completedSessions++;
            $this->isBreak = true;
            $this->timeLeft = $this->breakDuration * 60;
        } else {
            $this->isBreak = false;
            $this->timeLeft = $this->workDuration * 60;
        }
        $this->isRunning = false;
        $this->saveSession();
    }

    private function saveSession()
    {
        auth()->user()->pomodoroSessions()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'work_duration' => $this->workDuration,
                'break_duration' => $this->breakDuration,
                'completed_sessions' => $this->completedSessions,
            ]
        );
    }

    public function getFormattedTimeProperty()
    {
        $minutes = floor($this->timeLeft / 60);
        $seconds = $this->timeLeft % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function render()
    {
        return view('livewire.pomodoro-timer');
    }
}
