@extends('layout')

@section('content')
<x-navbar>
</x-navbar>
    <!-- Main Content -->
    <div class="container mx-auto p-4 flex justify-center mt-6">
        <div class="w-full max-w-4xl bg-white p-6 rounded-lg shadow-lg text-black">
            <h1 class="text-center text-2xl font-semibold mb-6">Frequently Asked Questions</h1>
            <div class="space-y-4">

                <!-- FAQ Item 1 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq1')">
                        <span>What is DeskUp?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq1" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        DeskUp is an adjustable desk system that allows you to switch between sitting and standing positions effortlessly. It promotes a healthier working style.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq2')">
                        <span>How do I adjust the desk height?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq2" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        You can adjust the desk height using the control panel on the DeskUp app or the physical buttons on the desk. The desk allows you to customize the height between 68 cm and 132 cm.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq3')">
                        <span>What are the benefits of standing desks?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq3" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        Standing desks can help improve posture, increase energy levels, and reduce the risk of back pain. They also encourage more movement during the workday, which benefits overall health.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq4')">
                        <span>Can I save custom height presets?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq4" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        Yes, DeskUp allows you to save sitting and standing height presets. Use the "Presets" feature in the control panel to set and save your preferred heights.
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div>
                    <button class="w-full flex justify-between items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="toggleFaq('faq5')">
                        <span>Does DeskUp track my activity?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="faq5" class="hidden mt-2 p-4 bg-gray-100 text-black rounded-md">
                        Yes, DeskUp includes an activity tracker to monitor how much time you spend sitting and standing, helping you maintain a balanced work routine.
                    </div>
                <div class="flex justify-center mt-6">
                    <form action="{{ route('ui') }}" method="GET">
                        <button href="ui" class="w-full justify-center items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600" onclick="">
                            Go back
                        </button>
                    </form>
                    
            </div>
        </div>
    </div>

    <script>
        function toggleFaq(faqId) {
            const faq = document.getElementById(faqId);
            if (faq.classList.contains('hidden')) {
                faq.classList.remove('hidden');
            } else {
                faq.classList.add('hidden');
            }
        }
        
    </script>
@endsection
