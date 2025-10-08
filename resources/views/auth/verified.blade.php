@extends('layout.app')

@section('content')
    <!-- component -->
    <div class="flex h-screen">
        <!-- Right Pane -->
        <div class="w-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 lg:w-1/2 flex items-center justify-center">
            <div class="max-w-md w-full p-6">
                <div class="block items-center justify-center">
                    <div class="text-sm font-semibold mb-6 text-gray-500">
                        <a href="{{url('/')}}" class="flex justify-center items-center">
                            <img src="{{$setting->logo->address??'https://flowbite.com/docs/images/logo.svg'}}" alt="{{$setting->title}}" class="h-20 rounded-full">
                        </a>
                    </div>
                    <h1 class="text-xl font-semibold mb-6 text-black text-center dark:text-stone-100">
                        احراز هویت
                    </h1>
                    <p class="text-sm font-semibold mb-6 text-black text-center dark:text-stone-100">
                        کد تایید برای
                        <span class="text-yellow-600 px-2">{{request()->session()->get('auth')['mobile']??request()->session()->get('auth')['email']??''}}</span>
                        ارسال شد
                    </p>
                </div>
                <div class="mx-auto space-y-6">
                    <form action="{{route('verify')}}" method="POST" dir="ltr" class="text-center" autocomplete="off" id="validate">
                        @csrf
                        <input type="hidden" @if(session()->get('auth')['mobile']) name="mobile" @else name="email" @endif  value="{{session()->get('auth')['mobile']?session()->get('auth')['mobile']:session()->get('auth')['email']}}">
                        <input type="hidden" name="combined_digits" id="combined_digits">
                        <div>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="digit-1" maxlength="1" class="digit-input inline-flex items-center m-1 justify-center text-center border rounded-md w-12 h-12 px-3 py-2 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="digit-2" maxlength="1" class="digit-input inline-flex items-center m-1 justify-center text-center border rounded-md w-12 h-12 px-3 py-2 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="digit-3" maxlength="1" class="digit-input inline-flex items-center m-1 justify-center text-center border rounded-md w-12 h-12 px-3 py-2 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="digit-4" maxlength="1" class="digit-input inline-flex items-center m-1 justify-center text-center border rounded-md w-12 h-12 px-3 py-2 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="digit-5" maxlength="1" class="digit-input inline-flex items-center m-1 justify-center text-center border rounded-md w-12 h-12 px-3 py-2 border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-purple-400 text-dark p-2 dark:text-black rounded-md hover:bg-purple-600 focus:outline-none focus:bg-black focus:text-white focus:ring-2 focus:ring-offset-2 focus:ring-purple-600 transition-colors duration-300 my-2">
                                تایید
                            </button>
                        </div>
                    </form>
                    <div class="text-center">
                        <div class="text-sm font-light leading-none text-center text-gray-400">
                            <h6 id="sendAgain" class="hidden text-sm font-light leading-none text-center text-gray-400 p-2 m-2">
                                <a href="{{route('resend.code')}}" class="text-decoration-none text-xl text-purple-600">ارسال دوباره کد</a>
                            </h6>
                            <div id="timeDown" class="flex justify-center items-center text-center">
                                <div><i class="fa fa-clock fa-xl px-2"></i></div>
                                <div id="countdown" dir="ltr" class="text-xl text-purple-600">00:00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Left Pane -->
        @include('layout.left')
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const countDownDate = new Date("{{ \Carbon\Carbon::now()->addMinutes(2)->format('Y-m-d H:i:s') }}").getTime();
            const countdownFunction = setInterval(() => {
                // Get today's date and time
                const now = new Date().getTime();

                // Find the distance between now and the countdown date
                const distance = countDownDate - now;

                // Time calculations for minutes and seconds
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="countdown"
                document.getElementById('countdown').innerHTML = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // If the countdown is over, write some text
                if (distance < 0) {
                    clearInterval(countdownFunction);
                    document.getElementById('timeDown').classList.add('hidden');
                    document.getElementById('sendAgain').classList.remove('hidden');
                }
            }, 1000);

            const form = document.getElementById('validate');
            const combinedInput = document.getElementById('combined_digits');
            const digitInputs = form.querySelectorAll('input[type="text"]');
            const updateCombinedInput = () => {
                let combinedValue = '';
                let allFilled = true;

                digitInputs.forEach(digitInput => {
                    if (digitInput.value === '') {
                        allFilled = false;
                    }
                    combinedValue += digitInput.value;
                });

                combinedInput.value = combinedValue;

                // if (allFilled) {
                //     form.submit();
                // }
            };
            digitInputs.forEach(input => {
                input.addEventListener('input', updateCombinedInput);
            });

        });
        document.querySelectorAll('.digit-input').forEach((input, index, array) => {
            input.addEventListener('input', function() {
                if (this.value.length === this.maxLength) {
                    const nextInput = array[index + 1];
                    if (nextInput) {
                        nextInput.focus();
                    }
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value === '') {
                    const prevInput = array[index - 1];
                    if (prevInput) {
                        prevInput.focus();
                        prevInput.value = '';  // Clear the previous input
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus on the first input
            document.querySelector('input[name="digit-1"]').focus();

            // Add event listeners to all digit inputs
            const digitInputs = document.querySelectorAll('.digit-input');

            digitInputs.forEach((input, index) => {
                // Auto-move to next input after entry
                input.addEventListener('input', function() {
                    if (this.value.length === 1) {
                        // Move to next input if available
                        if (index < digitInputs.length - 1) {
                            digitInputs[index + 1].focus();
                        }
                    }

                    // Combine all digits on any change
                    combineDigits();
                });

                // Handle backspace key
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        // Move to previous input if current is empty
                        digitInputs[index - 1].focus();
                    }
                });
            });

            // Before form submission, combine the digits
            document.getElementById('validate').addEventListener('submit', function(e) {
                combineDigits();
            });

            // Function to combine digits into the hidden field
            function combineDigits() {
                let combined = '';
                digitInputs.forEach(input => {
                    combined += input.value;
                });
                document.getElementById('combined_digits').value = combined;
            }
        });
    </script>
@endsection
