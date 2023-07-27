<div class="space-y-3">
    <!--
    UI by:
    Date : 29 November 2021
    Author : Saad Hasan
    Github : https://github.com/saadh393
    Title : Accordion UI Design
    External Plugin : Font Awesome
    Actual Design Source : https://dribbble.com/shots/14726947-Accordion-UI-Design

    Special Thanks and Love to Ildiko Gaspar
    -->
    @if($data['faqs'] !== null)
        @foreach($data['faqs'] as $faq)
            <div class="transition rounded-xl hover:bg-gray-100 bg-gray-50">
                <div class="accordion-header cursor-pointer transition flex space-x-5 px-5 items-center h-16">
                    @svg('heroicon-o-chevron-down','w-5 h-5 text-secondary-600')
                    <h3 class="font-semibold">{{ $faq->question }}</h3>
                </div>
                <div class="accordion-content overflow-hidden max-h-0">
                    <div class="bg-white border border-gray-200 rounded-xl rounded-t-none leading-6 font-light text-justify p-4">
                        {!! $faq->answer !!}
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <style>
        .accordion-content {
            transition: max-height 0.3s ease-out, padding 0.3s ease;
        }
    </style>

    <script>
        const accordionHeader = document.querySelectorAll(".accordion-header");
        accordionHeader.forEach((header) => {
            header.addEventListener("click", function () {
                const accordionContent = header.parentElement.querySelector(".accordion-content");
                let accordionMaxHeight = accordionContent.style.maxHeight;

                // Condition handling
                if (accordionMaxHeight === "0px" || accordionMaxHeight.length === 0) {
                    accordionContent.style.maxHeight = `${accordionContent.scrollHeight + 32}px`;
                    header.parentElement.classList.add("bg-primary-50");
                } else {
                    accordionContent.style.maxHeight = `0px`;
                    header.parentElement.classList.remove("bg-primary-50");
                }
            });
        });
    </script>
</div>
