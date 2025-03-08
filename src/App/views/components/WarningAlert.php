<div class="space-y-2 p-4">
    <div
        role="alert"
        class="bg-yellow-100 dark:bg-yellow-900 border-l-4 border-yellow-500 dark:border-yellow-700 text-yellow-900 dark:text-yellow-100 p-2 rounded-lg flex items-center transition duration-300 ease-in-out hover:bg-yellow-200 dark:hover:bg-yellow-800 transform hover:scale-105">
        <svg
            stroke="currentColor"
            viewBox="0 0 24 24"
            fill="none"
            class="h-5 w-5 flex-shrink-0 mr-2 text-yellow-600"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M13 16h-1v-4h1m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                stroke-width="2"
                stroke-linejoin="round"
                stroke-linecap="round"></path>
        </svg>
        <p class="text-xs font-semibold">
            <?=$msg ?? 'Warning - Something went wrong.' ?>
        </p>
    </div>
</div>