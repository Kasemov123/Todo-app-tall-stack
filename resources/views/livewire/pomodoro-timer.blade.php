<div x-data="{
    timeLeft: {{ $timeLeft }},
    isRunning: false,
    interval: null,
    workDuration: {{ $workDuration }},
    
    init() {
        this.timeLeft = this.workDuration * 60;
    },
    
    get formattedTime() {
        const minutes = Math.floor(this.timeLeft / 60);
        const seconds = this.timeLeft % 60;
        return minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
    },
    
    start() {
        if (this.interval) clearInterval(this.interval);
        this.isRunning = true;
        this.interval = setInterval(() => {
            if (this.timeLeft > 0) {
                this.timeLeft--;
            } else {
                this.complete();
            }
        }, 1000);
    },
    
    pause() {
        this.isRunning = false;
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    },
    
    reset() {
        this.pause();
        this.timeLeft = this.workDuration * 60;
    },
    
    complete() {
        this.pause();
        alert('Time is up!');
    },
    
    updateDuration(work) {
        this.pause();
        this.workDuration = work;
        this.timeLeft = work * 60;
    }
}" x-init="init()" class="max-w-2xl mx-auto">
    <!-- Timer Presets -->
    <div class="bg-white rounded-lg p-6 mb-6 shadow-sm">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pomodoro Timer</h2>
        
        <div class="flex space-x-4 mb-6">
            <button 
                @click="updateDuration(25); $wire.setDuration(25, 5)"
                class="px-4 py-2 rounded-lg {{ $workDuration == 25 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                25/5 min
            </button>
            <button 
                @click="updateDuration(50); $wire.setDuration(50, 10)"
                class="px-4 py-2 rounded-lg {{ $workDuration == 50 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                50/10 min
            </button>
        </div>

        <!-- Timer Display -->
        <div class="text-center mb-8">
            <div class="relative w-64 h-64 mx-auto mb-6">
                <!-- Circular Progress -->
                <svg class="w-64 h-64 transform -rotate-90" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" stroke="#e5e7eb" stroke-width="2" fill="none"/>
                    <circle 
                        cx="50" cy="50" r="45" 
                        stroke="#3b82f6"
                        stroke-width="3" 
                        fill="none"
                        stroke-linecap="round"
                        stroke-dasharray="283"
                        :stroke-dashoffset="283 - ((workDuration * 60 - timeLeft) / (workDuration * 60) * 283)"
                        class="transition-all duration-1000 ease-linear"/>
                </svg>
                
                <!-- Timer Text -->
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <div class="text-4xl font-bold text-gray-900" x-text="formattedTime"></div>
                    <div class="text-sm text-gray-600 mt-2">
                        {{ $isBreak ? 'Break Time' : 'Work Time' }}
                    </div>
                </div>
            </div>

            <!-- Control Buttons -->
            <div class="flex justify-center space-x-4 mb-6">
                <template x-if="!isRunning">
                    <button 
                        @click="start()"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                        Start
                    </button>
                </template>
                
                <template x-if="isRunning">
                    <button 
                        @click="pause()"
                        class="bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700">
                        Pause
                    </button>
                </template>
                
                <button 
                    @click="reset()"
                    class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700">
                    Reset
                </button>
            </div>

            <!-- Session Counter -->
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600 mb-1">Completed Sessions Today</div>
                <div class="text-2xl font-bold text-gray-900">{{ $completedSessions }}</div>
            </div>
        </div>
    </div>


</div>